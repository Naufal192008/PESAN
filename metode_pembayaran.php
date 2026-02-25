<?php
// ==================== METODE PEMBAYARAN ====================
// File: metode_pembayaran.php - VERSI FINAL

require_once 'config/database.php';
require_once 'includes/functions.php';

// Ambil order dari parameter URL
$orderNumber = $_GET['order'] ?? '';
$order = null;

if ($orderNumber) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
    $stmt->execute([$orderNumber]);
    $order = $stmt->fetch();
}

// Jika tidak ada order, redirect ke index
if (!$order) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Unit Produksi RPL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .payment-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #7f8c8d;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .order-summary h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #7f8c8d;
            font-weight: 500;
        }

        .summary-value {
            color: #2c3e50;
            font-weight: 600;
        }

        .total-amount {
            font-size: 24px;
            color: #667eea;
            font-weight: 800;
        }

        .method-title {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .method-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .method-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .method-card:hover {
            border-color: #667eea;
            transform: translateY(-3px);
        }

        .method-card.selected {
            border-color: #667eea;
            background: #e8f4fc;
        }

        .method-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .method-name {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .method-desc {
            font-size: 12px;
            color: #7f8c8d;
        }

        .dana-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 2px dashed #667eea;
        }

        .dana-number {
            font-size: 32px;
            font-weight: 800;
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            margin: 15px 0;
            border: 2px solid #667eea;
            color: #667eea;
        }

        .instruction-steps {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .upload-area {
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            background: #f8f9fa;
            margin: 20px 0;
            transition: all 0.3s;
        }

        .upload-area:hover {
            background: #e8f4fc;
        }

        .upload-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 10px;
        }

        .file-info {
            display: none;
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            align-items: center;
            gap: 15px;
        }

        .file-info.active {
            display: flex;
        }

        .btn-confirm {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-confirm:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
        }

        .btn-confirm:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .warning-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            color: #856404;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: white;
            text-decoration: none;
        }

        .timer-box {
            background: #1e293b;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: 600;
        }

        .timer-box.warning {
            background: #e74c3c;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @media (max-width: 768px) {
            .method-grid {
                grid-template-columns: 1fr;
            }
            .dana-number {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-card">
            <div class="header">
                <h1>PEMBAYARAN</h1>
                <p>Unit Produksi RPL - SMK Negeri 24 Jakarta</p>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="order-summary">
                <h3>Ringkasan Pesanan</h3>
                <div class="summary-item">
                    <span class="summary-label">No. Order:</span>
                    <span class="summary-value"><?php echo $order['order_number']; ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Layanan:</span>
                    <span class="summary-value"><?php echo $order['service_name']; ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Nama:</span>
                    <span class="summary-value"><?php echo $order['customer_name']; ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Jumlah:</span>
                    <span class="summary-value"><?php echo $order['jumlah']; ?> unit</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Bayar:</span>
                    <span class="summary-value total-amount">Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Kode Unik:</span>
                    <span class="summary-value"><?php echo $order['unique_code']; ?></span>
                </div>
            </div>

            <!-- Timer -->
            <div id="timerContainer">
                <div class="timer-box" id="timerBox">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Sisa waktu pembayaran: <strong id="paymentCountdown">10:00</strong></span>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="method-title">
                <i class="fas fa-credit-card"></i> Pilih Metode Pembayaran
            </div>

            <div class="method-grid">
                <div class="method-card selected" data-method="dana" onclick="selectMethod('dana')">
                    <div class="method-icon">
                        <i class="fas fa-wallet" style="color: #008080;"></i>
                    </div>
                    <div class="method-name">DANA</div>
                    <div class="method-desc">Transfer instan 24 jam</div>
                </div>
                
                <div class="method-card" data-method="bca" onclick="selectMethod('bca')">
                    <div class="method-icon">
                        <i class="fas fa-university" style="color: #004080;"></i>
                    </div>
                    <div class="method-name">BCA</div>
                    <div class="method-desc">Virtual Account</div>
                </div>
                
                <div class="method-card" data-method="mandiri" onclick="selectMethod('mandiri')">
                    <div class="method-icon">
                        <i class="fas fa-university" style="color: #003366;"></i>
                    </div>
                    <div class="method-name">Mandiri</div>
                    <div class="method-desc">Virtual Account</div>
                </div>
                
                <div class="method-card" data-method="bri" onclick="selectMethod('bri')">
                    <div class="method-icon">
                        <i class="fas fa-university" style="color: #0066cc;"></i>
                    </div>
                    <div class="method-name">BRI</div>
                    <div class="method-desc">Virtual Account</div>
                </div>
            </div>

            <!-- Informasi DANA -->
            <div id="danaInfo">
                <div class="dana-info">
                    <div style="text-align: center;">
                        <i class="fas fa-wallet" style="font-size: 48px; color: #008080;"></i>
                        <h4 style="margin-top: 10px;">PEMBAYARAN VIA DANA</h4>
                    </div>
                    
                    <div class="dana-number">
                        <?php echo DANA_NUMBER; ?>
                    </div>
                    
                    <div style="text-align: center; margin-bottom: 20px;">
                        a.n. <?php echo DANA_NAME; ?>
                    </div>
                    
                    <div class="instruction-steps">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div>Buka aplikasi DANA di ponsel Anda</div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div>Pilih menu "Kirim" atau "Transfer"</div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div>Masukkan nomor DANA: <strong><?php echo DANA_NUMBER; ?></strong></div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div>Masukkan jumlah: <strong>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></strong></div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">5</div>
                            <div>Pada catatan, tuliskan <strong>No. Order + Nama</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div style="margin-top: 25px;">
                <h4 style="margin-bottom: 15px;">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Bukti Pembayaran
                </h4>
                
                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div>Klik untuk upload screenshot bukti bayar</div>
                    <div style="font-size: 12px; color: #7f8c8d; margin-top: 5px;">
                        Format: JPG, PNG, PDF (Maks 5MB)
                    </div>
                    <input type="file" id="fileInput" accept="image/*,application/pdf" style="display: none;" onchange="handleFileSelect(this)">
                </div>
                
                <div class="file-info" id="fileInfo">
                    <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                    <div>
                        <strong id="fileName">File terpilih</strong><br>
                        <small id="fileSize">0 KB</small>
                    </div>
                    <button class="btn-remove" onclick="removeFile()" style="margin-left: auto; background: none; border: none; color: #155724; cursor: pointer;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Warning Box -->
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>PENTING!</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        <li>Transfer sesuai TOTAL BAYAR (termasuk kode unik)</li>
                        <li>Semua metode pembayaran ditujukan ke DANA</li>
                        <li>Pembayaran akan diverifikasi dalam 1x24 jam</li>
                    </ul>
                </div>
            </div>

            <!-- Tombol Konfirmasi -->
            <form id="paymentForm" enctype="multipart/form-data">
                <input type="hidden" name="order_number" value="<?php echo $order['order_number']; ?>">
                <input type="hidden" name="method" id="selectedMethod" value="dana">
                <button type="button" class="btn-confirm" onclick="confirmPayment()" id="confirmBtn" disabled>
                    <i class="fas fa-check-circle"></i> KONFIRMASI PEMBAYARAN
                </button>
            </form>

            <!-- Back Link -->
            <div class="back-link">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Konfigurasi
        const orderNumber = '<?php echo $order['order_number']; ?>';
        const totalAmount = <?php echo $order['total']; ?>;
        const DANA_NUMBER = '<?php echo DANA_NUMBER; ?>';
        
        // Variabel global
        let selectedMethod = 'dana';
        let selectedFile = null;
        let timerInterval = null;
        let waktuTersisa = 600; // 10 menit

        // Pilih metode
        function selectMethod(method) {
            selectedMethod = method;
            document.getElementById('selectedMethod').value = method;
            
            document.querySelectorAll('.method-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            document.querySelector(`[data-method="${method}"]`).classList.add('selected');
            
            if (method !== 'dana') {
                alert(`Untuk metode ${method.toUpperCase()}, transfer ke nomor DANA:\n\n${DANA_NUMBER}\na.n. UNIT PRODUKSI RPL`);
            }
            
            checkConfirmButton();
        }

        // Handle file upload
        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                if (file.size > 5 * 1024 * 1024) {
                    alert('File terlalu besar! Maksimal 5MB.');
                    input.value = '';
                    return;
                }
                
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipe file tidak didukung! Gunakan JPG, PNG, atau PDF.');
                    input.value = '';
                    return;
                }
                
                selectedFile = file;
                
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
                document.getElementById('fileInfo').classList.add('active');
                
                checkConfirmButton();
            }
        }

        function removeFile() {
            selectedFile = null;
            document.getElementById('fileInput').value = '';
            document.getElementById('fileInfo').classList.remove('active');
            checkConfirmButton();
        }

        function checkConfirmButton() {
            const confirmBtn = document.getElementById('confirmBtn');
            confirmBtn.disabled = !selectedFile;
        }

        // Timer
        function startPaymentTimer() {
            if (timerInterval) clearInterval(timerInterval);
            
            timerInterval = setInterval(() => {
                const menit = Math.floor(waktuTersisa / 60);
                const detik = waktuTersisa % 60;
                document.getElementById('paymentCountdown').textContent = 
                    `${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;
                
                if (waktuTersisa <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('timerBox').classList.add('warning');
                    document.getElementById('paymentCountdown').innerHTML = 'EXPIRED';
                    alert('Waktu pembayaran habis! Silakan pesan ulang.');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 2000);
                }
                
                if (waktuTersisa <= 60) {
                    document.getElementById('timerBox').classList.add('warning');
                }
                
                waktuTersisa--;
            }, 1000);
        }

        // Konfirmasi pembayaran
        function confirmPayment() {
            if (!selectedFile) {
                alert('Silakan upload bukti pembayaran terlebih dahulu!');
                return;
            }
            
            showLoading();
            
            const formData = new FormData();
            formData.append('action', 'confirm_payment');
            formData.append('order_number', orderNumber);
            formData.append('method', selectedMethod);
            formData.append('amount', totalAmount);
            formData.append('file', selectedFile);
            
            $.ajax({
                url: 'payment_ajax.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    hideLoading();
                    
                    if (response.success) {
                        alert('✅ Pembayaran berhasil dikonfirmasi! Pesanan akan segera diproses.');
                        window.location.href = 'index.php';
                    } else {
                        alert('❌ Gagal: ' + response.message);
                    }
                },
                error: function() {
                    hideLoading();
                    alert('❌ Terjadi kesalahan jaringan');
                }
            });
        }

        // Loading functions
        function showLoading() {
            const loading = document.createElement('div');
            loading.id = 'loading';
            loading.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                z-index: 99999;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            `;
            loading.innerHTML = `
                <div style="width: 60px; height: 60px; border: 5px solid rgba(255,255,255,0.1); border-top: 5px solid #667eea; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <div style="color: white; margin-top: 20px;">MEMPROSES...</div>
                <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
            `;
            document.body.appendChild(loading);
        }

        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) loading.remove();
        }

        // Init
        document.addEventListener('DOMContentLoaded', function() {
            startPaymentTimer();
        });
    </script>
</body>
</html>