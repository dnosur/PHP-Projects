
<div style="display: block; flex-wrap: wrap; margin-left: 30px; margin-top: 10px; padding: 10px;">
    <h1 style="font-weight: bold; color: rgb(0, 0, 0);"><?php echo $category; ?></h1>
</div>


<?php if($isAdmin){ ?>
<div>
    <form action="index.php" method="get">
        <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>
        <button class="AddButton" name="Add" style="background: transparent; outline: none; border: 0;">
            <img src="https://img.icons8.com/nolan/64/add.png"/>
        </button>
    </form>
</div>
<?php } ?>

<div style="display: inline-flex; flex-wrap: wrap; margin-left: 100px; ">

    <?php
        $res = $connect->query("SELECT * FROM cars");

        if($res->num_rows > 0){

            while($car = $res->fetch_assoc()){
                if($category == 'All' || $category == $car['category']){

                    if(isset($_POST['SearchButton'])){
                        if($_POST['Search'] != $car['name']){
                            continue;
                        }
                    }
                    
                    echo '<div style="display: flex; flex-wrap: wrap;  margin-left: 20px; margin-top: 20px;">';

                    echo '<form action="index.php" method="get">';
                    SaveUserInfo($user, $isLogin, $isAdmin);

                    echo '<input type="hidden" name="id" value="'.$car['id'].'">
                            <button style="background: transparent; outline: none; border: 0;" name = "about"><img class="CarImg" src="'.$car['img'].'" width="1030" height="450"></button>
                        </form>';

                    echo '<div style="display: flexbox; flex-wrap: wrap; margin-left: 100px; margin-top: 30px;">
                            <h1 style=" padding: 10px; font-weight: bold;">'.$car['name'].'</h1>
                            <h2 style=" padding: 10px; width: 400px; ">'.$car['about'].'</h2>
                            <hr style="height: 10px;">
                            <h2 style="padding: 10px; color: rgb(33, 77, 33); font-weight: bold;">'.$car['price'].'K</h2>';

                    if($isAdmin){
                        echo '<form action="index.php" method="post">';
                        SaveUserInfo($user, $isLogin, $isAdmin);

                        echo '<input type="hidden" name="id"  value="'.$car['id'].'">
                                <button name = "Remove" style="border-radius: 50%; background: transparent; outline: none; border: 0;">
                                    <img src="https://img.icons8.com/color/48/null/delete-forever.png" width="80" height="60" >
                                </button>
                            </form>';

                        SaveUserInfo($user, $isLogin, $isAdmin);
                        echo '<form action="index.php" method="get" style="margin-top: -55px;">
                                <input type="hidden" name="id"  value="'.$car['id'].'">';
                        SaveUserInfo($user, $isLogin, $isAdmin);
                        echo '<button name="Change" style="border-radius: 50%; background: transparent; outline: none; border: 0; margin-left: 180px;">
                                    <img src="https://img.icons8.com/external-others-inmotus-design/67/null/external-Change-virtual-keyboard-others-inmotus-design.png" width="80" height="60" >
                                </button>
                            </form>';
                    }

                    echo '</div></div>';
                }
            }
        }
    ?>
</div>
