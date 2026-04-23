<?php 
include 'header.php'; 
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    echo "<script>window.location='login.php'</script>";
    exit();
}

// --- INISIALISASI VARIABEL (Agar form tidak error saat kosong) ---
$id_edit = "";
$judul = "";
$kategori = "";
$isi = "";
$gambar_lama = "default.jpg"; // Gambar default jika tidak ada upload
$status_form = "Tambah"; // Label Tombol

// --- LOGIKA 1: JIKA TOMBOL EDIT DIKLIK (AMBIL DATA) ---
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id_edit'");
    $data_edit = mysqli_fetch_assoc($query_edit);

    // Masukkan data db ke variabel form
    $judul = $data_edit['judul'];
    $kategori = $data_edit['kategori'];
    $isi = $data_edit['isi'];
    $gambar_lama = $data_edit['gambar'];
    $status_form = "Update"; // Ubah label tombol jadi Update
}

// --- LOGIKA 2: JIKA TOMBOL HAPUS DIKLIK ---
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    
    // (Opsional) Hapus file gambar fisik agar hemat memori
    $q_gambar = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id_hapus'");
    $f_gambar = mysqli_fetch_assoc($q_gambar);
    if ($f_gambar['gambar'] != 'default.jpg' && file_exists('uploads/'.$f_gambar['gambar'])) {
        unlink('uploads/'.$f_gambar['gambar']);
    }

    mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id_hapus'");
    echo "<script>alert('Berita dihapus!'); window.location='index_admin.php';</script>";
}

// --- LOGIKA 3: JIKA TOMBOL SIMPAN DITEKAN (CREATE & UPDATE) ---
if (isset($_POST['simpan'])) {
    $judul_post = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori_post = $_POST['kategori'];
    $isi_post = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = date('Y-m-d');
    
    // Logika Upload Gambar
    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    // Tentukan nama gambar final
    if ($filename != "") {
        // Jika User Upload Gambar Baru
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $nama_gambar_baru = time() . "." . $ext; // Rename pakai waktu agar unik (contoh: 17345678.jpg)
        move_uploaded_file($tmp_name, 'uploads/' . $nama_gambar_baru);
    } else {
        // Jika User TIDAK Upload, pakai gambar lama
        $nama_gambar_baru = $_POST['gambar_lama'];
    }

    // Cek apakah ini Mode Tambah atau Update?
    if ($_POST['id_berita'] == "") {
        // MODE TAMBAH
        $sql = "INSERT INTO berita (judul, kategori, isi, gambar, tanggal) VALUES ('$judul_post', '$kategori_post', '$isi_post', '$nama_gambar_baru', '$tanggal')";
    } else {
        // MODE UPDATE
        $id_update = $_POST['id_berita'];
        $sql = "UPDATE berita SET judul='$judul_post', kategori='$kategori_post', isi='$isi_post', gambar='$nama_gambar_baru' WHERE id='$id_update'";
    }

    // Eksekusi
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='index_admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<div class="container">
    <h2 style="margin-bottom: 20px; color: var(--primary-dark);">Dashboard Berita</h2>
    
    <?php include 'admin_menu.php'; ?>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
        
        <div class="card" style="padding: 25px; background: white; border-radius: 15px; height: fit-content;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
                <h3 style="color: var(--primary);"><?= $status_form ?> Berita</h3>
                <?php if($status_form == "Update") { ?>
                    <a href="index_admin.php" style="font-size:12px; color:red; text-decoration:none;">[Batal Edit]</a>
                <?php } ?>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                
                <input type="hidden" name="id_berita" value="<?= $id_edit ?>">
                <input type="hidden" name="gambar_lama" value="<?= $gambar_lama ?>">

                <label style="font-size: 13px; font-weight: bold;">Judul Artikel</label>
                <input type="text" name="judul" value="<?= $judul ?>" required>
                
                <label style="font-size: 13px; font-weight: bold;">Kategori</label>
                <select name="kategori">
                    <option value="Berita Sekolah" <?= ($kategori == 'Berita Sekolah') ? 'selected' : '' ?>>Berita Sekolah</option>
                    <option value="Prestasi" <?= ($kategori == 'Prestasi') ? 'selected' : '' ?>>Prestasi</option>
                    <option value="Agenda" <?= ($kategori == 'Agenda') ? 'selected' : '' ?>>Agenda</option>
                </select>

                <label style="font-size: 13px; font-weight: bold;">Isi Berita</label>
                <textarea name="isi" rows="6" required><?= $isi ?></textarea>

                <label style="font-size: 13px; font-weight: bold;">Upload Thumbnail (Gambar)</label>
                <br>
                <?php if($status_form == "Update" && $gambar_lama != "") { ?>
                    <img src="uploads/<?= $gambar_lama ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px; margin-bottom: 5px;">
                    <br>
                    <small style="color:#888;">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                <?php } ?>
                
                <input type="file" name="gambar" accept="image/*" style="border: none; padding-left: 0;">

                <button type="submit" name="simpan" class="btn-nav" style="width: 100%; cursor: pointer; margin-top: 10px;">
                    <?= $status_form ?> Data 💾
                </button>
            </form>
        </div>

        <div class="card" style="padding: 25px; background: white; border-radius: 15px;">
            <h3 style="color: var(--text-dark); margin-bottom: 20px;">Arsip Berita</h3>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="60">Img</th>
                            <th>Judul & Tanggal</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
                        while($d = mysqli_fetch_array($qry)){
                        ?>
                        <tr>
                            <td style="vertical-align: middle;">
                                <img src="uploads/<?= $d['gambar'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; background: #eee;">
                            </td>
                            <td style="vertical-align: middle;">
                                <strong><?= $d['judul'] ?></strong>
                                <br>
                                <span style="font-size: 11px; color: #888;">📅 <?= $d['tanggal'] ?> | 🏷️ <?= $d['kategori'] ?></span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    
                                    <a href="index_admin.php?edit=<?= $d['id'] ?>" style="
                                        background: #e3f2fd; 
                                        color: #1565c0; 
                                        padding: 6px 12px; 
                                        border-radius: 6px; 
                                        text-decoration: none; 
                                        font-size: 12px; 
                                        font-weight: bold; 
                                        display: flex; 
                                        align-items: center; 
                                        gap: 5px;
                                        transition: 0.3s;"
                                        onmouseover="this.style.background='#bbdefb'" 
                                        onmouseout="this.style.background='#e3f2fd'">
                                        ✏️ Edit
                                    </a>
                                    
                                    <a href="?hapus=<?= $d['id'] ?>" onclick="return confirm('Yakin ingin menghapus berita ini?')" style="
                                        background: #ffebee; 
                                        color: #c62828; 
                                        padding: 6px 12px; 
                                        border-radius: 6px; 
                                        text-decoration: none; 
                                        font-size: 12px; 
                                        font-weight: bold;
                                        display: flex; 
                                        align-items: center;
                                        gap: 5px;
                                        transition: 0.3s;"
                                        onmouseover="this.style.background='#ffcdd2'" 
                                        onmouseout="this.style.background='#ffebee'">
                                        🗑️ Hapus
                                    </a>

                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>