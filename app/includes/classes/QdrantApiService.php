<?php

class QdrantApiService {
    private $endpoint;

    public function __construct() {
        $this->endpoint = constant('QDRANT_API_URL');
    }

    public function getRecommendMovies($id, $rows) {
        $url = "{$this->endpoint}/collections/movies/points/recommend";

        $jsonData = json_encode([
            'positive' => [(int) $id],
            'limit' => $rows,
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        curl_close($ch);

        return $response;
    }
}
