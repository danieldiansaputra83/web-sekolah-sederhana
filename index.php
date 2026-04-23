<?php 
include 'koneksi.php'; 
include 'header.php'; 
?>

<div style="background: linear-gradient(135deg, #009688 0%, #004d40 100%); color: white; padding: 80px 20px; text-align: center; border-radius: 0 0 50px 50px; margin-bottom: 40px;">
    <h1 style="font-size: 3rem; margin-bottom: 10px;">Welcome to the Future</h1>
    <p style="font-size: 1.2rem; opacity: 0.9;">Mewujudkan Generasi Emas yang Unggul dan Berteknologi.</p>
    <br>
    <a href="#berita" style="background: #ffab00; color: #333; padding: 12px 30px; text-decoration: none; border-radius: 50px; font-weight: bold; display: inline-block; transition: 0.3s;">Jelajahi Sekarang 🚀</a>
</div>

<div class="container" id="berita">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px;">
        <h2 class="section-title">Berita Terbaru</h2>
        <a href="#" style="color: var(--primary); text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        
        <?php
        $query = "SELECT * FROM berita ORDER BY id DESC LIMIT 6"; // Batasi 6 berita terbaru
        $result = mysqli_query($koneksi, $query);
        while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="card">
                <div style="height: 200px; overflow: hidden;">
                    <img src="uploads/<?php echo $row['gambar']; ?>" style="width:100%; height:100%; object-fit:cover; transition: 0.5s;">
                </div>
                
                <div style="padding: 20px;">
                    <span style="background: #e0f2f1; color: var(--primary-dark); padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold;"><?php echo $row['kategori']; ?></span>
                    
                    <h3 style="margin: 15px 0 10px 0; font-size: 18px;">
                        <a href="#" style="text-decoration: none; color: var(--text-dark);"><?php echo $row['judul']; ?></a>
                    </h3>
                    
                    <p style="color: #666; font-size: 14px; line-height: 1.6;"><?php echo substr($row['isi'], 0, 100); ?>...</p>
                    
                    <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px; display: flex; justify-content: space-between; font-size: 12px; color: #aaa;">
                        <span>📅 <?php echo $row['tanggal']; ?></span>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<?php include 'footer.php'; ?>