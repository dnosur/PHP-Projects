<?php

$res = $connect->query("SELECT * FROM cars WHERE id = ".$_GET['id']." ");
$car = $res->fetch_assoc();

?>

<div style="display: block; width: 30%; margin-left: 30px; padding-top: 0px;">
    <form action="index.php" method="post" enctype="multipart/form-data">

        <?php 
        SaveUserInfo($user, $isLogin, $isAdmin);
        echo    '<input type="hidden" name="id" value="'.$car['id'].'">
                <div class="form-outline">
                    <input type="text" id="firstName" name="name" value="'.$car['name'].'" class="form-control form-control-lg" required/>
                    <label class="form-label" for="firstName" style="font-weight: bold; ">Product name</label>
                </div>

                <div class="form-outline">
                    <img src="'.$car['img'].'" width="1030" height="450">
                    <input type="text" id="firstName" name="img" value="'.$car['img'].'" class="form-control form-control-lg" style="margin-top: 30px;"/>
                    <label class="form-label" for="firstName" style="font-weight: bold; ">Product image src</label>
                </div>';
        ?>

        <select class="form-select" aria-label="Default select example" name="category" style="font-weight: bold;" required>
        <?php
            $res = $connect->query("SELECT * FROM category;");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    if($row['category'] != 'All'){
                        if($row['category'] == $car['category']){
                            echo '<option  value="'.$row['category'].'" selected>'.$row['category'].'</option>';
                        }
                        else{
                            echo '<option  value="'.$row['category'].'">'.$row['category'].'</option>';
                        }
                    }
                }
            }
        ?>
        </select>

        <?php
        echo '<div class="form-outline" style="margin-top: 10px;">
                <textarea name="about" style="width: 100%;">'.$car['about'].'</textarea>
                <label class="form-label" for="about" style="font-weight: bold; " >About</label>
            </div>'
        ?>

        <div class="form-outline" style="margin-top: 10px;">
            <?php
            echo '<input type="number" min="1000" name="price" value="'.$car['price'].'" class="form-control form-control-lg" step="0.01" required/>' ;
            ?>
            <label class="form-label" for="firstName" style="font-weight: bold; ">Price</label>
        </div>

        <button class="btn btn-outline-success" type="submit" name="Change" style="background-color: green; color: white;">Change</button>
    </form>
</div>