<?php

$page = (isset($_GET['page'])) ? trim($_GET['page']) : "alla";
$post = (isset($_GET['post'])) ? trim($_GET['post']) : 0;

require_once("views/index.view.php");
