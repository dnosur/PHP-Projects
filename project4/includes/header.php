<form class="d-flex" action="index.php" method="post" style="margin-right: 25px; margin-left: 65%;">
    <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>
    <div class="input-group" style="margin-left: 10px; display: inline-flex;">
          <div class="form-outline">
            <input type="search" id="form1" name="Search" placeholder="Search" class="form-control" />
          </div>
          <button type="submit" name = "SearchButton" class="btn btn-primary">
            <img src="https://img.icons8.com/color/48/null/search-more.png" height="20px" width="30px"/>
          </button>
    </div>
</form>

<?php 

if(!$isLogin)
{
?>
<form class="d-flex" action="index.php" method="get" style="margin-right: 10px;">
    <button class="btn btn-outline-success" name="SingIn" type="submit" style="background-color: green; color: white;">Sing In</button>
</form>
<form class="d-flex" action="index.php" method = 'get'>
    <button class="btn btn-outline-success" type="submit" name='SingUp' style="background-color: black; color: white; border: none">Sing Up</button>
</form>
<?php 
} else {
    echo '<img src = "'.$user['img'].'" width="40" height="30" style="border-radius: 50%; margin-right: 10px;">';
?>
<form class="d-flex" action="index.php" method = 'post'>
    <button class="btn btn-outline-success" type="submit" name='Exit' style="border: none"><img src="https://img.icons8.com/fluency/48/null/exit.png"/></button>
</form>
<?php 
}
?>