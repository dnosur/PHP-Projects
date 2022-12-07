<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фильмишки</title>
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/DropdownMenu.css">
<link rel="stylesheet" href="css/FilmsBlock.css">

<script>
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    document.getElementById("myDropdown").onclick = onClick
  }

  
  // Close the dropdown if the user clicks outside of it
  function onClick(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>

<?php

function UpdateGanreDB($genre){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "FilmsDb";

  $connect = new mysqli($servername, $username, $password, $dbname);

  if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  else{
    $connect->query('UPDATE categoryes SET iscurrent = FALSE');
    $connect->query('UPDATE categoryes SET iscurrent = TRUE where category = "' . $genre . '";');
  }
}

$allGeners = TRUE;
$currentGenre = "Все";

$isSearch = FALSE;
$searchResult = null;

$isAdmin = FALSE;

if(isset($_GET['isAdmin'])){
  $isAdmin = TRUE;
}
if(isset($_POST['isAdmin'])){
  $isAdmin = TRUE;
}

if(isset($_POST['AddFilmButton'])){
  $file = $_FILES['file'];
  $filename = $_FILES["file"]["name"];

  $filmName = $_POST['name'];
  $genre = $_POST['genre'];
  $raiting = $_POST['raiting'];
  $about = $_POST['about'];

  $isAdmin = TRUE;

  move_uploaded_file($file['tmp_name'], __DIR__ . "/images/" . $filename);

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
}

if(isset($_POST["ChangeFilmButton"])){
  $file = $_FILES['file'];
  $filename = $_FILES["file"]["name"];

  echo "<h1> $file </h1>";

  $filmName = $_POST['name'];
  $genre = $_POST['genre'];
  $raiting = $_POST['raiting'];
  $about = $_POST['about'];

  $oldFilmName = $_POST['oldFilmName'];

  move_uploaded_file($file['tmp_name'], __DIR__ . "/images/" . $filename);

  $contents = file_get_contents(__DIR__ . "/images/" . $filename);
  $base64   = base64_encode($contents);

  $isAdmin = TRUE;

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "FilmsDb";

  $connect = new mysqli($servername, $username, $password, $dbname);

  if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  else{
    $query = "UPDATE filmdetails SET name = '$filmName', img='$base64', category = '$genre', raiting = $raiting, about = '$about', img_data = 'image/png' WHERE LOWER(name) = LOWER('$oldFilmName')";
    $connect->query($query);
  }
}

if(isset($_POST['HomeButton'])){
  UpdateGanreDB($currentGenre);
}

if(isset($_POST['GenreButton'])){
  if(isset($_POST['genre'])){
    $allGeners = FALSE;
    $currentGenre = $_POST['genre'];

    UpdateGanreDB($currentGenre);
  }
}

if(isset($_POST['SearchButton'])){
  $isSearch = TRUE;

  if($_POST['genre'] != "Все"){
    $currentGenre = $_POST['genre'];
    $allGeners = FALSE;
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "FilmsDb";

  $connect = new mysqli($servername, $username, $password, $dbname);

  if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  else{
    if($allGeners){
      $query = 'SELECT * FROM filmdetails WHERE LOWER(name) = LOWER("'. $_POST['Search'] .'")';
      $res = $connect->query($query);

      if($res->num_rows > 0){
        $searchResult = $res;
      }
    }
    else{
      $query = 'SELECT * FROM filmdetails WHERE LOWER(name) = LOWER("'. $_POST['Search'] .'") AND category = "' . $currentGenre . '";';
      $res = $connect->query($query);

      if($res->num_rows > 0){
        $searchResult = $res;
      }
    }
  }
}

?>

<body style="background-color: #1b1b35; ">
    <div style="border: 2px solid black; height: 100%; margin-left: 0%; background-color: #1A1D33; position: fixed; padding-top: 20px; top: 0; left: 0; flex-wrap: wrap; display: block;">
        <nav>
            <form class="form-inline" method="post" action="/" style="padding: 10%;">
              <input type="hidden" value = <?php echo $currentGenre ?> name = "genre">
              <input type="hidden" name="isAdmin" value = <?php echo $isAdmin ?>>

              <input class="form-control mr-sm-2" type="search" name = "Search" placeholder="Search" aria-label="Search">
              <div style="margin-top: 10%;"><button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="SearchButton">Search</button> </div> 
            </form>
        </nav>

        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
          <form action="/" method = "post">
            <input type="hidden" name="isAdmin" value = <?php echo $isAdmin ?>>
            <button class="dropbtn" style="background-color: green;" name = "HomeButton">Home</button>
          </form>
        </div>

        <div class="dropdown" style="margin-top: 50px;">
          <button onclick="myFunction()" class="dropbtn">Категории</button>
          <div id="myDropdown" class="dropdown-content">
            <?php 
              include 'modules/categoryes.php';

            ?>
          </div>
        </div>
        <?php 
            if($isAdmin){
        ?>

        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
            <form action="modules/AddFilmPage.php">
            <button class="dropbtn" style="background-color: red;">Add</button>
        </form>
            </div>


        <?php 
            }
        ?>
    </div>
    

    <div style="display: flex; flex-wrap: wrap;">
      <?php 

function GetImgBinaryByFilmName($name, $connect){
  $query = 'SELECT img FROM filmdetails WHERE name = "' . $name . '";';
  $res = $connect->query($query);

  if($res->num_rows > 0){
      $row = $res->fetch_assoc();
      return ('data:' . 'image/png' . ';base64,' . $row['img']);
  }
  else{
      echo "<h1>False</h1>";
  }
}

  if($allGeners && !$isSearch){
    include 'modules/content.php';
  }
  else if(!$allGeners && !$isSearch){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FilmsDb";

    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    else{
      $res = $connect->query("SELECT * FROM filmdetails");
    
      echo '<div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px;">';
      echo '<h1 style="color: #D2D3FA;"> ' . $_POST['category'] . '</h1></div>';

      echo '<div class="filmsblock">';
      if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
          if($row['category'] == $currentGenre || $currentGenre == "Все"){
            echo '<div><form method="post" action="modules/filmView.php">';

            echo '<input type="hidden" name="filmName" value="'. $row['name'] .'">';
            echo '<input type="hidden" name="img" value="' . GetImgBinaryByFilmName($row['name'], $connect) .'">';
            echo '<input type="hidden" name="raiting" value="'. $row['raiting'] .'">';
            echo '<input type="hidden" name="category" value="'. $row['category'] .'">';
            echo '<input type="hidden" name="about" value="'. $row['about'] .'">';
            echo '<input type="hidden" name="isAdmin" value="'. $isAdmin .'">';

            echo '<button style="background-color: rgba(28,28,28,0); border: none;" >';
            echo '<h1><img src= "' . GetImgBinaryByFilmName($row['name'], $connect) . '" width="250" height="380"></h1>';
            echo '<h4 style="color: #E5C8FA;">'. $row['name'] .'</h4></button></form></div>';
          }
        }
      }
      echo '</div>';
    }
  }
  else if($isSearch){
    echo '<div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px;">';

    if($searchResult == null){
      if(!$allGeners){
        echo '<h1 style="color: #D2D3FA;"> По запросу ' . $_POST['Search'] . ' из жанра '. $currentGenre .' ничего не найдено!</h1></div>';
      }
      else{
        echo '<h1 style="color: #D2D3FA;"> По запросу ' . $_POST['Search'] . ' ничего не найдено!</h1></div>';
      }
    }
    else{
      echo '<h1 style="color: #D2D3FA;"> Результаты по запросу ' . $_POST['Search'] . '</h1></div>';

      echo '<div class="filmsblock">';
      while($row = $searchResult->fetch_assoc()){
        echo '<div><form method="post" action="modules/filmView.php">';

        echo '<input type="hidden" name="filmName" value="'. $row['name'] .'">';
        echo '<input type="hidden" name="img" value="' . GetImgBinaryByFilmName($row['name'], $connect) .'">';
        echo '<input type="hidden" name="raiting" value="'. $row['raiting'] .'">';
        echo '<input type="hidden" name="category" value="'. $row['category'] .'">';
        echo '<input type="hidden" name="about" value="'. $row['about'] .'">';
        echo '<input type="hidden" name="isAdmin" value="'. $isAdmin .'">';

        echo '<button style="background-color: rgba(28,28,28,0); border: none;" >';
        echo '<h1><img src= "' . GetImgBinaryByFilmName($row['name'], $connect) . '" width="250" height="380"></h1>';
        echo '<h4 style="color: #E5C8FA;">'. $row['name'] .'</h4></button></form></div>';
      }
      echo '</div>';
    }
  }
  ?>

      
    </div>
</body>
</html>