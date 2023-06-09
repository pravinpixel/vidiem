<?= $this->load->view('container/header.php')?>
<section class="inner-page-bg pb-5">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Track Your Order</h1>
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Tracking Your Shipment <br/>Has Been Easier</h2>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?= base_url(); ?>assets/front-end/images/Tracking-Vector.png" alt="" class="img-fluid mb-5 d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Track</div>
			</div>
		</div>
</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 mb-5">
				<div class="bg-white shadow1 p-4">
					<h2 class="text-red">Track Your Order</h2>
                    <div class="p-3">
                        <form id="track-form">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4 pt-4">
                                    <div class="md-form">
                                        <input type="text" class="form-control" value="<?= set_value('code'); ?>" name="code" id="code" required>
                                        <label for=""> Your Invoice Number </label>
                                        <?= form_error('code'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 pt-4">
                                    <div class="md-form">
                                        <input type="text" class="form-control" value="<?= set_value('email'); ?>" name="email" id="email" required>
                                        <label for=""> Mail Address </label>
                                        <?= form_error('email'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 pt-4">
                                    <button type="submit" class="red-btn small">Submit</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                    <div id="tracking-pane">
                        
                    </div>
				</div>                
			</div>
		</div>
	</div>
</section>

<?= $this->load->view('container/footer.php')?>
<script>
    $('#track-form').validate({
        rules: {
            code: {
                required: true,
            },
            email: {
                required: true,
                email:true
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>tracking/get_tracking_info",
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if( res.view ) {
                        $('#tracking-pane').html(res.view);
                    }
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });
</script>
