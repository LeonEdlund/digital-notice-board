<?php

class Database
{
  private $dbh;

  public function __construct()
  {
    $dsn = 'mysql:dbname=interactive-screen;host=localhost';
    $user = 'root';
    $password = '';

    $this->dbh = new PDO($dsn, $user, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
  }

  private function query($queryStr, $params = [])
  {
    $stmt = $this->dbh->prepare($queryStr);
    $stmt->execute($params);

    return $stmt;
  }

  public function uploadPost($title, $body, $category, $dates = null)
  {
    $url = "images/placeholders/";
    $fileType = ".svg";

    $query = "INSERT INTO ads(title, body, category, img, event_dates) VALUES (:title, :body, :category, :img, :eventDates)";

    return $this->query($query, [
      ':title' => $title,
      ':body' => $body,
      ':category' => $category,
      ':img' => $url . $category . $fileType,
      ':eventDates' => $dates
    ]);
  }

  public function getAllPosts()
  {
    $query = "SELECT * FROM ads ORDER BY created_at DESC";
    return $this->query($query)->fetchAll();
  }

  public function getPostsByCategory($chosenCat)
  {
    $categories = [
      "evenemang" => "event",
      "aktiviteter" => "activity",
      "utbildning" => "education",
      "kop-salj" => "buy",
      "efterlyst" => "lost",
      "samhallsinformation" => "info",
      "ovrigt" => "else"
    ];
    $category = $categories[$chosenCat];

    $query = "SELECT * FROM ads WHERE category = :cat ORDER BY created_at DESC";
    return $this->query($query, [':cat' => $category])->fetchAll();
  }

  public function getPostById($id)
  {
    $query = "SELECT * FROM ads WHERE id = :id";
    return $this->query($query, [':id' => $id])->fetch();
  }
}
