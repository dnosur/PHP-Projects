<?php

$res = $connect->query("SELECT * FROM games WHERE id = ".$_GET['id']." ");
$game = $res->fetch_assoc();

?>

<div style="display: block; width: 30%; margin-left: 30px; padding-top: 160px;">
    <form action="index.php" method="post" enctype="multipart/form-data">

        <?php 
        SaveUserInfo($user, $isLogin, $isAdmin);
        echo    '<input type="hidden" name="id" value="'.$game['id'].'">
                <div class="form-outline">
                    <input type="text" id="firstName" name="name" value="'.$game['name'].'" class="form-control form-control-lg" required/>
                    <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Product name</label>
                </div>

                <div class="form-outline">
                    <img src="'.$game['img'].'" width="100" height="80">
                    <input type="text" id="firstName" name="img" value="'.$game['img'].'" class="form-control form-control-lg" style="margin-top: 30px;"/>
                    <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Product image src</label>
                </div>';
        ?>

        <select class="form-select" aria-label="Default select example" name="category" style="font-weight: bold;" required>
        <?php
            $res = $connect->query("SELECT * FROM categoryes;");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    if($row['category'] != 'All'){
                        if($row['category'] == $product['category']){
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
        $screens = $connect->query("SELECT * FROM screens WHERE gameid = ".$_GET['id']." ");

        if($screens->num_rows > 0){
            echo '<div style="overflow-x:scroll; white-space: nowrap; width: 700px; margin-top: 10px;" class="col-md-12">
                    <span ng-repeat="item in images" >';
            while($screen = $screens->fetch_assoc()){
                echo '<a ng-href="'.$screen['screen'].'" target="_blank">
                        <img width="700" height="500" src="'.$screen['screen'].'">
                    </a>';
            }
            echo '</span>
            </div>';
        }
        ?>
        
        <div class="form-outline">
            <input type="file" name="screens[]" multiple style="margin-top: 30px; color: rgb(194, 44, 161);"/>
        </div>

        <div class="form-outline" style="margin-top: 10px;">
            <?php
            echo '<input type="number" min="1" name="price" value="'.$game['price'].'" class="form-control form-control-lg" step="0.01" required/>' ;
            ?>
            <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Price</label>
        </div>

        <button class="btn btn-outline-success" type="submit" name="Change" style="background-color: green; color: white;">Change</button>
    </form>
</div>