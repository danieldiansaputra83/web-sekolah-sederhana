<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_input = $_POST['password']; // Jangan di-hash dulu!

    // 1. Cari user berdasarkan username saja
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        // 2. Ambil data admin tersebut dari database
        $data_admin = mysqli_fetch_assoc($query);
        $password_di_database = $data_admin['password'];

        // 3. Verifikasi password
        if (password_verify($password_input, $password_di_database)) {
            $_SESSION['status'] = "login";
            $_SESSION['user'] = $username;
            header("location:index_admin.php");
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            echo "<script>alert('Password Salah!');</script>";
        }
    } else {
        echo "<script>alert('Username Tidak Ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - SMKN 67 Malliang</title>
    <style>
        /* CSS RESET & VARIABLES */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            /* Background Hijau Tosca Gelap seperti Header Website Sekolah */
            background: linear-gradient(135deg, #004d40 0%, #008080 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD LOGIN */
        .login-card {
            background: white;
            width: 400px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        /* LOGO & JUDUL */
        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: #008080;
            color: white;
            font-size: 40px;
            line-height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            font-weight: bold;
        }
        
        h2 { color: #333; margin-bottom: 5px; }
        p { color: #666; font-size: 14px; margin-bottom: 30px; }

        /* FORM INPUT */
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; color: #008080; font-weight: 600; font-size: 14px; }
        
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #008080;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 128, 128, 0.3);
        }

        /* TOMBOL */
        button {
            width: 100%;
            padding: 12px;
            background-color: #008080; /* Warna utama */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #004d40; /* Lebih gelap saat hover */
        }

        /* LINK KEMBALI */
        .back-link {
            display: block;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover { color: #008080; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-placeholder">🏫</div>
        
        <h2>Login Admin</h2>
        <p>Silakan masuk untuk mengelola data sekolah.</p>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username..." required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" name="login">MASUK</button>
        </form>

        <a href="index.php" class="back-link">← Kembali ke Website Utama</a>
    </div>

</body>
</html>