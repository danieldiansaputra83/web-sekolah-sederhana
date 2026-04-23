<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

include 'koneksi.php';
include 'header.php';

// --- INISIALISASI VARIABEL ---
$id_edit = "";
$icon = "";
$nama = "";
$deskripsi = "";
$status_form = "Tambah";

// --- MODE EDIT ---
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $q_edit = mysqli_query($koneksi, "SELECT * FROM ekskul WHERE id='$id_edit'");
    $d_edit = mysqli_fetch_assoc($q_edit);
    
    $icon = $d_edit['icon'];
    $nama = $d_edit['nama_ekskul'];
    $deskripsi = $d_edit['deskripsi'];
    $status_form = "Update";
}

// --- HAPUS ---
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM ekskul WHERE id='".$_GET['hapus']."'");
    echo "<script>alert('Ekskul dihapus!'); window.location='admin_ekskul.php';</script>";
}

// --- SIMPAN ---
if (isset($_POST['simpan'])) {
    $icon_post = $_POST['icon'];
    $nama_post = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $desk_post = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $id_post   = $_POST['id_ekskul'];

    if ($id_post == "") {
        // INSERT
        $sql = "INSERT INTO ekskul (nama_ekskul, deskripsi, icon) VALUES ('$nama_post', '$desk_post', '$icon_post')";
    } else {
        // UPDATE
        $sql = "UPDATE ekskul SET nama_ekskul='$nama_post', deskripsi='$desk_post', icon='$icon_post' WHERE id='$id_post'";
    }

    if(mysqli_query($koneksi, $sql)){
        echo "<script>alert('Data berhasil disimpan!'); window.location='admin_ekskul.php';</script>";
    }
}
?>

<div class="container">
    <h2 style="margin-bottom: 20px; color: var(--primary-dark);">Kelola Ekstrakurikuler</h2>
    <?php include 'admin_menu.php'; ?>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
        
        <div class="card" style="padding: 25px; background: white; border-radius: 15px; height: fit-content; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
                <h3 style="color: var(--primary); margin:0;"><?= $status_form ?> Ekskul</h3>
                <?php if($status_form == "Update") { ?>
                    <a href="admin_ekskul.php" style="color:red; font-size:12px; text-decoration:none;">[Batal]</a>
                <?php } ?>
            </div>

            <form method="POST">
                <input type="hidden" name="id_ekskul" value="<?= $id_edit ?>">

                <label>Pilih Emoji Icon</label>
                <input type="text" name="icon" value="<?= $icon ?>" placeholder="🏀 / 🥋 / 🎸" style="font-size: 24px; text-align: center;" required>
                
                <label>Nama Ekskul</label>
                <input type="text" name="nama" value="<?= $nama ?>" required>
                
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" required><?= $deskripsi ?></textarea>

                <button type="submit" name="simpan" class="btn-nav" style="width: 100%; cursor: pointer;">
                    <?= $status_form ?> Data
                </button>
            </form>
        </div>

        <div class="card" style="padding: 25px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="50">Icon</th>
                        <th>Nama Ekskul</th>
                        <th>Deskripsi</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = mysqli_query($koneksi, "SELECT * FROM ekskul ORDER BY nama_ekskul ASC");
                    while($d = mysqli_fetch_assoc($qry)){
                    ?>
                    <tr>
                        <td style="font-size: 24px; text-align: center;"><?= $d['icon'] ?></td>
                        <td><strong><?= $d['nama_ekskul'] ?></strong></td>
                        <td style="color: #666; font-size: 13px;"><?= $d['deskripsi'] ?></td>
                        <td>
                            <a href="?edit=<?= $d['id'] ?>" style="background: #e3f2fd; color: #1565c0; padding: 5px 8px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 5px;">✏️</a>
                            <a href="?hapus=<?= $d['id'] ?>" onclick="return confirm('Hapus?')" style="background: #ffebee; color: #c62828; padding: 5px 8px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold;">🗑️</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>