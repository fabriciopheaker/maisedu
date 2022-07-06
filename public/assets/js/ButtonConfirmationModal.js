//**Script criado pelo professor Joaquim Scavone todos os direitos reservados. */

$(document).ready(function(){
    
    $('.ConfirmationModal').on('click',function(){
        attrExists = (attrName) => {
            let attr = $(this).attr(attrName);
            if(typeof attr !=='undefined' && attr !==false){
                return attr;
            }
            return false;
        }
        setIfExists = (button_attr,modal) => {
            let attr = attrExists(button_attr);
            if(attr!==false){
                $(modal).html(attr);
            }
        }
        setModalColor = (color) => {
            header = $(id+' .modal-header');
            header.removeClass();
            header.addClass('modal-header bg-'+color)
            btn = $('#modal_btn_confirme');
            btn.removeClass();
            btn.addClass('btn bg-'+color)
        }
        let id = $(this).attr('data-target');
        setIfExists('modal_title',id+' .modal-title');
        setIfExists('modal_text',id+' .modal-body');
        setIfExists('modal_btn_confirme','#modal_btn_confirme');
        
        
        color = attrExists('modal_color');
        if(color!==false){
            setModalColor(color)
        }else{
            setModalColor($(id).attr('color-default'));
        }
        action = attrExists('action');
        if(action!==false){
            let btn = $('#modal_btn_confirme');
            btn.attr('onclick',"window.location.href='"+action+"'");
        }
    });
});