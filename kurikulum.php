<?php 
include 'koneksi.php';
include 'header.php'; 
?>

<div style="background: var(--primary); color: white; padding: 40px 20px; text-align: center;">
    <h1 style="font-size: 2.5rem;">Kompetensi Keahlian</h1>
    <p style="opacity: 0.9;">Pilihan jurusan terbaik untuk masa depan cerah.</p>
</div>

<div class="container">
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-top: -50px;">
        
        <?php
        $qry = mysqli_query($koneksi, "SELECT * FROM jurusan");
        while($row = mysqli_fetch_assoc($qry)) {
            // Logika Warna Random untuk Variasi (Opsional)
            $colors = ['#ff6b6b', '#4ecdc4', '#1a535c', '#f7fff7', '#ffe66d'];
            $random_color = $colors[array_rand($colors)];
        ?>
        
        <div style="background: white; border-radius: 15px; padding: 30px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.08); transition: 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
            
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: var(--primary); opacity: 0.1; border-radius: 50%;"></div>

            <div style="width: 70px; height: 70px; background: var(--bg-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-weight: bold; color: var(--primary); font-size: 1.2rem; border: 2px solid var(--primary);">
                <?= $row['kode_jurusan'] ?>
            </div>

            <h3 style="margin-bottom: 10px; color: var(--text-dark);"><?= $row['nama_jurusan'] ?></h3>
            
            <p style="color: #888; font-size: 0.9rem; margin-bottom: 20px;">Fokus pada keahlian industri 4.0</p>

            <span style="background: var(--accent); color: #333; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">
                ⏱ <?= $row['lama_belajar'] ?>
            </span>
        </div>

        <?php } ?>

    </div>
</div>

<?php include 'footer.php'; ?>