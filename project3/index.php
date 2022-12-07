<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheBestGameShop</title>
    <link rel="shortcut icon" href="https://img.icons8.com/fluency/48/null/ps-controller.png" type="image/x-icon">
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/AddButton.css" >
<link rel="stylesheet" href="css/GameImg.css" >
<link rel="stylesheet" href="css/DropdownMenu.css">
<link rel="stylesheet" href="main/css/Slider.css">

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GameShopDb";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isAdmin = false;
$isLogin = false;

$user = null;
$category = 'All';

function SaveUserInfo($user, $isLogin, $isAdmin){
    echo '<input type="hidden" name="userId" value ="'.$user['id'].'">';
    echo '<input type="hidden" name="isLogin" value ="'.$isLogin.'">';
    echo '<input type="hidden" name="isAdmin" value ="'.$isAdmin.'">';
}

if(isset($_POST['SearchButton']) || isset($_POST['Sort']) || isset($_POST['Basket']) || isset($_POST['Buy']) || isset($_POST["Home"]) || isset($_POST['Remove']) || isset($_GET['Add']) || isset($_POST['Add']) || isset($_GET['Change']) || isset($_POST['Change']) || isset($_GET['about']) || isset($_POST['Comment'])){

    if(isset($_POST['userId'])){
        $res = $connect->query('SELECT * FROM users');
        if($res->num_rows > 0){

            while($row = $res->fetch_assoc()){
                if($row['id'] == $_POST['userId'] && $row['isadmin'] == $_POST['isAdmin']){

                    $isFailde = false;
                    $isAdmin = $row['isadmin'];
                    $isLogin = true;
                    $user = $row;
                    break;
                }
            }
        }
    }

    if(isset($_GET['userId'])){

        $res = $connect->query('SELECT * FROM users');
        if($res->num_rows > 0){

            while($row = $res->fetch_assoc()){
                if($row['id'] == $_GET['userId'] && $row['isadmin'] == $_GET['isAdmin']){

                    $isFailde = false;
                    $isAdmin = $row['isadmin'];
                    $isLogin = true;
                    $user = $row;
                    break;
                }
            }
        }
    }
}

if(isset($_POST['Sort'])){
    $category = $_POST['Category'];

    $connect->query('UPDATE categoryes SET iscurrent = FALSE');
    $connect->query('UPDATE categoryes SET iscurrent = TRUE where category = "' . $category . '";');
}

$isFailde = false;

if(isset($_POST['SingIn'])){
    $res = $connect->query('SELECT * FROM users');
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            if($row['password'] == $_POST['password'] && $row['login'] == $_POST['login']){
                $isAdmin = $row['isadmin'];
                $isLogin = true;
                $user = $row;
                break;
            }
        }

        if(!$isLogin) $isFailde = true;
    }
}

if(isset($_POST['SingUp'])){
    $res = $connect->query('SELECT * FROM users');
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            if($row['login'] == $_POST['login']){
                $isFailde = true;
                break;
            }
        }
    }

    if(!$isFailde){
        $file = $_FILES['img'];
        $filename = $_FILES["img"]["name"];

        move_uploaded_file($file['tmp_name'], __DIR__ . "/images/" . $filename);

        $contents = file_get_contents(__DIR__ . "/images/" . $filename);
        $base64   = base64_encode($contents);

        $connect->query("INSERT INTO users (login, password, img, isadmin) VALUES ('".$_POST['login']."', '".$_POST['password']."', 'data: image/png; base64,".$base64."', 0);");

        $res = $connect->query('SELECT * FROM users');
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                if($row['login'] == $_POST['login']){
                    $isFailde = false;
                    $isAdmin = $row['isadmin'];
                    $isLogin = true;
                    $user = $row;
                    break;
                }
            }
        }

    }
}

if(isset($_POST['Comment'])){
    $connect->query("INSERT INTO comments (userid, raiting, comment, gameid) VALUES(".$user['id'].", ".$_POST['raiting'].", '".$_POST['comment']."', ".$_POST['id'].")");
}

if(isset($_POST['Remove'])){
    $connect->query("DELETE FROM games WHERE id = ".$_POST['id']."; ");
    $connect->query("DELETE FROM screens WHERE gameid = ".$_POST['id']."; ");
    $connect->query("DELETE FROM comments WHERE gameid = ".$_POST['id']."; ");
}

