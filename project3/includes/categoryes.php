<div id="myDropdown" class="dropdown-content" aria-labelledby="navbarDropdown">
    <?php
        $res = $connect->query("SELECT * FROM categoryes");

        if($res->num_rows > 0){
            while($c = $res->fetch_assoc()){
                echo '<form action="index.php" method="post">
                        <input type="hidden" name="Category" value="'.$c['category'].'">';
                        SaveUserInfo($user, $isLogin, $isAdmin);
                if($c['iscurrent']){
                    echo '<button name="Sort" style="background: green; outline: none; border: 0;">'.$c['category'].'</button>';
                }
                else{
                    echo '<button name="Sort" style=" outline: none; border: 0;">'.$c['category'].'</button>';
                }
                echo '</form>';
            }
        }
    ?>
</div>