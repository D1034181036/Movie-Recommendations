<?php

require_once("../app/config/config.php");
require_once("../app/includes/classes/DataController.php");

$data = new DataController();

$data->createMoviesTable();
$data->createLinksTable();

$data->importMovies('./movies.csv');
$data->importLinks('./links.csv');
