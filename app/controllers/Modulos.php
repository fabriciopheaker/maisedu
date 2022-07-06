<?php

namespace controllers;

use components\Alert;
use components\Button;
use components\ButtonConfirmationModal;
use components\ChecksFromModel;
use components\DataGrid;
use components\SelectFromModel;
use core\Action;
use core\Controller;
use core\Model;
use core\Request;
use core\Script;
use core\View;
use core\Style;
use models\Grupo;
use models\Modulo as ModelModulo;

class Modulos extends Controller{
    public function index(){
        $action_edit= new Action('Modulos','edit');
        $action_delete= new Action('Modulos','delete');
        $view = new View('modulo.php');
        $view->title = 'Gerenciar Módulos';
        $view->datatable = new DataGrid(ModelModulo::class,['cod_modulo'=>'Cod.','menu'=>"Modulo"],20);
        $view->datatable->convertColumnInLink('menu',$action_edit,['codigo'=>'cod_modulo']);
        $button_edit = new Button($action_edit,'far fa-edit','','text-navy');
        $button_delete = new ButtonConfirmationModal($action_delete,'fas fa-trash','','text-danger',"Confirma a exclusão?",
        'Você confirma a exclusão permanente do registro no banco de dados.','Excluir',ButtonConfirmationModal::DANGER);
        $button_delete->title = "Deletar registro";
        $button_edit->title = "Clique para editar o modulo";
        $view->datatable->addButtonInActionColumn($button_edit,['codigo'=>'cod_modulo']);
        $view->datatable->addButtonInActionColumn($button_delete,['cod_modulo'=>'cod_modulo']);
        $view->datatable->title = "Módulos";
        $view->datatable->addSearch();
        $view->show();
    }

    public function edit(Request $request){
        $view = new View('modulo_edit.php');
        $view->title = 'Gerenciar Módulos';
        $view->card_title='Novo Módulo';
        $modulo = new ModelModulo($request->codigo);
        $where = ['url is null AND controller is null', []];
        if($modulo->cod_modulo){
            $view->card_title='Alterando Módulo com código '.$modulo->cod_modulo;
            $where[0].=' AND cod_modulo <> :cod_modulo';
            $where[1]['cod_modulo'] = $modulo->cod_modulo;
        }
        $view->inputsgrupos = new ChecksFromModel(
                        Grupo::class,'grupos', 
                        'Privilégios aos Grupos:',
                        $modulo->getCodGrupos());
        
        $view->addArray($modulo->getData());
        $modulos = new ModelModulo();
        $modulos = $modulos->getOptionsSelect($where);
        $modulos[0] = 'Principal';
        ksort($modulos);
        $view->menu_pai = new SelectFromModel($modulos,
        (is_null($modulo->cod_modulo_pai))?0:$modulo->cod_modulo_pai
        ,'Selecione o módulo em qual este será aninhado',
        null,
        'cod_modulo_pai',
        true);
        
        Script::addScript("
            let addicon =  function() 
            {
                let value =  $('#faicone').val();
                $('#faviewicon').toggleClass();
                let type = $('#icontype').val();
                let icone = type+' fa-'+value;
                $('#icone').val(icone)
                $('#faviewicon').addClass(icone);
            };
            $('#faicone').focusout(function(){
                addicon();
            });
            $('#icontype').change(function(){
                addicon();
                });
            addicon();
            var selectviewbox = $('select[change=\"viewbox\"]');
            
            let viewBox = function() {
                $('.viewbox').addClass('d-none');
                let boxselect = selectviewbox.val();
                if(boxselect != ''){
                    $('.'+selectviewbox.val()).removeClass('d-none');
                }
               
            }
            selectviewbox.change(function(){
                viewBox();
            });
            viewBox();");
        $view->show();
        
    }
    private function goBackError($titulo, $mensagem){
        $mensagem = new Alert(Alert::ALERT_DANGER,$titulo, $mensagem);
        $mensagem->registerFlashMessage();
        Action::get('Modulos','edit')->redirect();
    }

    public function save(Request $request){
        $data = $request->getData();
        $modulo = new ModelModulo($request->cod_modulo);
        $grupos  = $request->input('grupos',[]);
        if(count($grupos)){
            $grupos = array_keys($grupos);
        }
        $data['grupos'] = $grupos;
        try{
            $modulo->save($data);
        }catch(\PDOException $e){
            throw $e;
            $this->goBackError('Erro ao inserir dados!','Por algum motivo imprevisto os dados não puderam ser salvos,
             nossa equipe já está trabalhando para resolver o problema.');

        }catch(\Exception $e){
            $this->goBackError('Erro ao inserir dados!',$e->getMessage());

        }
        
        $frase = (isset($request->cod_modulo))?'alterado':'inserido';
        $mensagem = new Alert(Alert::ALERT_SUCCESS,"Sucesso!", "O módulo foi $frase.");
        $mensagem->registerFlashMessage();
        Action::get('Modulos','edit',['codigo'=>$modulo->cod_modulo])->redirect();
    }

    public function delete(Request $request){
        $modulo = new ModelModulo($request->cod_modulo);
        $mensagem = new Alert(Alert::ALERT_SUCCESS,"Sucesso!", "O módulo '$modulo->menu' foi excluido.");
        $modulo->delete();
        $mensagem->registerFlashMessage();
        Action::get('Modulos')->redirect();
        

    }
}