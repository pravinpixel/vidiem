<?php $this->load->view('dealer/layout/header-top'); ?>

<?php $this->load->view('dealer/layout/script'); ?>
<div class="SignUpPage clearfix">
    <section class="py-5 clearfix">
        <div class="container">			
            <div class="row justify-content-between align-items-center">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-5">
					<img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/Full_bg1.jpg" class="img-fluid mb-4 d-none d-sm-block" alt="" />
				</div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5">
                    <div class="siginInSetTop clearfix dealer-login-bg p-5">
                        <form class="sgInSet clearfix mb-5" id="signIn" method="POST">
							<div class="row justify-content-between align-items-center no-gutters">
								<div class="col-5 col-sm-5">
									<img src="<?= base_url(); ?>assets/front-end/images/logo.png" class="img-fluid" alt="" />
								</div>
							</div>
                            <h2 class="my-4">Dealers Zone</h2>
                            <h4 class="text-dark">Sign In</h4>
                            <div class="row createAcc">
                                <div class="col-sm-12 col-md-12">
                                    <div class="md-form">
                                        <input type="text" name="user_name" class="form-control"
                                            value="<?= set_value('user_name'); ?>" required>
                                        <?= form_error('user_name'); ?>
                                        <label for="">User Id</label>

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="md-form">
                                        <input type="password" class="form-control" name="password" required>
                                        <?= form_error('password'); ?>
                                        <label for="">Password</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <button class="red-btn" type="submit" id="dealer-login-submit"><i class="lni lni-enter"></i> &nbsp;
                                                Sign In</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signIn').validate({
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>dealer/doDealerLogin",
                    data: $(form).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#dealer-login-submit').attr('disabled', true);
                    },
                    success: function (res) {
                        $('#dealer-login-submit').attr('disabled', false);
                        // console.log(res);
                        if( res.status == 1 ) {
                            if( res.user_type == 'sale_person' ) {
                                toastr.success('success', 'Login Success');
                                setTimeout(
                                    function(){
                                        window.location.href='<?= base_url()?>vidiem-dealer';
                                    }, 1000
                                )
                            } else {
                                toastr.success('success', 'Login Success');
                                setTimeout(
                                    function(){
                                        window.location.href='<?= base_url()?>dealer-admin';
                                    }, 1000
                                )
                            } 
                        } else {
                            toastr.error('Error', res.message);
                        }
                    }
                });
                return false; // required to block normal submit since you used ajax
            }
        });
    })
</script>





