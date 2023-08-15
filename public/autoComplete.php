<?php
	require_once("../app/config/config.php");
    require_once("../app/includes/classes/MovieProvider.php");

    $movieProvider = new MovieProvider();
    $movies = $movieProvider->autoComplete($_GET['term']);
    $result = [];

    foreach ($movies as $movie) {
        $result[] = [
            'id' => $movie['id'],
            'label' => $movie['title'],
        ];
    }

    echo json_encode($result);
?>
