<?php

namespace controllers;

use components\Alert;
use components\Button;
use components\ButtonConfirmationModal;
use components\ChecksFromModel;
use components\DataGrid;
use core\Action;
use core\Controller;
use core\Request;
use core\View;
use models\Grupo;
use models\Modulo;

class Grupos extends Controller{
    public function index(){
        $action_edit= new Action('Grupos','edit');
       
        $view = new View('grupo.php');
        $view->title = 'Gerenciar Grupo';
        $view->datatable = new DataGrid(Grupo::class,['cod_grupo'=>'Cod.','descricao'=>"Grupo"],20);
        $view->datatable->convertColumnInLink('descricao',
        $action_edit,['codigo'=>'cod_grupo']);
        //criando botão de edição
        $button_edit = new Button($action_edit,'far fa-edit','','text-navy');
        $view->datatable->addButtonInActionColumn($button_edit,['codigo'=>'cod_grupo']);
        $button_edit->title = "Clique para editar o modulo";
        //criando botão de exclusão
         $action_delete= new Action('Grupos','delete');
         $button_delete = new ButtonConfirmationModal($action_delete,'fas fa-trash','','text-danger',"Confirma a exclusão?",
        'Você confirma a exclusão permanente do registro no banco de dados.','Excluir',ButtonConfirmationModal::DANGER);
        $button_delete->title = "Deletar registro";
        $view->datatable->addButtonInActionColumn($button_delete,['cod_grupo'=>'cod_grupo']);
        
        $view->datatable->title = "Grupos cadastrados";
        $view->datatable->addSearch();
        $view->show();
    }

    public function edit(Request $request){
        $view = new View('grupo_edit.php');
        $view->title = "Gerenciar Grupos";
        $view->card_title = (isset($request->codigo))?'Alterar Grupo':'Criar Novo Grupo';
        $grupo = new Grupo($request->codigo);
        $view->addArray($grupo->getData());
        $where = [
            'controller is not null;',
            []
        ];
        $view->inputs_modulos = new ChecksFromModel(Modulo::class,'modulos',
        'Selecione os módulos que o grupo poderá acessar:',
        $grupo->getCodModulos(),$where);
        $view->show();
    }


    public function save(Request $request){
        $data = $request->getData();
        if(array_key_exists('modulos',$data)){
            $data['modulos'] = array_keys($data['modulos']);
        }else{
            $data['modulos'] = [];
        }
        $grupo = new Grupo($request->cod_grupo);
        try{
            $grupo->save($data);
        }catch(\PDOException $e){
            throw $e;
        }catch(\Exception $e){
            $this->flashMessage('Erro de cadastro',$e->getMessage(), Alert::ALERT_DANGER);
            $this->registerOld($data);
            Action::get('Grupos','edit')->redirect();
        }
        $this->flashMessage('Sucesso!','Cadastro realizado com sucesso!', Alert::ALERT_SUCCESS);
        Action::get('Grupos','edit',['codigo'=>$grupo->cod_grupo])->redirect();

    }


    public function delete(Request $request){
        $grupo = new Grupo($request->cod_grupo);
        try{
            $grupo->delete();
        }catch(\PDOException $e){
            throw $e;
        }catch(\Exception $e){
            $this->flashMessage('Erro de cadastro',$e->getMessage(), Alert::ALERT_DANGER);
            Action::get('Grupos','edit')->redirect();
        }
        $this->flashMessage('Sucesso!','Cadastro realizado com sucesso!', Alert::ALERT_SUCCESS);
        Action::get('Grupos')->redirect();

    }
}