<?php
session_start();
// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

include 'koneksi.php';
include 'header.php';

// --- LOGIKA UPDATE PROFIL ---
if (isset($_POST['update_profil'])) {
    // 1. Ambil data teks
    $sejarah = mysqli_real_escape_string($koneksi, $_POST['sejarah']);
    $visi    = mysqli_real_escape_string($koneksi, $_POST['visi']);
    $misi    = mysqli_real_escape_string($koneksi, $_POST['misi']);
    
    // 2. Ambil data gambar lama dari database (untuk jaga-jaga kalau user gak upload baru)
    $q_lama = mysqli_query($koneksi, "SELECT gambar_gedung FROM profil_sekolah WHERE id=1");
    $d_lama = mysqli_fetch_assoc($q_lama);
    $gambar_fix = $d_lama['gambar_gedung']; // Default pakai gambar lama

    // 3. Cek apakah user upload gambar baru?
    if ($_FILES['gambar']['name'] != "") {
        $filename = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Buat nama baru (misal: gedung_173999.jpg)
        $nama_baru = "gedung_" . time() . "." . $ext;
        
        // Upload ke folder 'uploads/'
        if (move_uploaded_file($tmp_name, 'uploads/' . $nama_baru)) {
            // Hapus gambar lama jika bukan default
            if ($gambar_fix != 'default_gedung.jpg' && file_exists('uploads/'.$gambar_fix)) {
                unlink('uploads/'.$gambar_fix);
            }
            $gambar_fix = $nama_baru; // Update variabel gambar
        }
    }

    // 4. Update Database
    $query = "UPDATE profil_sekolah SET 
              sejarah='$sejarah', 
              visi='$visi', 
              misi='$misi', 
              gambar_gedung='$gambar_fix' 
              WHERE id=1";
              
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Profil & Gambar berhasil diperbarui!');</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// --- AMBIL DATA TERBARU UNTUK DITAMPILKAN DI FORM ---
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM profil_sekolah WHERE id=1"));
?>

<div class="container">
    <h2 style="margin-bottom: 20px; color: var(--primary-dark);">Edit Profil Sekolah</h2>
    
    <?php include 'admin_menu.php'; ?>

    <form method="POST" enctype="multipart/form-data" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 30px;">
            
            <div>
                <label style="font-weight: bold; color: var(--primary);">📷 Foto Gedung Sekolah</label>
                
                <div style="margin: 10px 0; border: 2px dashed #ddd; padding: 5px; border-radius: 10px; text-align: center;">
                    <?php if (!empty($data['gambar_gedung'])) : ?>
                        <img src="uploads/<?= $data['gambar_gedung']; ?>" style="max-width: 100%; height: auto; border-radius: 5px;">
                    <?php else : ?>
                        <p style="color: #aaa; padding: 20px;">Belum ada gambar</p>
                    <?php endif; ?>
                </div>

                <input type="file" name="gambar" accept="image/*" style="font-size: 12px;">
                <small style="color: #888; display: block; margin-top: 5px;">*Biarkan kosong jika tidak ingin mengganti foto.</small>
            </div>

            <div>
                <label style="font-weight: bold; color: var(--primary);">📜 Sejarah Singkat</label>
                <textarea name="sejarah" rows="12" required><?= $data['sejarah']; ?></textarea>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="font-weight: bold; color: var(--primary);">🎯 Visi</label>
                <textarea name="visi" rows="5" required><?= $data['visi']; ?></textarea>
            </div>
            <div>
                <label style="font-weight: bold; color: var(--primary);">🚀 Misi</label>
                <textarea name="misi" rows="5" required><?= $data['misi']; ?></textarea>
            </div>
        </div>

        <button type="submit" name="update_profil" class="btn-nav" style="width: 200px; cursor: pointer; margin-top: 25px; border: none;">
            💾 Simpan Perubahan
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>