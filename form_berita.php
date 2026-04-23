<?php 
session_start();
if ($_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

include 'koneksi.php';
include 'header.php';

// Inisialisasi variabel kosong (Nilai Default)
$id = "";
$judul = "";
$kategori = "";
$isi = "";
$gambar_lama = "default.jpg";
$mode = "Tambah"; // Label tombol

// --- LOGIKA UNTUK MODE EDIT (AMBIL DATA LAMA) ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mode = "Edit";
    
    // Ambil data dari database berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM berita WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    
    // Masukkan data lama ke variabel
    $judul = $data['judul'];
    $kategori = $data['kategori'];
    $isi = $data['isi'];
    $gambar_lama = $data['gambar'];
}

// --- LOGIKA SAAT TOMBOL SIMPAN DITEKAN ---
if (isset($_POST['simpan'])) {
    $judul_baru = $_POST['judul'];
    $kategori_baru = $_POST['kategori'];
    $isi_baru = $_POST['isi'];
    $tanggal = date('Y-m-d');
    
    // Cek apakah user upload gambar baru?
    // (Untuk sementara kita pakai nama file default agar coding tidak terlalu rumit di awal)
    $gambar_fix = $gambar_lama; 

    if ($mode == "Edit") {
        // Query Update
        $sql = "UPDATE berita SET judul='$judul_baru', kategori='$kategori_baru', isi='$isi_baru' WHERE id='$id'";
    } else {
        // Query Insert (Tambah)
        $sql = "INSERT INTO berita (judul, isi, kategori, gambar, tanggal) VALUES ('$judul_baru', '$isi_baru', '$kategori_baru', 'default.jpg', '$tanggal')";
    }

    // Eksekusi Query
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='index_admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<div class="container">
    <h2 style="border-bottom: 3px solid #008080; padding-bottom: 10px;"><?php echo $mode; ?> Berita</h2>
    
    <form method="POST" action="">
        <label>Judul Berita:</label>
        <input type="text" name="judul" value="<?php echo $judul; ?>" required style="width: 100%; padding: 10px; margin: 5px 0 15px 0; box-sizing: border-box;">

        <label>Kategori:</label>
        <select name="kategori" style="width: 100%; padding: 10px; margin: 5px 0 15px 0;">
            <option value="Berita Sekolah" <?php if($kategori=="Berita Sekolah") echo "selected"; ?>>Berita Sekolah</option>
            <option value="Prestasi" <?php if($kategori=="Prestasi") echo "selected"; ?>>Prestasi</option>
            <option value="Jurusan" <?php if($kategori=="Jurusan") echo "selected"; ?>>Jurusan</option>
        </select>

        <label>Isi Berita:</label>
        <textarea name="isi" rows="10" required style="width: 100%; padding: 10px; margin: 5px 0 15px 0;"><?php echo $isi; ?></textarea>

        <button type="submit" name="simpan" style="background: #008080; color: white; padding: 12px 20px; border: none; font-size: 16px; cursor: pointer;">
            💾 Simpan Perubahan
        </button>
        <a href="index_admin.php" style="margin-left: 10px; text-decoration: none; color: #333;">Batal</a>
    </form>
</div>

<?php include 'footer.php'; ?>