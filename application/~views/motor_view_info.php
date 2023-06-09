<div class="modal-dialog modal-sm xx">
			<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"> Motor Info</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <i class="lni lni-close"></i>
   </button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
           
                    <img class="img-fluid mb-4" width="550px" src="<?= base_url('uploads/customizeimg/basemotor/'.$motor['base_motor_image']);?>" alt="motor-img">
                    
                    <h5 class="card-title">Name: <?= $motor['motorname'];?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Price: <?= $motor['price'];?></h6>
                    <p class="card-text">Description:<?= $motor['description'];?></p>
                   
			</div> 

			</div>
		</div>