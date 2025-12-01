<?php
// Détermine la page courante pour marquer le lien actif dans la navigation
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="site-header-inner">
        <div class="site-title-block">
            <a href="index.php" class="site-title">Mon Mini Blog</a>
            <span class="site-subtitle">Articles & commentaires</span>
        </div>
        <nav class="site-nav">
            <!-- Liens principaux du site; la classe "active" indique la page courante -->
            <a href="index.php"<?php if ($current_page === 'index.php') echo ' class="active"'; ?>>Accueil</a>
            <a href="lister.php"<?php if ($current_page === 'lister.php') echo ' class="active"'; ?>>Tous les articles</a>
            <a href="article.php"<?php if ($current_page === 'article.php') echo ' class="active"'; ?>>Nouvel article</a>
        </nav>
    </div>
</header>
