<div class="row">
    <div class='col'>
    <div class="card card-navy">
              <div class="card-header">
                <h3 class="card-title"><?php echo $card_title;?></h3>
              </div>
              <form action="<?php echo core\Action::get('Modulos','save')->getUrl();?>" method="POST">
                <div class="card-body row">
                  <div class="form-group col-sm-5 col-md-4">
                    <label for="menu">Módulo</label>
                    <input type="text" name="menu" class="form-control" id="menu" value="<?php $echo('menu',"");?>" placeholder="Nome do Módulo" required>
                  </div>
                  <div class="form-group col-sm-5">
                    <label for="menu">Menu Pai</label>
                    <? $menu_pai->show();?>
                  </div>
                  <div class="form-group col-sm-2 col-md-3">
                    <label for="ordem">Ordem</label>
                    <input type="number" name="ordem" class="form-control" id="ordem" value="<?$echo('ordem');?>" placeholder="Ordem do módulo no menu" title="Ordem do módulo no menu"  min="1" max="999"/>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao"><?$echo('descricao',"");?></textarea>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="descricao">Configurações:</label>
                    <div class="custom-control custom-switch custom-switch-on-navy">
                      
                      <input type="checkbox" name="manutencao" <?php if($get('manutencao',0)!=0) echo 'checked';?> class="custom-control-input" id="manutencao">
                      <label class="custom-control-label" for="manutencao">Módulo em Manutenção</label>
                    </div>
                    <div class="custom-control custom-switch custom-switch-on-navy mt-3">
                      <input type="checkbox" name="exclusivoadmin"<?php if($get('exclusivoadmin',0)!=0) echo 'checked';?> class="custom-control-input" id="exclusivoadmin">
                      <label class="custom-control-label" for="exclusivoadmin">Exclusivo para Administradores</label>
                    </div>
                  </div>
                  
                 

                  <div class="form-group col-md-3">
                  
                    
                    <label for="faicone">F.A. Icone <a href="https://fontawesome.com/v5.15/icons"  target="_blank"><i class="fa fa-link"></i></a></label>
                    <div class="input-group">
                      <select id="icontype" class="bg-navy" name="iconetype">
                        <option value="fas" <?php if($get('iconetype')=='fas')echo 'selected';?>>Solido</option>  
                        <option value="far" <?php if($get('iconetype')=='far')echo 'selected';?>>Regular</option>
                        <option value="fab" <?php if($get('iconetype')=='fab')echo 'selected';?>>Brands</option>
                      </select>
                      <input type="text" value="<?php $echo('iconename');?>" class="form-control col-9 float-left border-right-0 rounded-0"  id="faicone" placeholder="ex: home"/>
                      <input type="hidden" name="icone" id="icone" value="<?php $echo('icone');?>"/>
                      <div class="form-control col-3 float-left border-left-0 rounded-0 m-0 text-right">
                        <i id="faviewicon" class="<?php $echo('icone');?>"></i>
                      </div>
                    </div>

                  </div>
                  <div class="form-group col-md-6">
                    <label for="tipomodulo">Tipo de módulo</label>
                    <select name="tipomodulo" id="tipomodulo" change="viewbox" name="tipomodulo" class="form-control">
                      <option >Box</option>
                      <option value="controller" <?php if($get('controller',false)) echo 'selected';?>>Contoller do Sistema</option>
                      <option value="url" <?php if($get('url',false)) echo 'selected';?>>Url externa</option>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-6 url viewbox" id="tipomodulo2">
                    <label for="url">Url Externa</label>
                    <input type="url" name="url" class="form-control" id="url" placeholder="Digite uma url externa para o sistema." value="<?php $echo('url');?>"/>
                  </div>
                    <div class="form-group col-6 col-md-3 viewbox controller">
                      <label for="controller">Controller</label>
                      <input type="text" name="controller" class="form-control" id="controller" value="<?php $echo('controller');?>" placeholder="Classe do controller."/>
                    </div>
                    <div class="form-group col-6 col-md-3 viewbox controller">
                      <label for="action">Action</label>
                      <input type="text" name="action" class="form-control" id="action"  value="<?php $echo('action');?>" name="action" placeholder="Action que deve ser executado"/>
                    </div>
                    <div class="form-group col-12 viewbox controller">                    
                           <?php $inputsgrupos->show();?>
                    </div>                     
                      
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" <?echo \core\Action::get('Modulos')->onclick(); ?> class="btn  bg-warning float-left"> <i class="fas fa-list mr-1"></i> Listar Módulos</button>    
                    <button type="button" <?echo \core\Action::get('Modulos','edit')->onclick(); ?> class="btn  bg-success float-left ml-3"> <i class="fas fa-plus-circle mr-1"></i> Novo Módulo</button>    
                    <button type="submit" class="btn btn-primary bg-navy float-right ml-3"> <i class="fas fa-save fa-regular mr-1"></i> Salvar</button>
                    <?php if(isset($cod_modulo)){?>
                    <input type="hidden" name="cod_modulo" value="<?php echo $cod_modulo;?>"/>
                    <button type="button" class="btn btn-danger float-right ml-3" <?php echo \core\Action::get('Modulos','delete',['cod_modulo'=>$cod_modulo])->onclick()?>> <i class="fas fa-trash fa-regular mr-1"></i> Excluir</button>
                    <?php }?>
                </div>
              </form>
            </div>
    </div>
</div>

