
<?php

$id = null;

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$res = $connect->query('SELECT * FROM cars WHERE id = '.$id.'');
$game = $res->fetch_assoc();

$raiting = 0;
$comments = $connect->query("SELECT * FROM comments where carid = ".$id."");

if($comments->num_rows > 0){
    while($row = $comments->fetch_assoc()){
        $raiting += $row['raiting'];
    }

    $raiting /= $comments->num_rows;
}

?>

<div style="display: inline-flex; flex-wrap: wrap; margin-left: 30px; margin-top: 10px; padding: 10px;">
    <h1 style="font-weight: bold; color: rgb(0, 0, 0);"><?php echo $game['name'] ?></h1>
</div>

<div style="display: block; width: 40%; margin-top: 30px; margin-left: 80px; padding: 10px;">

    <?php
        echo '<input type="hidden" name="id" value="'.$game['id'].'">

            <div class="form-outline">
                <img src="'.$game['img'].'" width="1200" height="600" style="margin-left: 40px;">
            </div>';

        echo '<h1 style="font-weight: bold; margin-top: 10px;">'.$game['category'].' car</h1>
              <h1>'.$game['about'].'</h1>
              <hr>
              <h1 style="font-weight: bold; margin-top: 10px;">Start with '.$game['price'].'K</h1>';

        if($raiting > 0){
            echo '<h1 style=" font-weight: bold;">Average raiting '.$raiting.'</h1>';
        }

        $haveUserComment = false;

        $comments = $connect->query("SELECT * FROM comments where carid = ".$id."");
        if($comments->num_rows > 0){
            echo '<hr><h1 style="font-weight: bold; margin-left: 30px; margin-top: 10px; ">Comments: </h1>
                  <div style="margin-left: 100px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">';

            while($comment = $comments->fetch_assoc()){

                if($comment['userid'] == $user['id']) { $haveUserComment = true; }

                $users = $connect->query('SELECT * FROM users WHERE id = '.$comment['userid'].';');

                if($users->num_rows > 0){
                    $_user = $users->fetch_assoc();
                    
                    if($isLogin && $user['name'] == $_user['name']){
                        echo '<h2><img src= "'.$_user['img'].'" width="50" height="50" style="border-radius: 50%; "> You '.$comment['raiting'].'/10 </h2>
                              <p style="margin-left: 40px; width: 80%; border: 1px solid black;"> '.$comment['comment'].' </p>';
                    }
                    else{
                        echo '<h2><img src= "'.$_user['img'].'" width="50" height="50" style="border-radius: 50%; "> '.$_user['login'].' '.$comment['raiting'].'/10 </h2>
                              <p style="margin-left: 40px; width: 80%; border: 1px solid black;"> '.$comment['comment'].' </p>';
                    }
                }
            }
            
            echo '</div>';
        }
        
        if(!$haveUserComment && $isLogin){
            echo '<h2 style="color: #D2D3FA;"> Your comment: </h2>
                  <form action="index.php" method="post" >';
            SaveUserInfo($user, $isLogin, $isAdmin);

            echo  '<input type="hidden" name="id" value="'.$game['id'].'">
                    <div><input type="number" max="10" min="1" placeholder="Raiting" name="raiting"></div>
                    <div><textarea name="comment" placeholder="Input your comment here" style="width: 550px;" rows="4"></textarea></div>
                    <button class="btn btn-outline-success" type="submit" name = "Comment" style="background-color: green; color: white;">Comment</button>
                  </form>';
        }
    ?>
</div>
