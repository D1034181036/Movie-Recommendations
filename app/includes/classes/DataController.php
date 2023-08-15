<?php

require_once("../app/includes/classes/DBConnection.php");

class DataController extends DBConnection {

    public function __construct() {
        parent::__construct();            
    }

    public function createMoviesTable() {
        $query = '
            CREATE TABLE IF NOT EXISTS `movies` (
                `id` int NOT NULL,
                `title` varchar(255) DEFAULT NULL,
                `genres` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`),
                FULLTEXT KEY `title` (`title`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
        ';

        $this->con->exec($query);
    }

    public function createLinksTable() {
        $query = '
            CREATE TABLE IF NOT EXISTS `links` (
                `id` int NOT NULL,
                `imdb_id` int DEFAULT NULL,
                `tmdb_id` int DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
        ';

        $this->con->exec($query);
    }

    public function importMovies($filePath) {
        if (($handle = fopen($filePath, 'r')) !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $query = $this->con->prepare("INSERT INTO movies (id, title, genres) VALUES (:id, :title, :genres)");
                $query->bindParam(":id", $data[0]);
                $query->bindParam(":title", $data[1]);
                $query->bindParam(":genres", $data[2]);
                $query->execute();
            }
            fclose($handle);
        } else {
            echo "\n無法開啟檔案：{$filePath}\n";
        }
    }

    public function importLinks($filePath) {
        if (($handle = fopen($filePath, 'r')) !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $data[2] = $data[2] === '' ? null : $data[2];
                $query = $this->con->prepare("INSERT INTO links (id, imdb_id, tmdb_id) VALUES (:id, :imdb_id, :tmdb_id)");
                $query->bindParam(":id", $data[0]);
                $query->bindParam(":imdb_id", $data[1]);
                $query->bindParam(":tmdb_id", $data[2]);
                $query->execute();
            }
            fclose($handle);
        } else {
            echo "\n無法開啟檔案：{$filePath}\n";
        }
    }
}
