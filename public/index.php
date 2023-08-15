<?php
    require_once('../app/includes/header.php');
    require_once('../app/includes/classes/MovieProvider.php');
?>

<?php
    $movieProvider = new MovieProvider();
    $movies = $movieProvider->get($rows = constant('INDEX_MOVIE_ROWS'));
?>

<div class="title">
    <h1>Movie Recommendations</h1>
</div>

<div>
    <form id="search-form" method="get" action="movie.php">
        <input id="auto-complete" name="title" type="text" placeholder="搜尋電影（英文）"/>
    </form>
</div>

<div class="movie-table">
    <table class="">
        <tr>
            <th>Movie</th>
        </tr>
        <?php foreach ($movies as $movie): ?>
            <tr>
                <td><a href="movie.php?id=<?= $movie['id'] ?>"><?= $movie['title'] ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once('../app/includes/footer.php'); ?>
