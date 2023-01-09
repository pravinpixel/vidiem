<?php include('container/header.php')?>
<section class="ban-next light-gray-bg pb-0">
	<div class="container">
		<div class="row">
			<div class="col">
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Compare Product</h2>
			</div>
		</div>
	</div>
</section>
<section class="ban-next light-gray-bg pt-0">
<div class="container">
<div class="row">
<div class="col">
<div class="bgPro proDetaPage clearfix">
	<section class="comparePro p-5 bg-white shadow1">
	<div class="teble-responsive">
		<?php if(!empty($product)){ ?>
		<table class="table table-bordered">
			<tr>
			  <th class="titCom comheading">Products Compare</th>
			  <?php if(!empty($product[0])){ ?>
			  <th class="proCom1">
			  	<div class="comPro1 text-center">
			  		<img src="<?= base_url('uploads/images/'.$product[0][0]['pro_image']); ?>" alt="" class="img-fluid compare-img" />
			  	</div>
			  </th>
			<?php } ?>
			<?php if(!empty($product[1])){ ?>
			  <th class="proCom1">
			  	<div class="comPro1">
			  		<img class="img-fluid compare-img" src="<?= base_url('uploads/images/'.$product[1][0]['pro_image']); ?>" alt="" />
			  	</div>
			  </th>
			<?php } ?>
			<?php if(!empty($product[2])){ ?>
				<th class="proCom1">
			  	<div class="comPro1">
			  		<img class="img-fluid compare-img" src="<?= base_url('uploads/images/'.$product[2][0]['pro_image']); ?>" alt="" />
			  	</div>
			  </th>
			<?php } ?>
			</tr>
			<tr>
			  <td class="titCom comheading">Model No.</td>
			  <?php if(!empty($product[0])){ ?>
			  <td class="proCom1">
			  	<?= $product[0][0]['pro_modal_no']; ?>
			  </td>
			<?php } ?>
			<?php if(!empty($product[1])){ ?>
			  <td class="proCom1">
			  	<?= $product[1][0]['pro_modal_no']; ?>
			  </td>
			<?php } ?>
			<?php if(!empty($product[2])){ ?>
				<td class="proCom1">
			  	<?= $product[2][0]['pro_modal_no']; ?>
			  </td>
			<?php } ?>
			</tr>
			<?php $x=0;
			foreach ($product[0] as $info) {
                echo '<tr><td>'.$info['name'].'</td><td>'.$info['value'].'</td>';
                if(!empty($product[1])){
                    echo '<td>'.$product[1][$x]['value'].'</td>';
                }
                 if(!empty($product[2])){
                    echo '<td>'.$product[2][$x]['value'].'</td>';
                }
                echo '</tr>';
                $x++;
            } ?>

			<tr class="compareReBtn">
			  <td></td>
				 <?php if(!empty($product[0])){ ?>
			  <td>
			  	<div class="comBtn">
			  		<a class="black-btn small compare_remove_reload mr-3" href="javascript:void(0);" data-id="<?= $product[0][0]['pro_id']; ?>">Remove</a>
			  		<?php if($product[0][0]['outofstock']==0){ ?>
                        <a class="red-btn small add_to_cart" href="javascript:void(0);" data-id="<?= $product[0][0]['pro_id']; ?>">Add To Cart</a>
                    <?php }else{ ?>
                        <a class="black-btn small add_to_cart" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
                    <?php } ?>
			  	</div>
			  </td>
			<?php } ?>
			<?php if(!empty($product[1])){ ?>
			  <td>
			  	<div class="comBtn">
			  		<a class="black-btn small compare_remove_reload" href="javascript:void(0);" data-id="<?= $product[1][0]['pro_id']; ?>">Remove</a>
			  		<?php if($product[1][0]['outofstock']==0){ ?>
                        <a class="red-btn small add_to_cart mr-3" href="javascript:void(0);" data-id="<?= $product[1][0]['pro_id']; ?>">Add To Cart</a>
                    <?php }else{ ?>
                        <a class="black-btn small add_to_cart" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
                    <?php } ?>
			  	</div>
			  </td>
			<?php } ?>
			<?php if(!empty($product[2])){ ?>
			  <td>
			  	<div class="comBtn">
			  		<a class="black-btn small compare_remove_reload" href="javascript:void(0);" data-id="<?= $product[2][0]['pro_id']; ?>">Remove</a>
			  		<?php if($product[2][0]['outofstock']==0){ ?>
                        <a class="red-btn small add_to_cart mr-3" href="javascript:void(0);" data-id="<?= $product[2][0]['pro_id']; ?>">Add To Cart</a>
                    <?php }else{ ?>
                        <a class="black-btn small add_to_cart" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
                    <?php } ?>
			  	</div>
			  </td>
			<?php } ?>
		</tr>
		<tr class="compareReBtn">
			<td></td>
			<td><div class="comBtn"><a class="red-btn small compare_remove_all_reload" href="javascript:void(0);">Remove All</a></div></td>
		</tr>
		</table>
		<?php } else{ ?>
			<h5>Compare Product List Empty</h5>
		<?php } ?>	
		</div>
	</section>

<?php //require_once('container/top_seller.php'); ?>	
</div>
</div>
</div>
</div>
</section>
<?php require_once('container/footer.php')?>