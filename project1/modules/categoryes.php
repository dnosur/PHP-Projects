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
    $res = $connect->query("SELECT * FROM categoryes");
    
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            echo '<form action = "index.php" method = "post">';
            echo '<input type="hidden" name="genre" value = "' . $row['category'] . '" >';
            echo '<input type="hidden" name="category" value = "' . $row['name'] . '">';
            echo '<input type="hidden" name="isAdmin" value="'. $isAdmin .'">';

            if($row['iscurrent']){
                echo '<button style="background-color: green;" name = "GenreButton"> ' . $row['name'] . ' </button>';
            }
            else{
                echo '<button name = "GenreButton"> '. $row['name'] .' </button>';
            }

            echo '</form>';
        }
    }
}

?>