<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-navy">
    <div class="card-header text-center">
      <img src="<?php echo URL?>/assets/images/logopreto.png"/>
    </div>
    <div class="card-body">
      <?php \components\Alert::getFlashMessage();?>
      <p class="login-box-msg">Entre com seu e-mail institucional</p>

      <form action="<?php echo \core\Action::get('Login','logar')->getUrl();?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="login"<?php $value('login');?> class="form-control" placeholder="E-mail">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Lembre-me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block bg-navy">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
      <!-- /.social-auth-links -->
     <div class="row mt-4">
      <p class="col">
        <a href="<?php echo \core\Action::get('Login','resetPassword')->getUrl();?>">Esqueci minha senha</a>
      </p>
      <?php echo $register?>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
