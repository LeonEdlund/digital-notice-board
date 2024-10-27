<?php
require 'utils/functions.php';
$page = (isset($_GET['page'])) ? trim($_GET['page']) : "alla";
$searchDate = (isset($_GET['search_date']) && strlen($_GET['search_date']) > 0) ? trim($_GET['search_date']) : "";
$postUploaded = false;
$menuItems = [
  "alla" => "Alla annonser",
  "evenemang" => "Evenemang",
  "aktiviteter" => "Aktiviteter",
  "utbildning" => "Utbildning och Kurser",
  "kop-salj" => "Köp/Sälj/Byt",
  "efterlyst" => "Efterlyst/Borttappat",
  "samhallsinformation" => "Samhällsinformation"
];

// Database
require_once("Models/DataBase.php");
$dbh = new Database();

if ($searchDate) {
  $posts = ($page === 'alla') ? $dbh->getAllPostsOnDate($searchDate) : $dbh->getPostsByCategoryOnDate($page, $searchDate);
} else {
  // Get all posts 
  $posts = ($page === 'alla') ? $dbh->getAllPosts() : $dbh->getPostsByCategory($page);
}

foreach ($posts as &$post) {
  $post->dates = $dbh->getEventDatesByPostId($post->id);
}
unset($post); // Break the reference with the last element

// upload a post from screen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $category = $_POST['category'];
  $body = $_POST['description'];
  $dates = $_POST['date'];

  require_once("utils/TextValidator.php");
  $validator = new TextValidator();
  $errors = $validator->validatePost($title, $category, $body);
  $className = "class='validation-error'";

  if (empty($errors)) {
    $dbh->uploadPost($title, $body, $category, $dates);
    $postUploaded = true;
    $errors = [];
  }
}

require_once("views/index.view.php");
