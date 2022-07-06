
<div class="row mb-3">
    <div class='col'>
        <?php $component('Button',[\core\Action::get('Grupos','edit'),'fas fa-plus-circle','Novo Grupo','btn-success float-right'])->show();?>
    </div>
</div>
<div class="row">
    <div class='col'>
        <?php $datatable->show();?>
    </div>
</div>