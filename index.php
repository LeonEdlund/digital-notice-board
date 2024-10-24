<?php
require 'utils/functions.php';
$page = (isset($_GET['page'])) ? trim($_GET['page']) : "alla";
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

// Get all posts 
$posts = ($page === 'alla') ? $dbh->getAllPosts() : $dbh->getPostsByCategory($page);

// upload a post from screen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $category = $_POST['category'];
  $dates = (!empty($_POST['date'])) ? json_encode($_POST['date'], true) : "";
  $body = $_POST['description'];

  require_once("utils/TextValidator.php");
  $validator = new TextValidator();
  $errors = $validator->validatePost($title, $category, $dates, $body);
  $className = "class='validation-error'";

  if (empty($errors)) {
    $dbh->uploadPost($title, $body, $category, $dates);
    $postUploaded = true;
    $errors = [];
  }
}

require_once("views/index.view.php");
