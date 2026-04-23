<?php
include 'koneksi.php';

// --- LOGIKA CREATE (TAMBAH DATA) ---
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $tanggal = date('Y-m-d');
    $gambar = 'default.jpg'; // Sederhana dulu tanpa upload file kompleks

    $sql = "INSERT INTO berita (judul, isi, kategori, gambar, tanggal) VALUES ('$judul', '$isi', '$kategori', '$gambar', '$tanggal')";
    mysqli_query($koneksi, $sql);
    header("Location: admin.php"); // Refresh halaman
}

// --- LOGIKA DELETE (HAPUS DATA) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin Sekolah</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #008080; color: white; }
        input, textarea, select { width: 100%; padding: 8px; margin: 5px 0; }
        button { background-color: #008080; color: white; padding: 10px; border: none; cursor: pointer; }
        .btn-delete { background-color: red; color: white; text-decoration: none; padding: 5px; }
    </style>
</head>
<body>
    <h2>Kelola Berita (CRUD)</h2>
    <a href="index.php">Kembali ke Website Utama</a>

    <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
        <h3>Tambah Berita Baru</h3>
        <form method="POST" action="">
            <label>Judul Berita:</label>
            <input type="text" name="judul" required>
            
            <label>Kategori:</label>
            <select name="kategori">
                <option value="Berita Sekolah">Berita Sekolah</option>
                <option value="Prestasi">Prestasi</option>
                <option value="Jurusan">Jurusan</option>
            </select>

            <label>Isi Berita:</label>
            <textarea name="isi" rows="4" required></textarea>

            <button type="submit" name="simpan">Simpan Berita</button>
        </form>
    </div>

    <h3>Daftar Berita</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $tampil = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
        while ($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['judul']; ?></td>
            <td><?= $data['kategori']; ?></td>
            <td>
                <a href="admin.php?edit=<?= $data['id']; ?>">Edit</a> | 
                <a href="admin.php?hapus=<?= $data['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>