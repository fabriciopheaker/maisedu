<div class="row">
    <div class='col'>
    <div class="card card-navy">
              <div class="card-header">
                <h3 class="card-title"><?php echo $card_title;?></h3>
              </div>
              <form action="<?php echo core\Action::get('Grupos','save')->getUrl();?>" method="POST">
                <div class="card-body row">
                  <div class="form-group col">
                    <label for="nome">Nome</label>
                    <input type="text" name="descricao" class="form-control" id="nome" value="<?php $echo('descricao',"");?>" placeholder="Nome do novo grupo" required>
                  </div>
                  <div class="form-group col-12 viewbox">                    
                      <?php $inputs_modulos->show();?>
                  </div>                     
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" <?echo \core\Action::get('Grupos')->onclick(); ?> class="btn  bg-warning float-left mr-3"> <i class="fas fa-list mr-1"></i> Listar Grupos</button>
                    <?php $component('Button',[\core\Action::get('Grupos','edit'),'fas fa-plus-circle','Novo Grupo','btn-success float-left'])->show();?>
                    <button type="submit" class="btn btn-primary bg-navy float-right ml-3"> <i class="fas fa-save fa-regular mr-1"></i> Salvar</button>
                    <?php if(isset($cod_grupo)){
                        $component('ButtonConfirmationModal',[
                                    \core\Action::get('Grupos','delete',['cod_grupo'=>$cod_grupo]),
                                    'fas fa-trash',
                                    'Excluir',
                                    'btn btn-danger float-right',
                                    "Confirma a exclusão?",
                                    'Você confirma a exclusão permanente do registro no banco de dados.',
                                    'Excluir',
                                    \components\ButtonConfirmationModal::DANGER])->show();
                      ?>
                    <input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo;?>"/>
                    
                    <?php }?>
                </div>
              </form>
            </div>
    </div>
</div>

