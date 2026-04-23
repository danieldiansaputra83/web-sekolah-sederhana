<?php
// PERBAIKAN ERROR SESSION:
// Kode ini WAJIB ada di baris paling pertama (Baris 1).
// Jangan ada spasi atau HTML apapun sebelum tag <?php ini.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Negeri 67 Malliang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- 1. VARIABEL WARNA --- */
        :root {
            --primary: #009688;       /* Hijau Tosca Utama */
            --primary-dark: #004d40;  /* Hijau Gelap */
            --text-color: #333;
            --bg-color: #f4f6f8;
        }

        /* --- 2. RESET DASAR --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-color); display: flex; flex-direction: column; min-height: 100vh; }

        /* --- 3. STYLE NAVIGASI (SOLUSI MASALAHMU) --- */
        header { 
            background: white; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
        }
        
        .navbar-container {
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 15px 20px;
            /* FLEXBOX PENTING: Membuat Logo (kiri) dan Menu (kanan) berseberangan */
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }

        .logo { 
            font-size: 30px; 
            font-weight: 700; 
            color: var(--primary); 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

        /* INI KUNCI AGAR MENU SEJAJAR (HORIZONTAL) */
        nav { 
            display: flex;          /* Aktifkan mode baris */
            flex-direction: row;    /* Paksa arah Horizontal (kiri ke kanan) */
            align-items: center;    /* Rata tengah secara vertikal */
            gap: 25px;              /* Jarak antar menu */
        }

        nav a { 
            text-decoration: none; 
            color: var(--text-color); 
            font-weight: 500; 
            font-size: 15px; 
            transition: 0.3s;
            position: relative;
        }
        
        /* Efek garis bawah saat mouse lewat */
        nav a::after {
            content: ''; display: block; width: 0; height: 2px; 
            background: var(--primary); transition: width .3s;
        }
        nav a:hover::after { width: 100%; }
        nav a:hover { color: var(--primary); }

        /* Tombol Spesial (Login/Dashboard) */
        .btn-nav {
            background: var(--primary); 
            color: white !important; 
            padding: 8px 25px; 
            border-radius: 50px; 
            font-size: 14px; 
            box-shadow: 0 4px 10px rgba(0,150,136,0.3);
            border: none;
        }
        .btn-nav:hover { background: var(--primary-dark); transform: translateY(-2px); }
        .btn-nav::after { display: none; } /* Matikan garis bawah untuk tombol */

        /* --- 4. CONTAINER KONTEN --- */
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; flex: 1; }

        /* --- 5. STYLE TAMBAHAN (Tabel & Form) --- */
        table.data-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; margin-top: 10px; }
        table.data-table th { background: var(--primary); color: white; padding: 12px; text-align: left; }
        table.data-table td { background: white; padding: 12px; border-bottom: 1px solid #ddd; }
        
        input, textarea, select { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 5px; }
    </style>
</head>
<body>

<header>
    <div class="navbar-container">
        <a href="index.php" class="logo">
            🏫 SMKN 67 MALLIANG
        </a>
        
        <nav>
            <a href="index.php">Beranda</a>
            <a href="profil.php">Profil</a>
            <a href="kurikulum.php">Kurikulum</a>
            <a href="ekskul.php">Ekstrakurikuler</a>
            
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == "login") { ?>
                <a href="index_admin.php" class="btn-nav">Control Panel</a>
                <a href="logout.php" style="color: #e74c3c; font-size: 13px;">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="btn-nav">Login Admin</a>
            <?php } ?>
        </nav>
    </div>
</header>