<?php
    require_once('../app/includes/header.php');
    require_once('../app/includes/classes/MovieProvider.php');
?>

<?php
    $movieProvider = new MovieProvider();
    $movies = $movieProvider->get($rows = 16);
?>

<h1>Movie Recommendations</h1>

<form id="search-form" method="get" action="movie.php">
    <input id="auto-complete" name="title" type="text" placeholder="搜尋電影（英文）"/>
</form>

<table border="1">
    <tr>
        <th>Movie</th>
    </tr>
    <?php foreach ($movies as $movie): ?>
        <tr>
            <td><a href="movie.php?id=<?= $movie['id'] ?>"><?= $movie['title'] ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once('../app/includes/footer.php'); ?>
