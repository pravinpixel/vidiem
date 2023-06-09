<?php 
if($trackItems2)
{
?>
<div class="light-gray-bg p-3 mt-4 border">
    <div class="row align-items-center">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
            <h4 class="track-order-text1 mb-0"><strong>Hi,</strong> <?= $trackItems2->client_name ?? $trackItems2->billing_name ?></h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">                        
            <p class="text-right track-order-text2"><strong>Invoice Number :</strong> <?= $trackItems2->inv_code ?? null ?></p>
            <p class="text-right track-order-text2 mb-0"><strong>Order Date :</strong> <?= date('d M Y', strtotime( $trackItems2->created ) ) ?> </p>
            </div>
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                   <p class="text-center track-order-text2"><strong>Order Status :</strong> 
                   <?php if($trackItems2->status=='1') { echo 'Order Confirmed'; } 
                   else if($trackItems2->status=='2') { echo 'Order Shipped'; } else if($trackItems2->status=='3') { echo 'Order Delivered'; } 
                   else if($trackItems2->status=='4') { echo 'Order Cancelled'; }  else if($trackItems2->status=='5') { echo 'Order in Process'; } ?></p>

</div>
        
    </div>
</div> 

<?php 
}
else if( isset( $orderInfo ) && !empty( $orderInfo ) )
{
    
?>
<div class="light-gray-bg p-3 mt-4 border">
    <div class="row align-items-center">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
            <h4 class="track-order-text1 mb-0"><strong>Hi,</strong> <?= $orderInfo->client_name ?? $orderInfo->billing_name ?></h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">                        
            <p class="text-right track-order-text2"><strong>Invoice Number :</strong> <?= $orderInfo->inv_code ?? null ?></p>
            <p class="text-right track-order-text2 mb-0"><strong>Order Date :</strong> <?= date('d M Y', strtotime( $orderInfo->created ) ) ?> </p>
        </div>
    </div>
</div>  

<?php 
} else {  ?>

<div class="light-gray-bg p-3 mt-4 border">
    <div class="row align-items-center">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
            <h4 class="track-order-text1 mb-0"> No Orders found </h4>
        </div>
    </div>
</div>  
<?php } ?>