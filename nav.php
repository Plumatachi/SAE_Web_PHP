<nav class="nav-bar">
    <ul>
        <li><a href="index.php"><img src="https://picsum.photos/100" alt="Logo"></a></li>
        <li><a href="">Artistes</a></li>
        <li><a href="albums.php">Albums</a></li>
        <li><a href="">Playlists</a></li>
        <li><input type="search" name="search" id="search" placeholder="Rechercher..."></li>
        <?php
        session_start();
        if (isset($_SESSION['pseudo'])) {
            echo '<li><a href="">' . $_SESSION['pseudo'] . '</a></li>';
        } else {
            echo '<li><a href="page_login.php">Login</a></li>';
        }
        ?>
    </ul>
</nav>
