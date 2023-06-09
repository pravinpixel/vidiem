<style>
 .secoContBlock{display:none};
 
</style>
<section class="qviewPopup clearfix">
  <ul class="popupQv clearfix popup_product_info">
  </ul>
</section>

  <div class="addCompSet clearfix" id="comProList">
    <div class="container clearfix">
      <div class="comHead clearfix">
        <p>Compare Products</p>
        <div class="comNextColse">
          <a class="btn" href="<?= base_url('compare'); ?>">See Comparision</a>
          <a class="btn remove_compare_all" href="javascript:void(0);">Remove All</a>
          <a class="btn compClose" href="javascript:void(0);">X</a>
        </div>
      </div>

      <ul class="mix_list2 comproList clearfix comproList_section">
        <?php 
        $compare=$this->session->userdata('c_products'); 
       if(!empty($compare)){
        foreach ($compare as $info) { 
        $tmp=$this->FunctionModel->Select_Fields_Row('id,name,image,slug,price,outofstock','vidiem_products',array('id'=>$info));
          ?>
              <li class="clearfix">
                <div class="proImg prodimg">
                    <img src="<?= base_url('uploads/images/'.$tmp['image']); ?>" alt="" />
                    <em class="prHov">
                        <a href="javascript:void(0);" class="QVpopup quick_view_trigger" data-id="<?= $tmp['id']; ?>"><i class="fa fa-eye"></i>Quick View</a>
                        <a href="<?= base_url('product/'.$tmp['slug']); ?>"><i class="fa fa-plus"></i>More</a>
                    </em>
                </div>
                <div class="mix_det clearfix">
                    <p><?= $tmp['name']; ?></p>
                        <h4><i class="fa fa-inr"></i><?= number_format($tmp['price']); ?>/-</h4>
                    <div class="mix_det_rt clearfix">
                    <?php if($tmp['outofstock']==0){ ?>
                        <a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="<?= @$tmp['id']; ?>">Add to cart</a>
                    <?php }else{ ?>
                        <a class="mix_det_rt_add btn" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
                    <?php } ?>

                        <a class="mix_det_rt_add comProRov btn remove_compare_products" href="javascript:void(0);" data-id="<?= $tmp['id']; ?>">Remove</a>
                    </div>
                </div>
            </li>
          <?php }} else{ ?>
            <li>Compare List Empty</li>
          <?php } ?>  
      </ul>
    </div>
  </div>

