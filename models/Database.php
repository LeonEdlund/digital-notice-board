<?php

class Database
{
  private $dbh;
  private $categories;

  public function __construct()
  {
    $dsn = 'mysql:dbname=interactive-screen;host=localhost';
    $user = 'root';
    $password = '';

    $this->dbh = new PDO($dsn, $user, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
    $this->categories = [
      "evenemang" => "event",
      "aktiviteter" => "activity",
      "utbildning" => "education",
      "kop-salj" => "buy",
      "efterlyst" => "lost",
      "samhallsinformation" => "info",
      "ovrigt" => "else"
    ];
  }

  private function query($queryStr, $params = [])
  {
    $stmt = $this->dbh->prepare($queryStr);
    $stmt->execute($params);

    return $stmt;
  }

  public function uploadPost($title, $body, $category, $dates)
  {
    $url = "images/placeholders/";
    $fileType = ".svg";

    $query = "INSERT INTO ads(title, body, category, img) VALUES (:title, :body, :category, :img)";

    $this->query($query, [
      ':title' => $title,
      ':body' => $body,
      ':category' => $category,
      ':img' => $url . $category . $fileType
    ]);

    // Get the last inserted ad ID
    $adId = $this->dbh->lastInsertId();

    if (!empty($dates)) {
      $datesArray = array_map('trim', explode(',', $dates));
      foreach ($datesArray as $date) {
        $dateTime = DateTime::createFromFormat('d/m', $date);
        $formattedDate = $dateTime->format('Y-m-d'); // Format the date for MySQL
        $this->query("INSERT INTO event_dates (ad_id, event_date) VALUES (:adId, :eventDate)", [
          ':adId' => $adId,
          ':eventDate' => $formattedDate
        ]);
      }
    }
  }

  public function getAllPosts()
  {
    $query = "SELECT * FROM ads ORDER BY created_at DESC";
    return $this->query($query)->fetchAll();
  }

  public function getAllPostsOnDate($date)
  {
    $query = "SELECT ads.*, event_dates.event_date FROM ads 
              JOIN event_dates ON ads.id = event_dates.ad_id 
              WHERE event_dates.event_date = :input_date 
              ORDER BY ads.created_at DESC";
    return $this->query($query, [":input_date" => $date])->fetchAll();
  }

  public function getPostsByCategoryOnDate($chosenCat, $date)
  {
    $category = $this->categories[$chosenCat];

    $query = "SELECT ads.*, event_dates.event_date FROM ads 
              JOIN event_dates ON ads.id = event_dates.ad_id 
              WHERE ads.category = :cat AND event_dates.event_date = :input_date 
              ORDER BY ads.created_at DESC";
    return $this->query($query, [":cat" => $category, ":input_date" => $date])->fetchAll();
  }

  public function getPostsByCategory($chosenCat)
  {
    $category = $this->categories[$chosenCat];

    $query = "SELECT * FROM ads WHERE category = :cat ORDER BY created_at DESC";
    return $this->query($query, [':cat' => $category])->fetchAll();
  }



  public function getPostById($id)
  {
    $query = "SELECT * FROM ads WHERE ads.id = :id";
    return $this->query($query, [':id' => $id])->fetch();
  }



  public function getEventDatesByPostId($adId)
  {
    $query = "SELECT event_date FROM event_dates WHERE ad_id = :ad_id ORDER BY event_date";
    $date = $this->query($query, [':ad_id' => $adId])->fetchAll();

    foreach ($date as $key => $value) {
      $dateTime = DateTime::createFromFormat('Y-m-d', $value->event_date);
      $date[$key]->event_date = $dateTime->format('d/m');
    }

    return $date;
  }
}
