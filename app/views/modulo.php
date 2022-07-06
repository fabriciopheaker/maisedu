
<div class="row mb-3">
    <div class='col'>
        <button type="button" class="btn btn-success float-right" 
            <?php echo \core\Action::get('Modulos','edit')->onclick();?>> 
        <i class="fas fa-plus-circle"></i> Novo Módulo    
    </button>
    </div>
</div>
<div class="row">
    <div class='col'>
        <?php $datatable->show();?>
    </div>
</div>