<?php 
include 'koneksi.php';
include 'header.php';

// Ambil data profil (ID=1)
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM profil_sekolah WHERE id=1"));
?>

<div style="background: var(--primary-dark); color: white; padding: 40px 20px; text-align: center;">
    <h1 style="font-size: 2.5rem; margin-bottom: 5px;">Tentang Kami</h1>
    <p style="opacity: 0.8;">Mengenal lebih dekat SMK Negeri 67 Malliang</p>
</div>

<div class="container">
    
    <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 40px;">
        <div style="display: flex; flex-wrap: wrap; gap: 30px; align-items: center;">
            <div style="flex: 1; min-width: 300px;">
                <img src="uploads/<?php echo $data['gambar_gedung']; ?>" alt="Gedung Sekolah" style="width: 100%; border-radius: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            </div>
            <div style="flex: 1.5; min-width: 300px;">
                <h2 style="color: var(--primary); margin-bottom: 15px; border-left: 5px solid var(--accent); padding-left: 15px;">Sejarah Singkat</h2>
                <p style="line-height: 1.8; color: #555; text-align: justify;">
                    <?php echo nl2br($data['sejarah']); ?>
                </p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 5px solid var(--primary);">
            <h3 style="text-align: center; color: var(--primary-dark); margin-bottom: 20px;">Visi Sekolah</h3>
            <div style="font-size: 1.2rem; font-style: italic; text-align: center; color: #555; background: #e0f2f1; padding: 20px; border-radius: 10px;">
                "<?php echo $data['visi']; ?>"
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 5px solid var(--accent);">
            <h3 style="text-align: center; color: var(--text-dark); margin-bottom: 20px;">Misi Sekolah</h3>
            <div style="line-height: 1.8; color: #555;">
                <?php echo nl2br($data['misi']); ?>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>