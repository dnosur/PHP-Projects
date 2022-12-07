<?php

function data_uri($file, $mime) 
{  
  $contents = file_get_contents($file);
  $base64   = base64_encode($contents); 
  return ('data:' . $mime . ';base64,' . $base64);
}

function GetImgBinaryByFilmName($name){
  $query = 'SELECT img FROM filmdetails WHERE name = "' . $name . '";';
  $res = $connect->query($query);

  $row = $res->fetch_assoc();
  return $row['img'];
}

$file = $_FILES['file'];
$filename = $_FILES["file"]["name"];
$tempname = $_FILES["file"]["tmp_name"];

$filmName = $_POST['name'];
$genre = $_POST['genre'];
$raiting = $_POST['raiting'];
$about = $_POST['about'];

//move_uploaded_file($file['tmp_name'], __DIR__ . "/images/" . $filename);

echo __DIR__ . "/images/" . $filename;
echo '<img src = "' . data_uri(__DIR__ . "/images/" . $filename, 'image/png') . '" />';

$contents = file_get_contents(__DIR__ . "/images/" . $filename);
$base64   = base64_encode($contents);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "FilmsDb";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
  $query = "INSERT INTO filmdetails(name, img, category, raiting, about, img_data) VALUES('" . $filmName . "', '" . $base64 . "', '" . $genre . "', " . $raiting . ", '" . $about . "', 'image/png');";
  $connect->query($query);
}

?>

