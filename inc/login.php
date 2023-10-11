
    <?php require_once "inc/messages.php"; ?>
    <!-- </div>  -->

    <div class="row">
      <div class="col-md-6">
        <div class="mycontent-left" style="border-right: 1px solid #333;">
          <section class="login_content">
            <form action="?page=home" method="POST">
              <h3>Login Form</h3>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</button>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>
                <input type="hidden" name="action" value="login"> 
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

              </div>
            </form>
          </section>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mycontent-right">
          <section class="login_content">
            <form action="?page=home" method="POST">
              <h3>Create Account</h3>
              <div>
                <input type="email" name="username" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Submit</button>
              </div>

              <div class="clearfix"></div>
                <input type="hidden" name="action" value="signup"> 

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

              </div>
            </form>
          </section>
        </div>
      </div>
    </div>

