<?php
// ==================== ORDER AJAX ====================
// File: order_ajax.php - VERSI FINAL

require_once 'config/database.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
if (!isset($_SESSION['admin_up_id']) && !isset($_SESSION['admin_pusat_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Tentukan user yang login
if (isset($_SESSION['admin_up_id'])) {
    $userId = $_SESSION['admin_up_id'];
    $username = $_SESSION['admin_up_username'];
    $role = 'admin_up';
} else {
    $userId = $_SESSION['admin_pusat_id'];
    $username = $_SESSION['admin_pusat_username'];
    $role = 'super_admin';
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'complete_order':
        $orderNumber = $_POST['order_number'] ?? '';
        
        if (empty($orderNumber)) {
            echo json_encode(['success' => false, 'message' => 'Nomor order tidak valid']);
            exit;
        }
        
        try {
            $pdo->beginTransaction();
            
            // Cek apakah order ini milik admin yang login (jika admin UP)
            if ($role === 'admin_up') {
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ? AND assigned_to = ?");
                $stmt->execute([$orderNumber, $username]);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
                $stmt->execute([$orderNumber]);
            }
            
            $order = $stmt->fetch();
            
            if (!$order) {
                echo json_encode(['success' => false, 'message' => 'Order tidak ditemukan']);
                exit;
            }
            
            $stmt = $pdo->prepare("UPDATE orders SET status = 'success', completed_at = NOW() WHERE order_number = ?");
            $stmt->execute([$orderNumber]);
            
            logActivity($pdo, $userId, $username, 'complete_order', "Menyelesaikan order: $orderNumber");
            
            $pdo->commit();
            
            echo json_encode(['success' => true, 'message' => 'Order selesai']);
            
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);
}
?>