<div class="card card-navy card-outline ">
    <div class="card-header">
        <h3 class="card-title"><?php echo $title;?></h3>
        <?php if($search){ ?>
        <div class="card-tools">
            <form action="<? echo $search_action; ?>" method="GET" >
                <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="<?php echo $search_name;?>" class="form-control float-right" placeholder="Filtar" value="<?echo $search_value;?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
                <?php echo $search_additiona_parameters;?>
            </form>
        </div>
        <?php } ?>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <?php echo $thead;?>
            <tbody>
                <?php echo $tbody;?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
      <?php echo $pagination;?>
    </div>
</div>