if(isset($_POST['Change'])){
    $file = $_FILES['screens'];
    $filename = $_FILES["screens"]["name"];

    if(count($filename) > 0){
        $connect->query("DELETE FROM screens WHERE gameid = ".$_POST['id']." ");
        foreach($filename as $key=>$val){
            move_uploaded_file($_FILES["screens"]["tmp_name"][$key], __DIR__ . "/images/" . $_FILES["screens"]["name"][$key]);

            $contents = file_get_contents(__DIR__ . "/images/" . $_FILES["screens"]["name"][$key]);
            $base64   = base64_encode($contents);

            $connect->query("INSERT INTO screens (gameid, screen) VALUES (".$_POST['id'].", 'data: image/png; base64,".$base64."');");
        }
    }

    $connect->query("UPDATE games SET img ='".$_POST['img']."', price = ".$_POST['price'].", category = '".$_POST['category']."', name = '".$_POST['name']."' WHERE id = ".$_POST['id']."");
}

if(isset($_POST['Add'])){
    $file = $_FILES['img'];
    $filename = $_FILES["img"]["name"];

    move_uploaded_file($file['tmp_name'], __DIR__ . "/images/" . $filename);

    $contents = file_get_contents(__DIR__ . "/images/" . $filename);
    $img   = base64_encode($contents);


    $connect->query("INSERT INTO games (img, price, category, name) VALUES ('data: image/png; base64, ".$img."', ".$_POST['price'].", '".$_POST['category']."', '".$_POST['name']."');");
    
    $res = $connect->query("SELECT * FROM games where name = '".$_POST['name']."'");
    $row = $res->fetch_assoc();



    $file = $_FILES['screens'];
    $filename = $_FILES["screens"]["name"];
    foreach($filename as $key=>$val){
        move_uploaded_file($_FILES["screens"]["tmp_name"][$key], __DIR__ . "/images/" . $_FILES["screens"]["name"][$key]);

        $contents = file_get_contents(__DIR__ . "/images/" . $_FILES["screens"]["name"][$key]);
        $base64   = base64_encode($contents);

        $connect->query("INSERT INTO screens (gameid, screen) VALUES (".$row['id'].", 'data: image/png; base64,".$base64."');");
    }

}

?>

<script>

  function myFunction() {
    console.log(1);
    document.getElementById("myDropdown").classList.toggle("show");
    document.getElementById("myDropdown").onclick = onClick
    }

  function onClick(event) {
      console.log(2);
    if (!event.target.matches('.FilterButton')) {
      console.log(3);
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

<body style="background-color: #29295a; display: block;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="width: 100%; position: fixed; z-index: 1;">
  <div class="container-fluid">
    <form action="index.php" method = 'post'>
        <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>
      <button class="navbar-brand" name="Home" style="background: transparent; outline: none; border: 0;"><img src="https://img.icons8.com/fluency/48/null/ps-controller.png" width="50" height="45"></button>
    </form>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a onclick="myFunction()" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Genres
          </a>
          <?php include 'includes/categoryes.php'; ?>
        </li>
      </ul>

      <?php include 'includes/header.php'; ?>
    </div>
  </div>
</nav>

<div style="display: block; padding-top: 100px">
<?php
    
    if(isset($_GET['SingIn']) || isset($_GET['SingUp']) || isset($_POST['SingIn']) || isset($_POST['SingUp']) || isset($_POST['Basket']) || isset($_POST['Buy']) || isset($_GET['Add']) || isset($_GET['Change']) || isset($_GET['about']) || isset($_POST['Comment'])){
        if(isset($_POST['SingIn']) && !$isFailde){ include 'includes/main.php'; }
        if(isset($_POST['SingUp']) && !$isFailde){ include 'includes/main.php'; }

        if(isset($_GET['SingUp'])){
            include 'includes/SingUp.php';
        }

        if(isset($_POST['SingUp']) && $isFailde){
            include 'includes/SingUp.php';
        }

        if(isset($_GET['SingIn'])){
            include 'includes/SingIn.php';
        }

        if(isset($_POST['SingIn']) && $isFailde){
            include 'includes/SingIn.php';
        }

        if(isset($_POST['Basket'])){
            include 'includes/basket.php';
        }

        if(isset($_POST['Buy'])){
            echo '<h1 style="font-weight: bold; margin-left: 30px">Спасибо за покупку!</h1>';
        }

        if(isset($_GET['Add'])){
            include 'includes/add.php';
        }

        if(isset($_GET['Change'])){
            include 'includes/change.php';
        }

        if(isset($_GET['about']) || isset($_POST['Comment'])){
            include 'includes/about.php';
        }
    }
    else{
        include 'includes/main.php';
    }
?>
</div>

</body>
</html>