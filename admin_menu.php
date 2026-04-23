<style>
    /* CSS Khusus Menu Admin */
    .admin-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .admin-nav a {
        text-decoration: none;
        color: #555;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 50px;
        background: white;
        border: 1px solid #ddd;
        transition: 0.3s;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Efek Hover & Active */
    .admin-nav a:hover, .admin-nav a.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(0,150,136,0.3);
        transform: translateY(-2px);
    }
</style>

<?php $page = basename($_SERVER['PHP_SELF']); ?>

<div class="admin-nav">
    <a href="index_admin.php" class="<?php if($page=='index_admin.php') echo 'active'; ?>">
        📰 Berita
    </a>
    <a href="admin_profil.php" class="<?php if($page=='admin_profil.php') echo 'active'; ?>">
        🏫 Profil Sekolah
    </a>
    <a href="admin_kurikulum.php" class="<?php if($page=='admin_kurikulum.php') echo 'active'; ?>">
        📚 Kurikulum
    </a>
    <a href="admin_ekskul.php" class="<?php if($page=='admin_ekskul.php') echo 'active'; ?>">
        🏃 Ekstrakurikuler
    </a>
</div>