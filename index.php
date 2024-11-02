<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require 'utils/functions.php';
$page = (isset($_GET['page'])) ? trim($_GET['page']) : "alla";
$searchDate = (isset($_GET['date']) && strlen($_GET['date']) > 0) ? trim($_GET['date']) : "";
$postUploaded = false;


$imgPath = "images/placeholders";
$menuItems = [
  "alla" => "<img src='$imgPath/all.svg' /> Alla annonser",
  "evenemang" => "<img src='$imgPath/event.svg' /> Evenemang",
  "aktiviteter" => "<img src='$imgPath/activity.svg' />  Aktiviteter",
  "utbildning" => "<img src='$imgPath/education.svg' />  Utbildning och Kurser",
  "jobb" => "<img src='$imgPath/work.svg' />  Jobb och tjänster",
  "kop-salj" => "<img src='$imgPath/buy.svg' />  Köp/Sälj/Byt",
  "efterlyst" => "<img src='$imgPath/lost.svg' />  Efterlyst/Borttappat",
  "samhallsinformation" => "<img src='$imgPath/info.svg' />  Samhällsinformation",
  "ovrigt" => "<img src='$imgPath/else.svg' />  Övrigt"
];






// Database
require_once("models/Database.php");
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
  $dates = $_POST['event_date'];

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
