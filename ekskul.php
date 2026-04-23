<?php 
include 'koneksi.php';
include 'header.php'; 
?>

<div class="container">
    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: 10px;">Minat & Bakat</h2>
        <div style="width: 60px; height: 4px; background: var(--accent); margin: 0 auto;"></div>
        <p style="margin-top: 15px; color: #666;">Salurkan energimu melalui kegiatan positif di luar jam pelajaran.</p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;">
        
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM ekskul ORDER BY id ASC");
        while($row = mysqli_fetch_assoc($query)) {
        ?>
            <div style="
                background: white; 
                width: 300px; 
                border-radius: 20px; 
                padding: 30px; 
                text-align: center; 
                box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
                transition: transform 0.3s; 
                border: 1px solid #eee;"
                onmouseover="this.style.transform='scale(1.05)'" 
                onmouseout="this.style.transform='scale(1)'">
                
                <div style="font-size: 4rem; margin-bottom: 15px; filter: drop-shadow(0 5px 5px rgba(0,0,0,0.2));">
                    <?php echo $row['icon']; ?>
                </div>
                
                <h3 style="color: var(--primary-dark); margin-bottom: 10px;"><?php echo $row['nama_ekskul']; ?></h3>
                
                <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 20px;">
                    <?php echo $row['deskripsi']; ?>
                </p>

                <a href="#" style="text-decoration: none; color: var(--primary); font-weight: bold; font-size: 0.9rem; border: 1px solid var(--primary); padding: 8px 20px; border-radius: 20px; transition: 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='var(--primary)'">
                    Gabung Sekarang
                </a>
            </div>
        <?php } ?>

    </div>
</div>

<?php include 'footer.php'; ?>