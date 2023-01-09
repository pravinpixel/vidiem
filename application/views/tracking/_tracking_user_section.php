<?php 
if( isset( $orderInfo ) && !empty( $orderInfo ) ) {
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