 <!-- Client Status Update Modal -->
 <div class="modal fade" id="clientStatus">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dealer Sale Report Filters</h4>
                    </div>
                    <form class="form-horizontal" action="<?= base_url('Dealers/dashboard/index'); ?>" method="POST">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="inputDate">Date Range </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control daterangepicker1" id="inputDate" name="date"
                                        value="<?= $_POST['date'] ?? '' ?>">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="inputPaymentType" class="col-sm-3 control-label">Payment Type</label>
                                <div class="col-sm-9">
                                    <select name="status" id="inputPaymentType" class="form-control">
                                        <option value=""> All </option>
                                        <option value="1" <?= set_select('status','1'); ?>>Counter</option>
                                        <option value="2" <?= set_select('status','2'); ?>>Online</option>
                                    </select>
                                    <?= form_error('status'); ?>
                                </div>
                            </div>
                            <?php 
                            if( isset( $locations) && !empty( $locations ) ) {
                            ?>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"> Branch </label>
                                <div class="col-sm-9">
                                    <select name="location_id" id="location_id" class="form-control">
                                        <option value=""> All </option>
                                        <?php 
                                        foreach ($locations as $key => $value) {
                                            $selected       = '';
                                            if( $value->id == $_POST['location_id'] ) {
                                                $selected   = 'selected';
                                            }
                                        ?>
                                            <option value="<?= $value->id ?>" <?= $selected ?> ><?= $value->location_name ?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } 
                            global $order_status_name;
                            if( isset( $order_status_name ) && !empty( $order_status_name ) ) {
                            ?>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"> Order Status </label>
                                <div class="col-sm-9">
                                    <select name="order_status" id="order_status" class="form-control">
                                        <option value=""> All </option>
                                        <?php 
                                        foreach ($order_status_name as $akey => $avalue) {
                                            $selected       = '';
                                            if( $akey == $_POST['order_status'] ) {
                                                $selected   = 'selected';
                                            }
                                        ?>
                                            <option value="<?= $akey ?>" <?= $selected ?> ><?= $avalue ?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <div class="modal-footer">

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-default pull-right"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->