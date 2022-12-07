
<div style="width: 100%; height: 100%; background: linear-gradient(to bottom right, rgb(113, 129, 173), rgb(71, 92, 209))">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100" style="margin-top: -100px;">
          <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
              <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                  <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">SingUp</h3>
                  <form action="index.php" method="post" enctype="multipart/form-data">

                    <div class="form-outline">
                        <input type="text" id="firstName" name="login" class="form-control form-control-lg" required/>
                        <label class="form-label" for="firstName">Login</label>
                    </div>

                    <div class="form-outline datepicker w-100">
                        <input type="password" name="password" class="form-control form-control-lg" id="birthdayDate" required/>
                        <label for="birthdayDate" class="form-label">Password</label>
                    </div>

                    <div class="col-md-9 pe-5">
                        <input class="form-control form-control-lg" id="formFileLg" name="img" type="file" />
                        <div class="small text-muted mt-2">Upload your avatar. Max file
                        size 50 MB</div>
                    </div>

                    <?php if($isFailde){ ?>
                        <p class="small mb-5 pb-lg-2" style="color: red;">A user with this name exists!</p>
                    <?php } ?>
      
                    <div class="mt-4 pt-2">
                      <input class="btn btn-primary btn-lg" type="submit" name="SingUp" value="SingUp" />
                    </div>
      
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>