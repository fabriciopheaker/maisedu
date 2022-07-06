<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-navy">
    <div class="card-header text-center">
      <img src="<?php echo URL?>/assets/images/logopreto.png"/>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Cadastro de novo usuário</p>
      <?php \components\Alert::getFlashMessage();?>
        
      <form action="<?php echo \core\Action::get('Cadastrar','cadastrar')->getUrl();?>" method="post">
      <div class="input-group mb-3">
          <input type="text" name="nome" class="form-control" placeholder="Nome" title="Digite seu nome completo" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="E-mail" title="Digite seu e-mail institucional" required/>
          <select name="grupo">
            <option value="Alunos">@estudante.ifto.edu.br</option>
            <option value="Servidores">@ifto.edu.br</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-at"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Senha" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="confirme_password" class="form-control" placeholder="Confirme sua senha" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-check"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" required>
              <label for="remember">
                Aceito os <a href="<?php echo \core\Action::get('TermosServico')->getUrl();?>">termos de serviço</a>
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-6 offset-6 mt-4">
            <button type="submit" class="btn btn-primary btn-block bg-navy">Casdastrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
      <!-- /.social-auth-links -->
     <div class="row mt-4">
      <p class="col">
        <a href="<?php echo \core\Action::get('Login')->getUrl();?>" title="Voltar para a tela de login">Login</a>
      </p>
      <p class="col right">
        <a href="<?php echo \core\Action::get('Login','resetPassword')->getUrl();?>" title="Clique para redefinir sua senha">Esqueci minha senha</a>
      </p>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
