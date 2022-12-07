<link rel="stylesheet" href="../css/FilmsBlock.css">

<div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px;">
    <?php
        if(isset($_POST['category'])){
            echo '<h1 style="color: #D2D3FA;"> ' . $_POST['category'] . '</h1>';
        }
        else{
            echo '<h1 style="color: #D2D3FA;"> Все </h1>';
        }
    ?>
</div>

<div class="filmsblock">

<?php

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
    
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
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

?>

</div>