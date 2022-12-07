
<?php

$id = null;

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$res = $connect->query('SELECT * FROM games WHERE id = '.$id.'');
$game = $res->fetch_assoc();

$raiting = 0;
$comments = $connect->query("SELECT * FROM comments where gameid = ".$id."");

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

<div style="display: block; width: 30%; margin-top: 30px; margin-left: 80px; padding: 10px;">

    <?php
        echo '<input type="hidden" name="id" value="'.$game['name'].'">

            <div class="form-outline">
                <img src="'.$game['img'].'" width="400" height="400" style="border: 2px solid black;">
            </div>';

        if($raiting > 0){
            echo '<div style="display: inline-flex; font-weight: bold; margin-top: 10px;">';
            echo '<h1 style="color: rgb(159, 161, 9);">Raiting: </h1>';
            if($raiting < 5){
                echo '<h1 style="color: red; margin-left: 10px; font-weight: bold;">'.$raiting.'</h1>';
            }
            else if($raiting >= 5 && $raiting < 8){
                echo '<h1 style="color: orange; margin-left: 10px; font-weight: bold;">'.$raiting.'</h1>';
            }
            else if($raiting >= 8){
                echo '<h1 style="color: green; margin-left: 10px; font-weight: bold;">'.$raiting.'</h1>';
            }
            echo '</div>';
        }

        echo '<h1 style="color: rgb(255, 6, 160); font-weight: bold; margin-top: 10px;">Category: '.$game['category'].'</h1>
              <h1 style="color: rgb(6, 255, 68); font-weight: bold; margin-top: 10px;">Price: '.$game['price'].'</h1>';

        $screens = $connect->query("SELECT * FROM screens WHERE gameid = ".$id." ");
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

        $haveUserComment = false;

        $comments = $connect->query("SELECT * FROM comments where gameid = ".$id."");
        if($comments->num_rows > 0){
            echo '<h1 style="font-weight: bold; margin-left: 30px; margin-top: 10px; color: #5557d8;">Comments: </h1>
                  <div style="margin-left: 100px; padding-top: 25px; padding-bottom: 15px; display: flexbox; flex-wrap: wrap;">';

            while($comment = $comments->fetch_assoc()){

                if($comment['userid'] == $user['id']) { $haveUserComment = true; }

                $users = $connect->query('SELECT * FROM users WHERE id = '.$comment['userid'].';');

                if($users->num_rows > 0){
                    $_user = $users->fetch_assoc();

                    echo '<h2 style="color: rgb(72, 188, 218);"><img src= "'.$_user['img'].'" width="50" height="50" style="border-radius: 50%; "> '.$_user['login'].' '.$comment['raiting'].'/10 </h2>
                      <p style="margin-left: 40px; width: 80%; color: aquamarine; border: 1px solid black;"> '.$comment['comment'].' </p>';
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
