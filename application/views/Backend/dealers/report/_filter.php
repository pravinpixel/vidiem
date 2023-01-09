 <!-- Client Status Update Modal -->
 <div class="modal fade" id="clientStatus">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dealer Sale Report Filters</h4>
                    </div>
                    <form class="form-horizontal" id="report_filter_form" action="<?= base_url('dealer-admin/dealers/reports'); ?>" method="POST">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="inputDate">Date Range </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control daterangepicker1" id="inputDate" name="date"
                                        value="<?= $_POST['date'] ?? '' ?>">
                                </div>
                            </div>
                            <input type="hidden" name="export" id="export" value="">
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
                            <div class="form-group">
                                <label for="inputPaymentType" class="col-sm-3 control-label">Payment Status</label>
                                <div class="col-sm-9">
                                    <select name="payment_status" id="payment_status" class="form-control">
                                        <option value=""> All </option>
                                        <option value="success" <?= $_POST['payment_status'] == 'success' ? 'selected' : ''; ?>>Paid</option>
                                        <option value="pending" <?= $_POST['payment_status'] == 'pending' ? 'selected' : ''; ?>>Not Paid</option>
                                    </select>
                                    <?= form_error('payment_status'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button class="btn btn-danger" type="button" onclick="return clearFilter();"> Clear Filter </button>
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