<?php
session_start();
// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

include 'koneksi.php';
include 'header.php';

// --- INISIALISASI VARIABEL ---
$id_edit = "";
$kode = "";
$nama = "";
$lama = "";
$status_form = "Tambah"; // Default mode

// --- LOGIKA 1: MODE EDIT (AMBIL DATA) ---
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $q_edit = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE id='$id_edit'");
    $d_edit = mysqli_fetch_assoc($q_edit);
    
    $kode = $d_edit['kode_jurusan'];
    $nama = $d_edit['nama_jurusan'];
    $lama = $d_edit['lama_belajar'];
    $status_form = "Update";
}

// --- LOGIKA 2: HAPUS ---
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM jurusan WHERE id='".$_GET['hapus']."'");
    echo "<script>alert('Jurusan dihapus!'); window.location='admin_jurusan.php';</script>";
}

// --- LOGIKA 3: SIMPAN (CREATE / UPDATE) ---
if (isset($_POST['simpan'])) {
    $kode_post = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama_post = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $lama_post = mysqli_real_escape_string($koneksi, $_POST['lama']);
    $id_post   = $_POST['id_jurusan']; // Hidden ID

    if ($id_post == "") {
        // MODE TAMBAH
        $sql = "INSERT INTO jurusan (kode_jurusan, nama_jurusan, lama_belajar) VALUES ('$kode_post', '$nama_post', '$lama_post')";
    } else {
        // MODE UPDATE
        $sql = "UPDATE jurusan SET kode_jurusan='$kode_post', nama_jurusan='$nama_post', lama_belajar='$lama_post' WHERE id='$id_post'";
    }

    if(mysqli_query($koneksi, $sql)){
        echo "<script>alert('Data berhasil disimpan!'); window.location='admin_jurusan.php';</script>";
    }
}
?>

<div class="container">
    <h2 style="margin-bottom: 20px; color: var(--primary-dark);">Kelola Kurikulum</h2>
    <?php include 'admin_menu.php'; ?>

    <div class="card" style="padding: 25px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
            <h4 style="margin:0; color: var(--primary);"><?= $status_form ?> Jurusan / Kompetensi</h4>
            <?php if($status_form == "Update") { ?>
                <a href="admin_jurusan.php" style="color:red; font-size:12px; text-decoration:none;">[Batal Edit]</a>
            <?php } ?>
        </div>

        <form method="POST" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="hidden" name="id_jurusan" value="<?= $id_edit ?>">

            <input type="text" name="kode" value="<?= $kode ?>" placeholder="Kode (misal: RPL)" required style="width: 120px; margin:0;">
            <input type="text" name="nama" value="<?= $nama ?>" placeholder="Nama Jurusan Lengkap" required style="flex: 1; min-width: 200px; margin:0;">
            <input type="text" name="lama" value="<?= $lama ?>" placeholder="Durasi (3 Tahun)" required style="width: 150px; margin:0;">
            
            <button type="submit" name="simpan" class="btn-nav" style="border:none; cursor:pointer;">
                <?= $status_form ?>
            </button>
        </form>
    </div>

    <div class="card" style="padding: 20px; background: white; border-radius: 15px;">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="100">Kode</th>
                    <th>Nama Kompetensi Keahlian</th>
                    <th>Lama Belajar</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $qry = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY kode_jurusan ASC");
                while($d = mysqli_fetch_assoc($qry)){
                ?>
                <tr>
                    <td style="font-weight: bold; color: var(--primary);"><?= $d['kode_jurusan'] ?></td>
                    <td><?= $d['nama_jurusan'] ?></td>
                    <td><span style="background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-size: 12px;"><?= $d['lama_belajar'] ?></span></td>
                    <td>
                        <a href="?edit=<?= $d['id'] ?>" style="background: #e3f2fd; color: #1565c0; padding: 5px 8px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 5px;">✏️ Edit</a>
                        <a href="?hapus=<?= $d['id'] ?>" onclick="return confirm('Hapus?')" style="background: #ffebee; color: #c62828; padding: 5px 8px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold;">🗑️</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>