<section class="footer clearfix">
  <div class="footerTop clearfix">
    <div class="container clearfix">
      <div class="newsLetLeft clearfix">
        <p class="neName">News Letter</p>
          <form action="" method="POST" class="inline-form newsletter_form">
        <p class="newsBox">
          <input type="text" name="newsletter_mail" placeholder="Enter your mail id" class="newsletter_mail">
          <a href="javascript:void(0)" class="newsletter_btn"><i class="fa fa-long-arrow-right"></i></a>
        </p>
          </form>
      </div>
      <ul class="riMedia clearfix">
        <li>
          <a target="_blank" href="https://www.facebook.com/VidiemTM/">
            <img src="<?= base_url(); ?>assets/front-end/images/fb.png" alt=""/>
          </a>
        </li>
        <li>
          <a target="_blank" href="https://twitter.com/vidiemmaya">
            <img src="<?= base_url(); ?>assets/front-end/images/tw.png" alt=""/>
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.instagram.com/vidiemtm/">
            <img src="<?= base_url(); ?>assets/front-end/images/insta.png" alt=""/>
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.youtube.com/channel/UCLJE5AoP7y7ccfFrMFyAv8g">
            <img src="<?= base_url(); ?>assets/front-end/images/yt.png" alt=""/>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="footerBottom">
      <div class="foMenuSet clearfix">
        <ul class="fomenu">
          <li><h4 class="foTitle">Categories</h4></li>
          <?php if(!empty($cat_menu)) {
                  foreach($cat_menu as $info){ ?>
                <li><a href="<?= base_url('category/'.$info['slug']); ?>" class="<?= (!empty($cat_slug) && $cat_slug==$info['slug'])?'active':''; ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> <?= $info['name']; ?></a></li>
              <?php } } ?>
        </ul>

        <ul class="fomenu information">
          <li><h4 class="foTitle">Information</h4></li>
          <li>
            <a href="<?= base_url('about-us'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> About Us</a>
          </li>
          <li>
            <a href="<?= base_url('contact-us'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Contact Us</a>
          </li>
          <li>
            <a href="<?= base_url('cancellation-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Cancellation Policy</a>
          </li>
          <li>
            <a href="<?= base_url('disclaimer'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Disclaimer</a>
          </li>
          <li>
            <a href="<?= base_url('privacy-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Privacy Policy</a>
          </li>
          <li>
            <a href="<?= base_url('return-refund-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Return & Refund Policy</a>
          </li>
          <li>
            <a href="<?= base_url('shipping-delivery');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Shipping & Delivery</a>
          </li>
          <li>
            <a href="<?= base_url('sitemap');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Sitemap</a>
          </li>
          <li>
            <a href="<?= base_url('terms-conditions');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Terms and Conditions of Use</a>
          </li>
          <li>
            <a href="<?= base_url('warranty');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Warranty Terms</a>
          </li>
        </ul>

        <ul class="fomenu orderInfo">
          <li><h4 class="foTitle">My Account</h4></li>
          <li>
              <?php if($this->session->userdata('client_id')){?>
            <a href="<?= base_url('user/dashboard');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Orders</a>
            <?php }else{?>
             <a href="<?= base_url('sign-in');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Orders</a>
             <?php } ?>
          </li>
          <!--<li>
              <?php if($this->session->userdata('client_id')){?>
            <a href="<?= base_url('user/dashboard');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Credit Slips</a>
            <?php } else {?>
            <a href="<?= base_url('sign-in');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Credit Slips</a>
            <?php } ?>
          </li>-->
          <li>
              <?php if($this->session->userdata('client_id')){?>
            <a href="<?= base_url('user/dashboard');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Address</a>
            <?php } else{?>
            <a href="<?= base_url('sign-in');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Addresses</a>
            <?php } ?>
          </li>
          <li>
              <?php if($this->session->userdata('client_id')){?>
            <a href="<?= base_url('user/dashboard');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Personal Info</a>
            <?php } else{?>
             <a href="<?= base_url('sign-in');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> My Personal Info</a>
             <?php } ?>
          </li>
          <li>
            <p class="help">HELP</p>
          </li>
          <li>
            <a href="<?= base_url('cancellation-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Cancellation & Returns</a>
          </li>
          <li>
            <a href="<?= base_url('faqs');?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> FAQ</a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Payments</a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Report Infringement</a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Shipping</a>
          </li>
          <li>
            <a href="<?= base_url('track-order'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/menuarrow.png" alt=""/> Track Order</a>
          </li>
        </ul>

        <ul class="fomenu mediafeed">
          <li><h4 class="foTitle">Instagram Feed</h4></li>
          <li>
            <div class="instagram">
              <img src="<?= base_url(); ?>assets/front-end/images/instagram.jpg" alt="" class=""/>
              <div class="insta">
                   <a target="_blank" href="javascript:void(0);" class="insta_url"><img src="<?= base_url(); ?>assets/front-end/images/inst.jpg" alt="" class="insta_profile" width="58px" height="58px"/></a>

                    <div class="follo">

                      <a target="_blank" href="javascript:void(0);" class='insta_name insta_url'>vidiemtm</a>
                      <p class="insTaFoloImg"> <img src="<?= base_url(); ?>assets/front-end/images/follower.png" alt=""/><span class='insta_follower'>166 +<span></p>
                      
                    </div>
              </div>

              <div class="inlogo">
                <a target="_blank" href="javascript:void(0);" class="insta_url">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                  <p>Post Page</p>
                </a>
 
              </div>
            </div>
          </li>




          <li class="fbFeed"><h4 class="foTitle">Facebook Feed</h4></li>
          <li>
            <a href="javascript:void(0);">
              <!-- <img src="<?= base_url(); ?>assets/front-end/images/facebook.jpg" alt=""/> -->
              
              <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FMaya-Appliances-Pvt-Ltd%2F1445263385703543%3Fref%3Dbr_tf&amp;width=250&amp;height=250&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe>

            </a>
          </li>
        </ul>

        <ul class="fomenu addInfo">
          <li><h4 class="foTitle">Contact Info</h4></li>
          <li>
            <p class="address">
              No. 3/140, Old Mahabalipuram Road<br>
              Oggiam, Thoraipakkam<br>
              Chennai - 600 097<br>
              Tamilnadu, INDIA.
            </p>
          </li>
          <li class="phno">
            <a href="tel:18001238436">1800-123-8436(Toll Free)</a>
          </li>
          <li class="phno">
            <a href="mail-to:care@vidiem.in">care@vidiem.in</a>
          </li>
        </ul>
      </div>  
      <ul class="payMeth">
       <!-- <li><a href="javascript:void(0)"><img src="<?= base_url(); ?>assets/front-end/images/place.png" alt="" /> Track Your Order</a></li>-->
       <li><a href="<?= base_url('track-order'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/place.png" alt="" /> Track Your Order</a></li>
        <li><a href="<?= base_url('return-refund-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/refund.png" alt="" /> Free & Easy Returns</a></li>
        <li><a href="<?= base_url('cancellation-policy'); ?>"><img src="<?= base_url(); ?>assets/front-end/images/cancell.png" alt="" /> Online Cancellations</a></li>
        <li><a href="javascript:void(0)"><p>Payment Method</p>
          <img src="<?= base_url(); ?>assets/front-end/images/payment.png" alt="" /></a></li>
      </ul>
  </div>
