<?php
// ==================== HALAMAN UTAMA ====================
// File: index.php - VERSI DENGAN LOADING CEPAT

require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>UP RPL - Layanan Printing & Fashion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==================== RESET & VARIABLES ==================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #27ae60;
            --success-dark: #219653;
            --warning: #f39c12;
            --danger: #e74c3c;
            --dark: #2c3e50;
            --gray: #7f8c8d;
            --light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
            --radius: 8px;
            --radius-lg: 16px;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ==================== TYPOGRAPHY ==================== */
        .section-title {
            text-align: center;
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            padding: 0 15px;
        }

        /* ==================== HEADER ==================== */
        .small-header {
            background: var(--white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-img {
            height: clamp(35px, 5vw, 45px);
            width: auto;
        }

        .logo-text h1 {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            color: var(--dark);
        }

        .logo-text p {
            font-size: clamp(0.7rem, 2vw, 0.8rem);
            color: var(--gray);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: clamp(10px, 2vw, 25px);
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 1rem);
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            padding: 8px 12px;
            border-radius: var(--radius);
            transition: all 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: rgba(102,126,234,0.1);
        }

        .nav-links a i {
            font-size: 0.9em;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
            z-index: 1000;
            border: 1px solid #e9ecef;
        }

        .nav-links li:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            padding: 10px 20px;
            color: var(--dark);
            white-space: nowrap;
        }

        .dropdown-menu a:hover {
            background: var(--light);
            color: var(--primary);
        }

        .menu-toggle {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--dark);
            padding: 10px;
        }

        /* ==================== HERO SECTION ==================== */
        .hero {
            min-height: 85vh;
            height: auto;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('p1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 60px 20px;
        }

        .hero-content {
            max-width: 800px;
            width: 100%;
        }

        .hero-title {
            font-size: clamp(2rem, 8vw, 3.5rem);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1.2rem, 5vw, 1.8rem);
            margin-bottom: 20px;
            color: var(--primary);
        }

        .hero-description {
            font-size: clamp(0.9rem, 3vw, 1.2rem);
            max-width: 700px;
            margin: 0 auto 30px;
            opacity: 0.9;
            padding: 0 15px;
        }

        .btn {
            display: inline-block;
            padding: clamp(12px, 3vw, 15px) clamp(25px, 5vw, 40px);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-decoration: none;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            box-shadow: var(--shadow);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn i {
            margin-right: 8px;
        }

        /* ==================== ABOUT SECTION ==================== */
        .about {
            padding: 60px 0;
            background: var(--white);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .about-image {
            height: 400px;
            background: linear-gradient(135deg, var(--light), #e9ecef);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed var(--primary);
            padding: 20px;
        }

        .image-placeholder {
            text-align: center;
            color: var(--gray);
        }

        .image-placeholder i {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .about-text h3 {
            font-size: clamp(1.5rem, 4vw, 1.8rem);
            margin-bottom: 20px;
        }

        .about-text p {
            color: #555;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: var(--light);
            border-radius: var(--radius);
            border: 1px solid #e9ecef;
        }

        .stat-number {
            font-size: clamp(1.5rem, 4vw, 1.8rem);
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            color: var(--gray);
            font-size: clamp(0.7rem, 2vw, 0.9rem);
        }

        .feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .feature-icon {
            background: var(--primary);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        /* ==================== SERVICES SECTION ==================== */
        .pricing {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--light) 0%, #e9ecef 100%);
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            padding: 0 15px;
        }

        .filter-btn {
            padding: 10px 20px;
            background: var(--white);
            border: 2px solid #e9ecef;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            white-space: nowrap;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -20px;
            padding: 0 20px;
        }

        .price-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .price-table thead {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .price-table th {
            padding: 15px;
            text-align: left;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .price-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .service-category {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .service-category.print { background: #ffeaa7; color: #e17055; }
        .service-category.fashion { background: #a29bfe; color: #6c5ce7; }
        .service-category.sablon { background: #81ecec; color: #00cec9; }

        .buy-btn {
            padding: 8px 16px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 600;
            font-size: clamp(0.7rem, 2vw, 0.8rem);
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .buy-btn:hover {
            background: var(--success-dark);
            transform: translateY(-2px);
        }

        /* ==================== GALLERY SECTION ==================== */
        .gallery {
            padding: 60px 0;
            background: var(--white);
        }

        .gallery-filter {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            padding: 0 15px;
        }

        .gallery-filter-btn {
            padding: 10px 20px;
            background: var(--white);
            border: 2px solid #e9ecef;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .gallery-filter-btn.active,
        .gallery-filter-btn:hover {
            background: var(--dark);
            color: white;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 15px;
        }

        .gallery-item {
            position: relative;
            height: 250px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            cursor: pointer;
            background: var(--light);
        }

        .gallery-placeholder {
            text-align: center;
            padding: 50px 20px;
        }

        .gallery-placeholder i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 15px;
            transform: translateY(100%);
            transition: transform 0.3s;
            text-align: center;
        }

        .gallery-item:hover .gallery-caption {
            transform: translateY(0);
        }

        /* ==================== CONTACT SECTION ==================== */
        .contact {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--light) 0%, #e9ecef 100%);
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
        }

        .contact-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
            background: var(--white);
            border-radius: var(--radius-lg);
            border-left: 4px solid var(--primary);
            margin-bottom: 20px;
        }

        .contact-icon {
            background: var(--primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-details h4 {
            margin-bottom: 5px;
            font-size: clamp(1rem, 3vw, 1.1rem);
        }

        .contact-details p {
            color: var(--gray);
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            word-break: break-word;
        }

        .map-container {
            width: 100%;
            height: 300px;
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* ==================== FOOTER ==================== */
        footer {
            background: var(--dark);
            color: white;
            padding: 50px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-grid h4 {
            margin-bottom: 20px;
            font-size: clamp(1rem, 3vw, 1.1rem);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: none;
            transition: color 0.3s;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: clamp(0.7rem, 2vw, 0.8rem);
        }

        /* ==================== MODAL ==================== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            overflow-y: auto;
            padding: 20px;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close {
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            padding: 0 10px;
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            max-height: calc(90vh - 80px);
        }

        /* ==================== LOADING ==================== */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 99999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .loading.active {
            display: flex;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255,255,255,0.1);
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: white;
            font-size: clamp(1rem, 3vw, 1.2rem);
            text-align: center;
        }

        /* ==================== SUCCESS ALERT ==================== */
        .success-alert {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: var(--radius);
            border-left: 4px solid #28a745;
            box-shadow: var(--shadow-lg);
            z-index: 100000;
            animation: slideIn 0.3s ease;
            max-width: 350px;
            width: calc(100% - 40px);
        }

        .success-alert.show {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ==================== FORM STYLES (UNTUK MODAL) ==================== */
        .service-info {
            background: var(--light);
            border-left: 4px solid var(--primary);
            padding: 15px;
            border-radius: var(--radius);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--dark);
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: var(--radius);
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col {
            flex: 1;
            padding: 0 10px;
            min-width: 200px;
        }

        .paket-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 15px 0;
        }

        .paket-card {
            flex: 1;
            min-width: 150px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: var(--radius);
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .paket-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .paket-card.selected {
            border-color: var(--primary);
            background: rgba(102,126,234,0.05);
        }

        .paket-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .paket-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .paket-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .ukuran-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 10px 0;
        }

        .ukuran-card {
            width: 50px;
            height: 50px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .ukuran-card:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .ukuran-card.selected {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        .sablon-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 10px 0;
        }

        .sablon-card {
            flex: 1;
            min-width: 120px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: var(--radius);
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .sablon-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .sablon-card.selected {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        .sablon-card.selected .sablon-price {
            color: white;
        }

        .sablon-name {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sablon-price {
            font-size: 0.9rem;
            color: var(--primary);
        }

        .color-picker-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 15px 0;
        }

        .color-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .color-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60px;
            cursor: pointer;
        }

        .color-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-bottom: 5px;
            transition: all 0.3s;
            border: 3px solid transparent;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .color-circle:hover {
            transform: scale(1.1);
        }

        .color-circle.selected {
            border-color: var(--primary);
            transform: scale(1.1);
        }

        .color-name {
            font-size: 0.8rem;
            color: var(--dark);
        }

        .selected-color-preview {
            margin-top: 15px;
            padding: 10px;
            background: var(--light);
            border-radius: var(--radius);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .total-section {
            background: linear-gradient(135deg, var(--dark), #1a2634);
            border-radius: var(--radius);
            padding: 20px;
            color: white;
            margin: 20px 0;
            text-align: center;
        }

        .total-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .total-amount {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: 800;
            line-height: 1.2;
        }

        .total-unit {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .help-text {
            display: block;
            color: var(--gray);
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* ==================== RESPONSIVE BREAKPOINTS ==================== */
        @media (max-width: 1024px) {
            .about-content {
                gap: 30px;
            }
            
            .stats-container {
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                gap: 0;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                margin: 5px 0;
            }

            .nav-links a {
                padding: 12px;
                width: 100%;
                justify-content: flex-start;
            }

            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                margin-top: 10px;
                width: 100%;
            }

            .hero {
                min-height: 70vh;
                background-attachment: scroll;
            }

            .about-content,
            .contact-content {
                grid-template-columns: 1fr;
            }

            .about-image {
                height: 300px;
                order: -1;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .paket-container {
                flex-direction: column;
            }

            .paket-card {
                width: 100%;
            }

            .sablon-container {
                flex-direction: column;
            }

            .sablon-card {
                width: 100%;
            }

            .color-item {
                width: 45px;
            }

            .color-circle {
                width: 35px;
                height: 35px;
            }
        }

        @media (max-width: 480px) {
            html {
                font-size: 14px;
            }

            .navbar {
                padding: 10px 4%;
            }

            .logo-img {
                height: 30px;
            }

            .hero {
                min-height: 60vh;
                padding: 40px 15px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .contact-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .contact-icon {
                margin-bottom: 10px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                margin: 10px auto;
            }

            .modal-header {
                padding: 15px;
            }

            .modal-body {
                padding: 15px;
            }

            .success-alert {
                left: 20px;
                right: 20px;
                width: auto;
            }

            .color-row {
                justify-content: center;
            }

            .color-item {
                width: 40px;
            }
        }

        @media (max-width: 360px) {
            .filter-btn {
                padding: 8px 12px;
                font-size: 0.7rem;
            }

            .ukuran-card {
                width: 40px;
                height: 40px;
            }

            .color-item {
                width: 35px;
            }

            .color-circle {
                width: 30px;
                height: 30px;
            }

            .color-name {
                font-size: 0.7rem;
            }
        }

        /* ==================== UTILITY CLASSES ==================== */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .d-none { display: none; }
        .d-block { display: block; }
        .d-flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .align-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .w-100 { width: 100%; }
        .h-100 { height: 100%; }
        .m-0 { margin: 0; }
        .p-0 { padding: 0; }
        .mt-2 { margin-top: 10px; }
        .mb-2 { margin-bottom: 10px; }
        .mt-3 { margin-top: 15px; }
        .mb-3 { margin-bottom: 15px; }
        .mt-4 { margin-top: 20px; }
        .mb-4 { margin-bottom: 20px; }
        .gap-2 { gap: 10px; }
        .gap-3 { gap: 15px; }
        
        /* ==================== LOADING FORM STYLES ==================== */
        .form-loading {
            text-align: center;
            padding: 40px;
        }
        
        .form-loading i {
            font-size: 3rem;
            color: var(--primary);
            animation: spin 1s linear infinite;
        }
        
        .form-loading p {
            margin-top: 20px;
            font-size: 16px;
            color: var(--dark);
        }
        
        .form-loading small {
            color: var(--gray);
            font-size: 14px;
        }
        
        .form-error {
            text-align: center;
            padding: 40px;
            color: var(--danger);
        }
        
        .form-error i {
            font-size: 3rem;
        }
        
        .form-error p {
            margin-top: 20px;
            font-size: 16px;
        }
        
        .btn-retry {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
        }
        
        .btn-retry:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
    </style>
</head>
<body>
    <!-- LOADING -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
        <div class="loading-text">MEMPROSES...</div>
    </div>
    
    <!-- SUCCESS ALERT -->
    <div class="success-alert" id="successAlert">
        <i class="fas fa-check-circle"></i>
        <div>
            <strong>Pesanan Berhasil!</strong><br>
            Nomor Order: <span id="orderNumber"></span>
        </div>
    </div>

    <!-- HEADER -->
    <header class="small-header">
        <nav class="navbar">
            <div class="logo-container">
                <img src="ChatGPT Image 19 Feb 2026, 22.39.25.png" alt="Logo RPL" class="logo-img">
                <div class="logo-text">
                    <h1>UP RPL</h1>
                    <p>Layanan Printing & Fashion</p>
                </div>
            </div>
            <div class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links" id="navMenu">
                <li><a href="#home"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="#about"><i class="fas fa-info-circle"></i> Tentang</a></li>
                <li><a href="#services"><i class="fas fa-concierge-bell"></i> Layanan</a></li>
                <li><a href="#gallery"><i class="fas fa-images"></i> Galeri</a></li>
                <li><a href="#contact"><i class="fas fa-phone-alt"></i> Kontak</a></li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-user"></i> Login <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="login.php"><i class="fas fa-user-tie"></i> Admin UP</a>
                        <hr>
                        <a href="register.php"><i class="fas fa-user-plus"></i> Daftar Admin UP</a>
                    </div>
                </li>
                <li><a href="#" id="pesanBtn"><i class="fas fa-shopping-cart"></i> Pesan</a></li>
            </ul>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section id="home" class="hero">
        <div class="hero-content">
            
            <a href="#" id="heroPesanBtn" class="btn">
                <i class="fas fa-shopping-cart"></i> Pesan Sekarang
            </a>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="about">
        <div class="container">
            <h2 class="section-title">TENTANG UP RPL</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Unit Produktif Rekayasa Perangkat Lunak - SMK Negeri 24 Jakarta</p>
            
            <div class="about-content">
                <div class="about-image">
                    <div class="image-placeholder">
                        <i class="fas fa-users"></i>
                        <p>Tim UP RPL Bekerja</p>
                    </div>
                </div>
                
                <div class="about-text">
                    <h3>UP RPL - Milik Kita Bersama</h3>
                    <p>UP RPL adalah unit usaha produktif yang dikelola oleh siswa dan guru kompeten di bidang Rekayasa Perangkat Lunak. Kami melayani kebutuhan printing dan fashion dengan harga terjangkau.</p>
                    
                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-number">4</div>
                            <div class="stat-label">Jenis Layanan</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Siswa SMKN 24</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">WA Order</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100+</div>
                            <div class="stat-label">Order/Bulan</div>
                        </div>
                    </div>
                    
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h4>Proses Cepat</h4>
                                <p>Printing selesai 5-30 menit, sablon 3-5 hari kerja</p>
                            </div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div>
                                <h4>Harga Siswa</h4>
                                <p>Khusus harga terjangkau untuk siswa dan guru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="pricing">
        <div class="container">
            <h2 class="section-title">LAYANAN UP RPL</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Pilih layanan yang Anda butuhkan</p>
            
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="print">Printing</button>
                <button class="filter-btn" data-filter="fashion">Fashion</button>
                <button class="filter-btn" data-filter="sablon">Sablon</button>
            </div>
            
            <div class="table-responsive">
                <table class="price-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-category="print">
                            <td>1</td>
                            <td>
                                Print Hitam Putih
                                <span class="service-category print">Printing</span>
                            </td>
                            <td>Print dokumen hitam putih</td>
                            <td>Rp 1.000/lembar</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="print_hitam">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                        <tr data-category="print">
                            <td>2</td>
                            <td>
                                Print Full Color
                                <span class="service-category print">Printing</span>
                            </td>
                            <td>Print dokumen berwarna</td>
                            <td>Rp 2.000/lembar</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="print_warna">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                        <tr data-category="print">
                            <td>3</td>
                            <td>
                                Fotocopy
                                <span class="service-category print">Printing</span>
                            </td>
                            <td>Fotocopy dokumen</td>
                            <td>Rp 250/lembar</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="fotocopy">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                        <tr data-category="fashion">
                            <td>4</td>
                            <td>
                                Kaos Polos
                                <span class="service-category fashion">Fashion</span>
                            </td>
                            <td>Kaos katun combed 30s</td>
                            <td>Rp 50.000/pcs</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="kaos_sablon" data-jenis="kaos">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                        <tr data-category="sablon">
                            <td>5</td>
                            <td>
                                Sablon Baju
                                <span class="service-category sablon">Sablon</span>
                            </td>
                            <td>Jasa sablon desain custom</td>
                            <td>Rp 55.000/sablon</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="kaos_sablon" data-jenis="sablon">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                        <tr data-category="fashion">
                            <td>6</td>
                            <td>
                                Paket Kaos + Sablon
                                <span class="service-category fashion">Fashion</span>
                            </td>
                            <td>Kaos + sablon 1 warna</td>
                            <td>Rp 105.000/paket</td>
                            <td>
                                <a href="#" class="buy-btn pesan-layanan" data-layanan="kaos_sablon" data-jenis="paket">
                                    <i class="fas fa-shopping-cart"></i> Pesan
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- GALLERY SECTION -->
    <section id="gallery" class="gallery">
        <div class="container">
            <h2 class="section-title">GALERI UP RPL</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Momen-momen kegiatan UP RPL</p>
            
            <div class="gallery-filter">
                <button class="gallery-filter-btn active" data-filter="all">Semua</button>
                <button class="gallery-filter-btn" data-filter="team">Tim</button>
                <button class="gallery-filter-btn" data-filter="work">Proses</button>
                <button class="gallery-filter-btn" data-filter="sablon">Sablon</button>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item" data-category="team">
                    <div class="gallery-placeholder">
                        <i class="fas fa-users"></i>
                        <p>Tim UP RPL</p>
                    </div>
                    <div class="gallery-caption">Tim UP RPL sedang melayani order</div>
                </div>
                
                <div class="gallery-item" data-category="work">
                    <div class="gallery-placeholder">
                        <i class="fas fa-print"></i>
                        <p>Proses Printing</p>
                    </div>
                    <div class="gallery-caption">Proses printing dokumen</div>
                </div>
                
                <div class="gallery-item" data-category="sablon">
                    <div class="gallery-placeholder">
                        <i class="fas fa-tshirt"></i>
                        <p>Proses Sablon</p>
                    </div>
                    <div class="gallery-caption">Tim sablon sedang bekerja</div>
                </div>
                
                <div class="gallery-item" data-category="team">
                    <div class="gallery-placeholder">
                        <i class="fas fa-user-graduate"></i>
                        <p>Siswa UP RPL</p>
                    </div>
                    <div class="gallery-caption">Siswa anggota UP RPL</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">HUBUNGI UP RPL</h2>
            <div class="section-divider"></div>
            
            <div class="contact-content">
                <div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-details">
                            <h4>WhatsApp</h4>
                            <p><?php echo ADMIN_PHONE; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p><?php echo ADMIN_EMAIL; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Alamat</h4>
                            <p>SMK Negeri 24 Jakarta</p>
                        </div>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.755788662104!2d106.8971596!3d-6.3217615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed39f3a3c44d%3A0x83f2c08168c334bb!2sSMKN%2024%20Jakarta!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h4>UP RPL</h4>
                    <p>Unit Produksi RPL SMK Negeri 24 Jakarta</p>
                </div>
                <div class="footer-links">
                    <h4>Layanan</h4>
                    <ul>
                        <li>Print Hitam Putih</li>
                        <li>Print Warna</li>
                        <li>Fotocopy</li>
                        <li>Kaos & Sablon</li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#gallery">Galeri</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Akun</h4>
                    <ul>
                        <li><a href="login.php">Admin UP</a></li>
                        <li><a href="register.php">Daftar Admin UP</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 SMK Negeri 24 Jakarta - Unit Produksi RPL</p>
            </div>
        </div>
    </footer>

    <!-- ORDER MODAL -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-shopping-cart"></i> Form Pemesanan</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <div class="text-center" style="padding: 40px;">
                    <i class="fas fa-spinner fa-spin fa-3x" style="color: var(--primary);"></i>
                    <p style="margin-top: 20px;">Memuat form...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS - URUTAN PENTING! -->
    <!-- JQuery dengan fallback lokal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="jquery-3.6.0.min.js"><\/script>');
    </script>
    
    <script>
        // ==================== VARIABEL GLOBAL ====================
        const loading = document.getElementById('loading');
        const successAlert = document.getElementById('successAlert');
        const orderNumberSpan = document.getElementById('orderNumber');
        
        // ==================== FUNGSI MODAL ====================
        function showModal() { 
            document.getElementById('orderModal').classList.add('show'); 
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() { 
            document.getElementById('orderModal').classList.remove('show'); 
            document.body.style.overflow = '';
        }
        
        function showLoading() { 
            loading.classList.add('active'); 
        }
        
        function hideLoading() { 
            loading.classList.remove('active'); 
        }
        
        // ==================== FUNGSI LOAD FORM DENGAN TIMEOUT ====================
        function loadOrderForm(layanan, jenis = '') {
            // Tampilkan loading di modal
            document.getElementById('orderModalBody').innerHTML = `
                <div class="form-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Memuat form pemesanan...</p>
                    <small class="text-muted">Mohon tunggu sebentar</small>
                </div>
            `;
            
            // Tampilkan loading overlay
            showLoading();
            
            // Set timeout 5 detik
            const timeout = setTimeout(() => {
                hideLoading();
                document.getElementById('orderModalBody').innerHTML = `
                    <div class="form-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>⚠️ Waktu habis! Silakan coba lagi.</p>
                        <button onclick="loadOrderForm('${layanan}', '${jenis}')" class="btn-retry">
                            <i class="fas fa-sync-alt"></i> Coba Lagi
                        </button>
                    </div>
                `;
            }, 5000); // 5 detik
            
            $.ajax({
                url: 'get_order_form.php',
                method: 'POST',
                data: { layanan: layanan, jenis: jenis },
                timeout: 4000, // AJAX timeout 4 detik
                success: function(response) {
                    clearTimeout(timeout); // Batalkan timeout
                    hideLoading();
                    document.getElementById('orderModalBody').innerHTML = response;
                },
                error: function(xhr, status, error) {
                    clearTimeout(timeout);
                    hideLoading();
                    
                    let errorMessage = 'Gagal memuat form.';
                    if (status === 'timeout') {
                        errorMessage = '⚠️ Koneksi lambat. Silakan coba lagi.';
                    } else if (status === 'error') {
                        errorMessage = '❌ Terjadi kesalahan server.';
                    } else if (status === 'parsererror') {
                        errorMessage = '❌ Format data salah.';
                    } else {
                        errorMessage = '❌ ' + error;
                    }
                    
                    document.getElementById('orderModalBody').innerHTML = `
                        <div class="form-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>${errorMessage}</p>
                            <button onclick="loadOrderForm('${layanan}', '${jenis}')" class="btn-retry">
                                <i class="fas fa-sync-alt"></i> Coba Lagi
                            </button>
                        </div>
                    `;
                    
                    console.error('AJAX Error:', status, error);
                }
            });
        }
        
        // ==================== FUNGSI UNTUK PILIH PAKET ====================
        window.selectPaket = function(jenis, element) {
            const cards = document.querySelectorAll('.paket-card');
            cards.forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            
            const radio = document.getElementById('paket_' + jenis);
            if (radio) radio.checked = true;
            
            const layanan = document.getElementById('hidden_layanan')?.value || '';
            const jenisLayanan = document.getElementById('jenis_layanan');
            if (jenisLayanan) jenisLayanan.value = layanan + '_' + jenis;
            
            const ukuranGroup = document.getElementById('ukuranGroup');
            const sablonGroup = document.getElementById('sablonGroup');
            
            if (ukuranGroup && sablonGroup) {
                if (jenis === 'sablon') {
                    ukuranGroup.style.display = 'none';
                    sablonGroup.style.display = 'block';
                } else if (jenis === 'kaos') {
                    ukuranGroup.style.display = 'block';
                    sablonGroup.style.display = 'none';
                } else {
                    ukuranGroup.style.display = 'block';
                    sablonGroup.style.display = 'block';
                }
            }
            
            if (typeof window.updateTotal === 'function') window.updateTotal();
        };

        // ==================== FUNGSI UNTUK PILIH UKURAN ====================
        window.pilihUkuran = function(ukuran, element) {
            const cards = document.querySelectorAll('.ukuran-card');
            cards.forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            
            const ukuranInput = document.getElementById('ukuran');
            if (ukuranInput) ukuranInput.value = ukuran;
        };

        // ==================== FUNGSI UNTUK PILIH SABLON ====================
        window.pilihSablon = function(jenis, harga, element) {
            const cards = document.querySelectorAll('.sablon-card');
            cards.forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            
            const sablonInput = document.getElementById('jenis_sablon');
            const hargaInput = document.getElementById('harga_sablon');
            if (sablonInput) sablonInput.value = jenis;
            if (hargaInput) hargaInput.value = harga;
            
            if (typeof window.updateTotal === 'function') window.updateTotal();
        };

        // ==================== FUNGSI UNTUK PILIH WARNA ====================
        window.pilihWarna = function(kodeWarna, namaWarna, element) {
            const circles = document.querySelectorAll('.color-circle');
            circles.forEach(circle => circle.classList.remove('selected'));
            
            const circle = element.querySelector('.color-circle');
            if (circle) circle.classList.add('selected');
            
            const warnaInput = document.getElementById('warna_kaos');
            const warnaNamaInput = document.getElementById('warna_kaos_nama');
            const colorNameSpan = document.getElementById('selectedColorName');
            const colorDot = document.getElementById('selectedColorDot');
            
            if (warnaInput) warnaInput.value = kodeWarna;
            if (warnaNamaInput) warnaNamaInput.value = namaWarna;
            if (colorNameSpan) colorNameSpan.textContent = namaWarna;
            if (colorDot) colorDot.style.backgroundColor = kodeWarna;
        };

        // ==================== FUNGSI UPDATE TOTAL ====================
        window.updateTotal = function() {
            const jumlahInput = document.getElementById('jumlah');
            if (!jumlahInput) return;
            
            const jumlah = parseInt(jumlahInput.value) || 1;
            const jumlahDisplay = document.getElementById('jumlahDisplay');
            if (jumlahDisplay) jumlahDisplay.textContent = jumlah;
            
            let harga = 0;
            const paketKaos = document.getElementById('paket_kaos');
            
            if (paketKaos) {
                let jenis = 'paket';
                if (document.getElementById('paket_kaos')?.checked) jenis = 'kaos';
                else if (document.getElementById('paket_sablon')?.checked) jenis = 'sablon';
                else if (document.getElementById('paket_paket')?.checked) jenis = 'paket';
                
                const hargaSablonInput = document.getElementById('harga_sablon');
                const hargaSablon = hargaSablonInput ? parseInt(hargaSablonInput.value) || 55000 : 55000;
                
                if (jenis === 'kaos') harga = 50000;
                else if (jenis === 'sablon') harga = hargaSablon;
                else harga = 50000 + hargaSablon;
            } else {
                const hargaText = document.querySelector('.price-tag')?.textContent || '';
                const match = hargaText.match(/Rp\s+([0-9.]+)/);
                if (match) harga = parseInt(match[1].replace(/\./g, '')) || 0;
            }
            
            const total = harga * jumlah;
            const totalDisplay = document.getElementById('totalDisplay');
            if (totalDisplay) totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // ==================== FUNGSI SUBMIT ORDER ====================
        window.submitOrder = function(event, layanan) {
            event.preventDefault();
            
            showLoading();
            
            const form = document.getElementById('orderForm');
            const formData = new FormData(form);
            
            const linkDrive = document.getElementById('link_drive').value;
            if (!linkDrive.startsWith('https://drive.google.com/') && !linkDrive.startsWith('https://docs.google.com/')) {
                alert('❌ Link Google Drive tidak valid! Gunakan link dari Google Drive.');
                hideLoading();
                return;
            }
            
            const telepon = document.getElementById('telepon').value.replace(/[^0-9]/g, '');
            if (telepon.length < 10 || telepon.length > 13) {
                alert('❌ Nomor WhatsApp harus 10-13 digit!');
                hideLoading();
                return;
            }
            
            fetch('proses_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.success) {
                    orderNumberSpan.textContent = data.order.orderNumber;
                    successAlert.classList.add('show');
                    closeModal();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    setTimeout(() => {
                        window.location.href = 'metode_pembayaran.php?order=' + data.order.orderNumber;
                    }, 3000);
                } else {
                    alert('❌ Gagal: ' + data.message);
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan jaringan. Silakan coba lagi.');
            });
        };
        
        // ==================== MOBILE MENU ====================
        document.getElementById('menuToggle').addEventListener('click', () => {
            document.getElementById('navMenu').classList.toggle('active');
        });

        // ==================== FILTER LAYANAN ====================
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                document.querySelectorAll('.price-table tbody tr').forEach(row => {
                    row.style.display = (filter === 'all' || row.dataset.category === filter) ? '' : 'none';
                });
            });
        });

        // ==================== GALLERY FILTER ====================
        document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.gallery-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                document.querySelectorAll('.gallery-item').forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.category === filter) ? 'block' : 'none';
                });
            });
        });

        // ==================== SMOOTH SCROLL (FIX) ====================
        document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId && targetId !== '#') {
                    const target = document.querySelector(targetId);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                        document.getElementById('navMenu')?.classList.remove('active');
                    }
                }
            });
        });

        // ==================== EVENT LISTENER PESAN ====================
        document.getElementById('pesanBtn')?.addEventListener('click', (e) => { 
            e.preventDefault(); 
            showModal(); 
            loadOrderForm(''); 
        });
        
        document.getElementById('heroPesanBtn')?.addEventListener('click', (e) => { 
            e.preventDefault(); 
            showModal(); 
            loadOrderForm(''); 
        });

        document.querySelectorAll('.pesan-layanan').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const layanan = btn.dataset.layanan;
                const jenis = btn.dataset.jenis || '';
                showModal();
                loadOrderForm(layanan, jenis);
            });
        });

        // ==================== CLOSE MODAL KLIK DI LUAR ====================
        window.onclick = (e) => {
            const modal = document.getElementById('orderModal');
            if (e.target === modal) closeModal();
        };
        
        // ==================== SEMBUNYIKAN ALERT SETELAH 10 DETIK ====================
        setInterval(() => {
            if (successAlert.classList.contains('show')) {
                successAlert.classList.remove('show');
            }
        }, 10000);
    </script>
</body>
</html>
