<div class="box box-info">
    <style>
        .error {
            color:red;
        }
    </style>
    <div class="box-header with-border">
        <h3>Update Counter Payment Information</h3>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="form-horizontal" enctype="multipart/form-data" id="counter_form"
             method="post" novalidate="novalidate">
            <div class="box-body">
                <input type="hidden" name="id" value="<?= $order_id ?>">
                <div class="form-group">
                    <label for="dealer_name" class="col-sm-4 control-label">
                        Dealer Name
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="dealer_name" required="" name="dealer_name"
                            value="<?= $order_data->display_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_id" class="col-sm-4 control-label">
                        Order No
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="order_no" required="" name="order_no"
                            value="<?= $order_data->order_no ?? '' ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_id" class="col-sm-4 control-label">
                        Order ID
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="order_id" required="" name="order_id"
                            value="<?= $order_data->code ?? '' ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer_name" class="col-sm-4 control-label">
                        Customer Name
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="customer_name" required="" name="customer_name"
                            value="<?= $order_data->client_name ?? $order_data->billing_name ?? '' ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="product_ordered" class="col-sm-4 control-label">
                        Product Ordered
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="product_ordered" required="" name="product_ordered"
                            value="<?= $basicItemInfo['basetitle'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_value" class="col-sm-4 control-label">
                        Order Value
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="order_value" disable required="" name="order_value"
                            value="<?= $order_data->amount ?? '' ?>" readonly>
                    </div>
                </div>
                <?php 
                    // show($order_data);
                ?>
                <div class="form-group">
                    <label for="order_time" class="col-sm-4 control-label">
                        Order Time
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="order_time" disabled required="" name="order_time"
                            value="<?= date( 'd-M-Y H:i A', strtotime( $order_data->created ) ) ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receipt_no" class="col-sm-4 control-label">
                        Enter Receipt No.
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="receipt_no" required name="receipt_no" <?= (isset($order_data->pg_type) && !empty($order_data->pg_type)) ? 'readonly' : '' ?> value="<?= $order_data->pg_type ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="receipt" class="col-sm-4 control-label">
                         Receipt
                        

                        
                    </label>
                    <div class="col-sm-8">
                    <?php 
                        if( isset( $order_data->receipt_file ) && !empty( $order_data->receipt_file) ) {
                            $path = './uploads/dealer/orders/'.$order_data->receipt_file;
                            if( file_exists( $path ) ) { ?>
                            <div><a href="<?= base_url()?>uploads/dealer/orders/<?= $order_data->receipt_file ?>" target="_blank"> View File </a> </div>        
                        <?php    } 
                        } else {
                            echo 'File not uploaded';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="promoter_code" class="col-sm-4 control-label">
                        Enter Promoter Code
                        <span class="red">*</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="promoter_code" readonly name="promoter_code" 
                            value="<?= $order_data->promoter_code ?? '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="dealer_invoice" class="col-sm-4 control-label">
                        Upload Dealer Invoice
                        
                    </label>
                    <div class="col-sm-8">
                    <?php 
                        if( isset( $order_data->dealer_invoice ) && !empty( $order_data->dealer_invoice) ) {
                            $path = './uploads/dealer/orders/'.$order_data->dealer_invoice;
                            if( file_exists( $path ) ) { ?>
                            <div><a href="<?= base_url()?>uploads/dealer/orders/<?= $order_data->dealer_invoice ?>" target="_blank"> View File </a> </div>        
                        <?php    } 
                        } else {
                            echo 'File not uploaded';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="vidiem_invoice" class="col-sm-4 control-label">
                        Upload Vidiem Invoice
                        <?php 
                        if( isset( $order_data->vidiem_invoice ) && !empty( $order_data->vidiem_invoice) ) {
                            $path = './uploads/dealer/orders/'.$order_data->vidiem_invoice;
                            if( file_exists( $path ) ) { ?>
                            <div><a href="<?= base_url()?>uploads/dealer/orders/<?= $order_data->vidiem_invoice ?>" target="_blank"> View File </a> </div>        
                        <?php    } 
                        }
                        ?>
                    </label>
                    <div class="col-sm-8">
                        <input type="file" name="vidiem_invoice" id="vidiem_invoice" class="form-control" >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" id="pay-submit" class="btn btn-success col-sm-3"
                            style="margin-right:10px;">
                            Update & Save </button>
                            <a href="<?= base_url() ?>Admin/Customizeorders" id="dealer-submit" class="btn btn-danger col-sm-3"
                            style="margin-right:10px;">
                            Cancel & Exit </a>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </form>
        </div>
    </div>
   
</div>