</section>

<script type="text/javascript">
  var token = '3109472657.1677ed0.1800c58d8e8543c28dbf24fc0a6bea28';
 
$.ajax({
    url: 'https://api.instagram.com/v1/users/self/',
    dataType: 'jsonp',
    type: 'GET',
    data: {access_token: token},
    success: function(data){
        console.log(data);
        var x=data.data['counts'];
        $('.insta_profile').attr('src',data.data['profile_picture']);
        $('.insta_url').attr('href','https://www.instagram.com/'+data.data['username']+'/');
         $('.insta_name').html(data.data['full_name']);
         $('.insta_follower').html(x['followed_by']+'+');
        //for( x in data.data ){
          //  $('ul#rudr_instafeed').append('<li><a href="'+data.data[x].link+'" target="_blank"><img src="'+data.data[x].images.low_resolution.url+'"> <div class="instFeeLike"><i class="fa fa-heart"></i>'+data.data[x].likes.count+'</div></a></li>');
        //}
    },
    error: function(data){
        console.log(data);
    }
});
</script> 
<script type="text/javascript">
var addCartButton = document.querySelector('a.add_to_cart');
addCartButton.addEventListener("click", () => {
    fbq('track', 'AddCartButton');
});
</script>

<?php $reload=$this->session->flashdata('reload'); 
    if(!empty($reload)){ ?>
      <script>
      window.close();
      window.opener.location.reload();
      </script>
<?php } ?>

<?php $fb_issue=$this->session->flashdata('fb_issue'); 
    if(!empty($fb_issue)){ ?>
      <script>
      setTimeout(
    function() {
       window.close();
    }, 3000);
      </script>
<?php } ?>

<?php $title=$this->session->flashdata('title'); 
if(!empty($title)){ 
  $msg=$this->session->flashdata('msg');
  $type=$this->session->flashdata('type');
  ?>
<script>
  $(document).ready(function(){
      swal("<?= $title; ?>", "<?= $msg; ?>", "<?= $type; ?>");
  })
</script>
<?php   
     $this->session->unset_userdata('title');
     $this->session->unset_userdata('msg');
     $this->session->unset_userdata('type');
} ?>
<style type="text/css">
  .shortBy{
    float: left;
    margin-right: 20px;
  }

  .shortBy select{
    height: 38px;
    padding: 0 15px;
    outline: none;
    border: solid 1px #ccc;
  }
</style>
<div class="cyright clearfix">
  <img src="<?= base_url(); ?>assets/front-end/images/fterlogo.png" alt="" />
  <p>Copyright @ 2019. All Rights Reserved</p>
</div>
</body>
</html>