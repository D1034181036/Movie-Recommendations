# 專案說明
- 專案目標：建立一個電影特徵資料庫，並儲存至向量資料庫 [Qdrant](https://qdrant.tech/) 進行相似度排名推薦。
- 網站工具：這是一個使用 PHP、MySQL 以及 Qdrant 的專案。
- 資料集：使用 [MovieLens](https://grouplens.org/datasets/movielens/latest/) 的 `ratings.csv` 資料 (User-Item Ratings)。
- 特徵訓練：透過 PySpark-RDD 使用 Alternating Least Square (ALS) 演算法進行電影特徵訓練。
- 相似度計算：Cosine Similarity。

## 開始之前
1. 下載電影資料：[MovieLens Latest Datasets](https://grouplens.org/datasets/movielens/latest/)。
2. 建立一個 PHP、MySQL、Qdrant 的環境。
3. 學習使用 Google Colab。

## 訓練電影資料特徵
1. 在 Google Colab 的環境下使用 `data/MovieLens-Spark-ALS.ipynb` 進行資料訓練，並放入 Qdrant 資料庫。

## 網站設定
1. 複製 Config 檔案 `app/config/config-example.php` 並重新取名為 `app/config/config.php`。
2. 設定 Config 參數：在新建的 `config.php` 檔案中設定相關參數。
3. 將網站導向 public 資料夾。

## 資料庫設定
1. 導入資料集：將電影資料集的 `movies.csv` 和 `links.csv` 檔案放到 `data` 目錄下。
2. 匯入資料：運行 `cd data` 以及 `php import.php` 來將資料導入 MySQL 資料庫。

## 參考資料
1. [MovieLens Latest Datasets](https://grouplens.org/datasets/movielens/latest/) (Last accessed: 2023/08/12)
2. [Qdrant](https://qdrant.tech/) (Last accessed: 2023/08/12)
3. [Building a Movie Recommendation Service with Apache Spark & Flask - Part 1](https://www.codementor.io/@jadianes/building-a-recommender-with-apache-spark-python-example-app-part1-du1083qbw) (Last accessed: 2023/08/12)
4. [spark-movie-lens](https://github.com/jadianes/spark-movie-lens) (Last accessed: 2023/08/12)
5. [Recommendation Engines Using ALS in PySpark (MovieLens Dataset)](https://www.youtube.com/watch?v=FgGjc5oabrA) (Last accessed: 2023/08/12)
6. [How does Netflix recommend movies? Matrix Factorization](https://www.youtube.com/watch?v=ZspR5PZemcs) (Last accessed: 2023/08/12)
