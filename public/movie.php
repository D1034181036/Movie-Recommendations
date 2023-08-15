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
    
    $recommendations = $movieProvider->getRecommendations($_GET['id'], 20);
?>

<h1><a href="index.php">Movie Recommendations</a></h1>

<table border="1">
    <tr>
        <th>Movie</th>
        <th>Similarity</th>
    </tr>
    <?php if ($movie): ?>
    <tr>
        <td><a href="https://www.imdb.com/title/tt<?= str_pad($movie['imdb_id'], 7, '0', STR_PAD_LEFT) ?>/" target="_blank"><?= $movie['title'] ?></a></td>
    </tr>
    <?php endif; ?>
    <?php foreach ($recommendations as $movie): ?>
        <tr>
            <td><a href="https://www.imdb.com/title/tt<?= str_pad($movie['imdb_id'], 7, '0', STR_PAD_LEFT) ?>/" target="_blank"><?= $movie['title'] ?></a></td>
            <td><?= number_format($movie['similarity'] * 100, 2) . '%' ?></td>
        </tr>
    <?php endforeach; ?>
</table>
