<form class="d-flex" action="index.php" method="post" style="margin-right: 25px; margin-left: 61%;">
    <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>
    <input class="form-control me-2" type="search" name="Search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" name='SearchButton' type="submit">Search</button>
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
    <button class="btn btn-outline-success" type="submit" name='Exit' style="background-color: rgb(255, 0, 0); color: white; border: none">Exit</button>
</form>
<?php 
}
?>