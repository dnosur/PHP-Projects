<div style=" width: 30%;  margin-left: 30px; padding-top: 100px;">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>

        <input type="text" id="carName" name="name" class="form-control form-control-lg" required/>
        <label class="form-label" for="carName" style="font-weight: bold; ">Car name</label>

        <input type="text" id="carAvatar" name="img" class="form-control form-control-lg" required/>
        <label class="form-label" for="carAvatar" style="font-weight: bold; ">Car img src</label>

        <select class="form-select" id="carType" aria-label="Default select example" name="category" style="font-weight: bold; " required>
            <?php
            $res = $connect->query("SELECT * FROM category;");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    if($row['category'] != 'All'){
                        echo '<option value="'.$row['category'].'">'.$row['category'].'</option>';
                    }
                }
            }
            ?>
        </select>
        <label class="form-label" for="carType" style="font-weight: bold; ">Car Type</label>

        <div class="form-outline" style="margin-top: 10px;">
            <textarea name="about" id="about" style="width: 100%;"></textarea>
            <label class="form-label" for="about" style="font-weight: bold; ">About</label>
        </div>

        <div class="form-outline" style="margin-top: 10px;">
            <input type="number" min="1000" id = "carPrice" name="price" class="form-control form-control-lg" step="0.01" required/>
            <label class="form-label" for="carPrice" style="font-weight: bold; ">Price</label>
        </div>

        <button class="btn btn-outline-success" type="submit" name="Add" style="border: none">
            <img src="gifs/car.gif" width="60" height="60">
        </button>
    </form>
</div>