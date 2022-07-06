<main class="conteudo">
        <hr>
        <h1 class="mt20">Scavone Senhas</h1>
        <h3>  <i class="  fa fa-key"></i> Dados de autenticação: </h3>
        <form method="POST" action="Autenticar.php?metodo=logar">
            <fieldset class="mp10">
                <legend>Entrar:</legend>
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" placeholder="Seu nome" required="">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" placeholder="Sua senha" required=""> 
                    </div>
                    <div class="form-group">
                        <label for="guiche">Guiche:</label>
                        <input type="number" id="guiche" name="guiche" min="1" step="1" placeholder="Seu guiche" required="">
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo de Atendimento:</label>
                        <select name="tipo" id="">
                            <option value="">Todos os tipos</option>
                            <option value="P">Prioritariamente: Preferencial </option><option value="N">Prioritariamente: Normal </option><option value="L">Prioritariamente: Laboratório </option>                            </select>
                    <div class="form-group">
                        <input type="submit" value="Entrar"> 
                    </div>
            </div></fieldset>
        </form>
</main>   