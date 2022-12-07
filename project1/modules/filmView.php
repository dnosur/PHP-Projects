
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


        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
          <form action="/">
            <input type="hidden" name="isAdmin" value= <?php echo $isAdmin ?>>
            <button class="dropbtn" style="background-color: green;">Home</button>
          </form>
        </div>

        <?php 
            if($_POST['isAdmin']){
        ?>

        <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">
            <form action="AddFilmPage.php">
            <button class="dropbtn" style="background-color: red;">Add</button>
        </form>

        <?php 
            }
        ?>
    </div>
    </div>

    <div style="display: flex; flex-wrap: wrap;">
        <div style="display: flexbox; flex-wrap: wrap;">

            <?php if(!$_POST['isAdmin']){ ?>
            <!-- Панель заголовка -->

            <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                <h1 style="color: #D2D3FA;"> <?php echo $_POST['filmName'] ?> </h1>
                <h1 >
                    <img src = "<?php echo $_POST['img'] ?>" style="width: 300px; height: 400px; margin-top: 10px;">
                </h1>
            </div>

            <!-- Оценка -->
            <div style="margin-left: 300px; display: inline-flex; flex-wrap: wrap;">
                <h1 style = "color: #E5C8FA"> <?php echo $_POST['raiting'] ?>/5 </h1>
            </div>

            <!-- Описание -->
            <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                <h2 style="color: #D2D3FA;"> Жанр: <?php echo $_POST['category'] ?> </h2>
            </div>
            <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                <h1 style="color: #D2D3FA;"> Описание: </h1>
                <p style="color: #D2D3FA; width: 90%;"> <?php echo $_POST['about'] ?> </p>
            </div>

            <?php } else { ?>

                <form method = "post" action ="../index.php" enctype="multipart/form-data">
                
                <input type="hidden" name = "oldFilmName" value = <?php echo $_POST['filmName'] ?>>

                <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                <input type="text" name = "name" value = <?php echo $_POST['filmName'] ?> oninput = "OnNameInput(this)">
                <h1 >
                    <input type="file" name="file" style="width: 300px; height: 400px; margin-top: 10px;">
                </h1>
                </div>

                <!-- Оценка -->
                <div style="margin-left: 300px; display: inline-flex; flex-wrap: wrap;">
                    <input type="number" name = 'raiting' value = <?php echo $_POST['raiting'] ?> max = '5' min = '1' oninput = "OnRaitingInput(this)">
                </div>

                <!-- Описание -->
                <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                    <h2 style="color: #D2D3FA;"> Жанр: <?php echo $_POST['category'] ?> </h2>
                    <select name="genre" onchange="">
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
                                    if($row['category'] == $_POST['category']){
                                        echo '<option value = "' . $row['category'] . '" selected>' . $row['category'] . '</option>';
                                    }
                                    else{
                                        echo '<option value = "' . $row['category'] . '" >' . $row['category'] . '</option>';
                                    }
                                }
                            }
                        }          
                    ?>
                    </select>
                </div>
                <div style="margin-left: 300px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">
                    <h1 style="color: #D2D3FA;"> Описание: </h1>
                    <textarea name="about" placeholder="Описание" style="width: 550px;" oninput="OnAboutInput(this)"> <?php echo $_POST['about'] ?> </textarea>
                </div>
                <button style="margin-left: 300px; display: block;" type="submit" id="ChangeFilm" name="ChangeFilmButton">Save</button>
                </form>
            <?php } ?>
        </div>
    </div>

    <script>
        var nameValid = true
        var raitingvalid = true

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

        function IsValid(){
        if(nameValid && raitingvalid){
            document.getElementById("ChangeFilm").style.display = "block"
        }
        else{
            document.getElementById("ChangeFilm").style.display = "none"
        }
        }

    </script>

</body>
</html>