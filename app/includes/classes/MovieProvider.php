<?php

require_once("../app/includes/classes/DBConnection.php");
require_once("../app/includes/classes/QdrantApiService.php");

class MovieProvider extends DBConnection {
    private $qdrantApiService;

    public function __construct() {
        parent::__construct();
        $this->qdrantApiService = new QdrantApiService();
    }

    public function get($rows = 10) {
        $query = $this->con->prepare('SELECT * FROM movies ORDER BY id LIMIT :limit');
        $query->bindParam(':limit', $rows, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function autoComplete($term, $rows = 10) {
        $query = $this->con->prepare('SELECT * FROM movies WHERE title LIKE :term LIMIT :limit');
        $query->bindValue(':term', "%{$term}%");
        $query->bindParam(':limit', $rows, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = $this->con->prepare('
            SELECT m.id, m.title, l.imdb_id, l.tmdb_id FROM movies m
            INNER JOIN links l ON m.id = l.id
            WHERE m.id=:id
        ');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function getByIds(array $ids) {
        $inPlaceholder = implode(',', array_fill(0, count($ids), '?'));
        
        $query = $this->con->prepare("
            SELECT m.id, m.title, l.imdb_id, l.tmdb_id FROM movies m
            INNER JOIN links l ON m.id = l.id
            WHERE m.id IN ({$inPlaceholder})
        ");
        
        foreach ($ids as $index => $id) {
            $query->bindValue($index + 1, $id, PDO::PARAM_INT);
        }
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecommendations($id, $rows = 10) {
        $response = $this->qdrantApiService->getRecommendMovies($id, $rows);

        if (empty($response['result'])) {
            return [];
        }
        
        $recMovieIds = array_column($response['result'], 'id');
        $recMovies = $this->getByIds($recMovieIds);
        $recMoviesMaps = array_combine(array_column($recMovies, 'id'), $recMovies);

        $result = array_map(function($row) use ($recMoviesMaps) {
            return array_merge(
                $recMoviesMaps[$row['id']],
                ['similarity' => $row['score']]
            );
        }, $response['result']);

        return $result;
    }
}
