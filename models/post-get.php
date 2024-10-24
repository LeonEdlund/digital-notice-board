<?php
// $posts = [[
//   'title' => 'Borttappad Hund',
//   'date' => '11/05-2025',
//   'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore!',
//   'img' => 'images/image.png'
// ], [
//   'title' => 'Kurs',
//   'date' => '02/01-2024',
//   'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore!',
//   'img' => 'images/poster.png'
// ]];






require_once('Database.php');
$dbh = new Database();

echo json_encode($dbh->getPostById($_GET['post']));
