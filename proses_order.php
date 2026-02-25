<?php
// ==================== PROSES ORDER ====================
// File: proses_order.php - VERSI FIX

require_once 'config/database.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

// Enable error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log request
error_log("PROSES ORDER STARTED: " . print_r($_POST, true));

try {
    // Validasi input
    $nama = sanitize($_POST['nama'] ?? '');
    $kelas = sanitize($_POST['kelas'] ?? '');
    $telepon = sanitize($_POST['telepon'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $jumlah = (int)($_POST['jumlah'] ?? 0);
    $link_drive = sanitize($_POST['link_drive'] ?? '');
    $catatan = sanitize($_POST['catatan'] ?? '');
    $jenis_layanan = $_POST['jenis_layanan'] ?? '';
    $ukuran = sanitize($_POST['ukuran'] ?? '');
    $jenis_sablon = sanitize($_POST['jenis_sablon'] ?? '');
    $warna_kaos = sanitize($_POST['warna_kaos'] ?? '');
    $ukuran_kertas = sanitize($_POST['ukuran_kertas'] ?? '');
    
    // Validasi dasar
    if (empty($nama) || empty($kelas) || empty($telepon) || empty($email) || empty($link_drive) || $jumlah < 1) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit;
    }
    
    if (!validateEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Email tidak valid']);
        exit;
    }
    
    if (!validatePhone($telepon)) {
        echo json_encode(['success' => false, 'message' => 'Nomor HP harus 10-13 digit']);
        exit;
    }
    
    if (empty($jenis_layanan)) {
        echo json_encode(['success' => false, 'message' => 'Jenis layanan tidak boleh kosong']);
        exit;
    }
    
    // Parse jenis layanan
    $parts = explode('_', $jenis_layanan);
    $layanan = $parts[0] ?? '';
    $jenis = isset($parts[1]) ? $parts[1] : '';
    
    error_log("LAYANAN: $layanan, JENIS: $jenis");
    
    // Data layanan
    $layananData = [
        'print_hitam' => ['nama' => 'Print Hitam Putih', 'harga' => 1000],
        'print_warna' => ['nama' => 'Print Full Color', 'harga' => 2000],
        'fotocopy' => ['nama' => 'Fotocopy', 'harga' => 250],
        'kaos_sablon' => [
            'nama' => 'Kaos & Sablon',
            'harga_kaos' => 50000,
            'harga_sablon' => 55000,
            'harga_paket' => 105000
        ]
    ];
    
    // Validasi layanan
    if (!isset($layananData[$layanan])) {
        error_log("LAYANAN TIDAK VALID: $layanan");
        echo json_encode(['success' => false, 'message' => 'Layanan tidak valid: ' . $layanan]);
        exit;
    }
    
    // Hitung harga
    if ($layanan === 'kaos_sablon') {
        if (empty($jenis)) {
            echo json_encode(['success' => false, 'message' => 'Jenis paket harus dipilih (kaos/sablon/paket)']);
            exit;
        }
        
        $hargaKey = 'harga_' . $jenis;
        if (!isset($layananData['kaos_sablon'][$hargaKey])) {
            echo json_encode(['success' => false, 'message' => 'Jenis paket tidak valid: ' . $jenis]);
            exit;
        }
        
        $hargaSatuan = $layananData['kaos_sablon'][$hargaKey];
        $serviceName = $layananData['kaos_sablon']['nama'] . ' (' . $jenis . ')';
    } else {
        $hargaSatuan = $layananData[$layanan]['harga'];
        $serviceName = $layananData[$layanan]['nama'];
    }
    
    $subtotal = $hargaSatuan * $jumlah;
    $uniqueCode = generateUniqueCode();
    $total = $subtotal + $uniqueCode;
    $orderNumber = generateOrderNumber();
    
    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO orders (
        order_number, customer_name, customer_class, customer_phone, customer_email,
        service, service_name, jumlah, ukuran, jenis_sablon, warna_kaos, ukuran_kertas,
        drive_link, catatan, harga_satuan, subtotal, unique_code, total,
        status, payment_status, created_at
    ) VALUES (
        ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?,
        'pending_payment', 'belum_bayar', NOW()
    )");
    
    $result = $stmt->execute([
        $orderNumber, $nama, $kelas, $telepon, $email,
        $layanan, $serviceName, $jumlah, $ukuran, $jenis_sablon, $warna_kaos, $ukuran_kertas,
        $link_drive, $catatan, $hargaSatuan, $subtotal, $uniqueCode, $total
    ]);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database']);
        exit;
    }
    
    // Log aktivitas
    logActivity($pdo, null, $nama, 'create_order', 'Membuat pesanan baru: ' . $orderNumber);
    
    // Return success
    echo json_encode([
        'success' => true,
        'order' => [
            'orderNumber' => $orderNumber,
            'nama' => $nama,
            'kelas' => $kelas,
            'total' => $total,
            'uniqueCode' => $uniqueCode,
            'serviceName' => $serviceName,
            'jumlah' => $jumlah
        ]
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage()]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
?>