
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
        $res = $connect->query("SELECT * FROM games");

        if($res->num_rows > 0){

            while($game = $res->fetch_assoc()){
                if($category == 'All' || $category == $game['category']){

                    if(isset($_POST['SearchButton'])){
                        if($_POST['Search'] != $game['name']){
                            continue;
                        }
                    }
                    
                    echo '<div style="display: flex; flex-wrap: wrap; width: 400px;  margin-left: 20px; margin-top: 20px;">';

                    if($isAdmin){
                        echo '<form action="index.php" method="post">';
                        SaveUserInfo($user, $isLogin, $isAdmin);

                        echo '<input type="hidden" name="id"  value="'.$game['id'].'">
                                <button name = "Remove" style="border-radius: 50%; background: transparent; outline: none; border: 0;">
                                    <img src="https://img.icons8.com/arcade/64/null/delete.png" width="80" height="60" >
                                </button>
                            </form>';

                        SaveUserInfo($user, $isLogin, $isAdmin);
                        echo '<form action="index.php" method="get" >
                                <input type="hidden" name="id"  value="'.$game['id'].'">';
                        SaveUserInfo($user, $isLogin, $isAdmin);
                        echo '<button name="Change" style="border-radius: 50%; background: transparent; outline: none; border: 0; margin-left: 180px;">
                                    <img src="https://img.icons8.com/arcade/64/null/automatic.png" width="80" height="60" >
                                </button>
                            </form>';
                    }

                    echo '<form action="index.php" method="get">';
                    SaveUserInfo($user, $isLogin, $isAdmin);

                    echo '<input type="hidden" name="id" value="'.$game['id'].'">
                            <button name="about" style="background: transparent; outline: none; border: 0;"><img class="GameImg" src="'.$game['img'].'" width="330" height="450"></button>
                        </form>
                        <div style="display: inline-flex; flex-wrap: wrap; margin-left: -30px;">
                            <h2 style="margin-left: 150px; padding: 10px; color: green; font-weight: bold;">'.$game['price'].'$</h2>
                        </div>';
                    echo '</div>';
                }
            }
        }
    ?>
</div>
