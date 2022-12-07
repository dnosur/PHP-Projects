<div style=" width: 30%;  margin-left: 30px; padding-top: 100px;">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <?php SaveUserInfo($user, $isLogin, $isAdmin); ?>

        <input type="text" id="firstName" name="name" class="form-control form-control-lg" required/>
        <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Product name</label>

        <div class="col-md-9 pe-5">
            <input class="form-control form-control-lg" id="formFileLg" name="img" type="file" />
            <div class="small text-muted mt-2">Upload game avatar.</div>
        </div>

        <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Avatar</label>

        <div class="form-outline datepicker w-100" style="font-weight: bold;">
            <input type="file" name="screens[]" style="color: rgb(194, 44, 161);" multiple>
        </div>
        <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Screens</label>

        <select class="form-select" aria-label="Default select example" name="category" style="font-weight: bold; " required>
            <?php
            $res = $connect->query("SELECT * FROM categoryes;");
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    if($row['category'] != 'All'){
                        echo '<option value="'.$row['category'].'">'.$row['category'].'</option>';
                    }
                }
            }
            ?>
        </select>

        <div class="form-outline" style="margin-top: 10px;">
            <input type="number" min="1" name="price" class="form-control form-control-lg" step="0.01" required/>
            <label class="form-label" for="firstName" style="font-weight: bold; color: rgb(194, 44, 161);">Price</label>
        </div>

        <button class="btn btn-outline-success" type="submit" name="Add" style="background-color: green; color: white;">Add</button>
    </form>
</div>