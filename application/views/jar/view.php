<div class="modal-body">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-sm-12 col-12 text-center">
            <img src="<?= base_url('uploads/customizeimg/jar/'.$info->basepath) ?>" alt=""
                class="img-fluid" />
        </div>
        <div class="col-md-6 col-sm-12 col-12">
            <?php 
                // print_r( $info );
            ?>
            <h3 class="text-white"><?= $info->name ?></h3>
            <div class="table-responsive" id="jarview-description">
                <?= ( isset($info->description) && !empty( $info->description ) ) ? $info->description : '<div class="text-white">No Description available</div>' ?>
            </div>
        </div>
    </div>
</div>