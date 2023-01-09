<?php include('container/header.php'); 

?>
<style type="text/css">
    .dealer-locators-locations{
		padding: 30px 20px 10px 20px;
		border: 1px solid rgba(0,0,0,0.1);
		transition: all 0.3s ease;
		position: relative;
		margin-bottom: 30px;
	}
	.dealer-locators-locations:hover{
		box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
		transition: all 0.3s ease;
	}
	.dealer-locators-locations:before{
		position: absolute;
		left: 0px;
		top: 0px;
		width: 0px;
		height: 5px;
		content:"";
		background: #f70009;
		transition: all 0.3s ease;
	}
	.dealer-locators-locations:hover:before{
		width: 50%;
		transition: all 0.3s ease;
	}
	.dealer-locators-locations h4{
		margin-bottom: 20px;
		color: #111;
	}
	.dealer-locators-locations p.icon{
		position: relative;
		margin-bottom: 0px;
		padding:0px 0px 20px 30px;
	}
	.dealer-locators-locations p.icon.address{
		min-height: 70px;
	}
	.dealer-locators-locations p.icon i{
		position: absolute;
		left: 0px;
		top: 3px;
		color: #f70009;
		font-size: 14px;
	}
	.dealer-locators-locations p.icon a{
		font-weight: 500;
		color: #000;
		transition: all 0.3s ease;
	}
	.dealer-locators-locations p.icon a:hover{
		color: #f70009;
		transition: all 0.3s ease;
	}
</style>
<section class="inner-page-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Locate our</h1>
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Dealer Locators</h2>
			</div>
			<div class="col-sm-12 col-md-6 d-none d-md-block">
				<img src="<?= base_url(); ?>assets/front-end/images/dealer-locator.svg" alt="" class="img-fluid"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Dealer Locators</div>
			</div>
		</div>		
	
</div>

<div class="bgPro videoGal clearfix">
	<div class="container mt-5 bg-white p-5 shadow1">
		<div class="row" >
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 pb-3">
				<h3>Select Location</h3>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pb-3">
				
				
                  <select class="form-control" name="state_id" id="state_id" onchange="fnloadstateaddress(this.value);">
                      <option disabled value="">All States</option>
                      <?php if(!empty($state)){ 
                          foreach($state as $info){ ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('state_id', $info['id'] ,($info['id'] == "1" ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                
               
				<!--<select class="form-control">
					<option selected>All States</option>
					<option>Tamilnadu</option>
					<option>Puducherry</option>
				</select> -->
			</div>
			<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pb-3" id="divcity">
				    <select class="form-control" name="city_id" id="city_id" onchange="finddealer();">
                      <option value="">All City</option>
                      <?php if(!empty($city)){ 
                          foreach($city as $info){ ?>
                          <option  value="<?= $info['id'] ?>" ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 pb-3">
				<div class="divider"></div>
			</div>
		</div>
		<div class="row" id="divcenter">
		<?php if(count($center)>0 ) { ?>
		<?php foreach($center as $c) { ?>
			<div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
				<div class="dealer-locators-locations">
					<h4><?php echo $c['title'];?></h4>
					<p class="icon address"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $c['address'];?></p>
					<p class="icon"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php echo $c['email'];?>" target="_blank"><?php echo $c['email'];?></a></p>
					<p class="icon"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $c['phone'];?></p>
					<p class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="<?php echo $c['googleurl'];?>" target="_blank">View Map</a></p>
				</div>
			</div>
		<?php } ?>		
		<?php } else { ?>

		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">No Dealers in Your Area</div>

		<?php } ?>	
			
			
		
		</div>
	</div>
</div>

</section>
<?php require_once('container/footer1.php')?>
<script>
function fnloadstateaddress(sid)
{
	 $.ajax({
			url:'<?php echo base_url("home/loadservicecity"); ?>',
			dataType: 'text',
			type:'POST',
			data:'sid='+sid,
			success:function(data){
				$("#divcity").html("");	
				$("#divcity").html(data);	
				findcenter();	
			}
		});	
	
		

}	
function finddealer(){
	
	var sid=$("#state_id").val();
	var cid=$("#city_id").val();
 $.ajax({
			url:'<?php echo base_url("home/ajaxfinddealer"); ?>',
			dataType: 'text',
			type:'POST',
			data:'sid='+sid+"&cid="+cid,
			success:function(data){
				$("#divcenter").html("");	
			   $("#divcenter").html(data);	
			
			}
		});	


}	  
 </script>
