<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title" id="exampleModalLabel">Are You Sure to Cancel Order?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cancelForm">
                    <div class="form-group">
                    <input type="hidden" id="order_id" name="order_id">
                    <label for="cancel_reason" class="col-form-label">Reason:</label>
                    <textarea class="form-control" name="cancel_reason" id="cancel_reason" required></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="order_cancel" >Cancel Order</button>
            </div>
        </div>
    </div>
</div>