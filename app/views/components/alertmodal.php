<div class="modal fade" id="<?php echo $id?>" color-default="<?php echo $color_default?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-navy">
            <h4 class="modal-title">Confirma a Operação?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Você realmente deseja confirmar esta operação?</p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" id="modal_btn_confirme" class="btn bg-navy">Confirmar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>