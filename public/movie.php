<?php
    require_once('../app/includes/header.php');
    require_once('../app/includes/classes/MovieProvider.php');
?>

<?php
    if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('location: index.php');
        exit();
    }

    $movieProvider = new MovieProvider();
    $movie = $movieProvider->getById($_GET['id']);

    if (empty($movie)) {
        header('location: index.php');
        exit();
    }
    
    $recommendations = $movieProvider->getRecommendations($_GET['id'], $rows = constant('RECOMMEND_MOVIE_ROWS'));
?>

<div class="title">
    <h1><a href="/">Movie Recommendations</a></h1>
</div>

<div>
    <form id="search-form" method="get" action="movie.php">
        <input id="auto-complete" name="title" type="text" placeholder="搜尋電影（英文）"/>
    </form>
</div>

<div class="movie-table">
    <table class="movie-table">
        <tr>
            <th>Movie</th>
            <th>Similarity</th>
        </tr>
        <?php if ($movie): ?>
        <tr>
            <td class="target-movie"><a href="https://www.imdb.com/title/tt<?= str_pad($movie['imdb_id'], 7, '0', STR_PAD_LEFT) ?>/" target="_blank"><?= $movie['title'] ?></a></td>
            <td></td>
        </tr>
        <?php endif; ?>
        <?php foreach ($recommendations as $movie): ?>
            <tr>
                <td><a href="https://www.imdb.com/title/tt<?= str_pad($movie['imdb_id'], 7, '0', STR_PAD_LEFT) ?>/" target="_blank"><?= $movie['title'] ?></a></td>
                <td><?= number_format($movie['similarity'] * 100, 2) . '%' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once('../app/includes/footer.php'); ?>
