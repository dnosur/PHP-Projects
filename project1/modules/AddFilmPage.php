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

<link rel="stylesheet" href="../css/DropdownMenu.css">
<link rel="stylesheet" href="../css/FilmsBlock.css">

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

<body style="background-color: #1b1b35; ">
    <div style="border: 2px solid black; height: 100%; margin-left: 0%; background-color: #1A1D33; position: fixed; padding-top: 20px; top: 0; left: 0; flex-wrap: wrap; display: block;">
        <nav>
            <form class="form-inline" method="post" action="Search" style="padding: 10%;">
              <input class="form-control mr-sm-2" type="search" name = "Search" placeholder="Search" aria-label="Search">
              <div style="margin-top: 10%;"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> </div> 
            </form>
        </nav>

        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
          <form action="/">
            <button class="dropbtn" style="background-color: green;">Home</button>
          </form>
        </div>

        <div class="dropdown" style="margin-top: 50px;">
          <button onclick="myFunction()" class="dropbtn">Категории</button>
          <div id="myDropdown" class="dropdown-content">
            <?php include 'categoryes.php';?>
          </div>
        </div>

        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
      <form action="AddFilmPage.php">
        <button class="dropbtn" style="background-color: red;">Add</button>
      </form>
    </div>
    </div>
    

    <div style="display: flex; flex-wrap: wrap;">
    <div style="display: block; flex-wrap: wrap;">

    <form method="post" action="../index.php" enctype="multipart/form-data"> 
    <!-- Панель заголовка -->

    <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
        <input type="text" name="name" placeholder="film name" oninput="OnNameInput(this)">
    </div>

    <div style="margin-left: 300px;"> <input type="file" name="file"> </div>

    <!-- Оценка -->
    <div style="margin-left: 300px; display: inline-flex; flex-wrap: wrap;">
        <input type="number" name="raiting" min="1" max="5" placeholder="Оценка" oninput="OnRaitingInput(this)">
    </div>

    <!-- Описание -->
    <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
        <h2 style="color: #D2D3FA;"> Жанр: </h2>

        <select name="genre" onchange="OnGanreSelect(this)">
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
                            echo '<option value = "' . $row['category'] . '">' . $row['category'] . '</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
    <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
        <h1 style="color: #D2D3FA;"> Описание: </h1>
        <textarea name="about" placeholder="Описание" style="width: 550px;" oninput="OnAboutInput(this)">  </textarea>
    </div>

    <button style="margin-left: 300px; display: none;" type="submit" id="AddFilmButton" name="AddFilmButton">Save</button>

    </form>
    </div>
    </div>
</body>

<script>
    var nameValid = false
    var raitingvalid = false
    var ganrevalid = false
    var about = false

    function OnNameInput(item){
        if(item.value.length > 0 && item.value.length < 30){
            item.style.color = "black"
            nameValid = true
        }
        else{
            item.style.color = "red"
            nameValid = false
        }
        IsValid()
    }

    function OnRaitingInput(item){
        console.log(parseInt(item.value))
        if(parseInt(item.value) >= 1 && parseInt(item.value) <= 5){
            item.style.color = "black"
            raitingvalid = true
        }
        else{
            item.style.color = "red"
            raitingvalid = false
        }
        IsValid()
    }

    function OnGanreSelect(item){
        if(item.value != "All"){
            item.style.color = "black"
            ganrevalid = true
        }
        else{
            item.style.color = "red"
            ganrevalid = false
        }

        IsValid()
    }

    function OnAboutInput(item){
        if(item.value.length > 0){
            item.style.color = "black"
            about = true
        }
        else{
            item.style.color = "red"
            about = false
        }
        IsValid()
    }

    function IsValid(){
        if(nameValid && raitingvalid && ganrevalid && about){
            document.getElementById("AddFilmButton").style.display = "block"
        }
        else{
            document.getElementById("AddFilmButton").style.display = "none"
        }
    }
</script>
</html>