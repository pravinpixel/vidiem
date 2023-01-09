<html>
  <head>
  <script>
    function submitPayuForm() {
      var payuForm = document.forms.payuForm;
          payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
    <div id="divLoading" class="show"> 
    </div>
    <br/>
    <form action="<?php echo $pay['action']; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $pay['MERCHANT_KEY'] ?>" />
      <input type="hidden" name="hash" value="<?php echo $pay['hash'] ?>"/>
      <input type="hidden" name="txnid" value="<?= @$PaymentData['txnid'];?>" />
      <input type="hidden" name="amount" value="<?= @$PaymentData['amount'];?>" />
      <input type="hidden" name="firstname" value="<?= @$PaymentData['firstname'];?>" />
      <input type="hidden" name="email" value="<?= @$PaymentData['email'];?>" />
      <input type="hidden" name="phone" value="<?= @$PaymentData['phone'];?>" />
      <input type="hidden" name="productinfo" value="<?= @$PaymentData['productinfo'];?>" />
      <input type="hidden" name="surl" value="<?= @$PaymentData['surl'];?>" />
      <input type="hidden" name="furl" value="<?= @$PaymentData['furl'];?>" />
      <input type="hidden" name="udf1" value="<?= @$PaymentData['udf1'];?>" />
      <input type="hidden" name="service_provider" value="payu_biz" size="64" />
    </form>
    <style>
      #divLoading
{
    display : block;
}
#divLoading.show
{
    display : block;
    position : fixed;
    z-index: 100;
    background-image : url('http://gifimage.net/wp-content/uploads/2017/09/animated-gif-loading-6.gif');
    background-color:#666;
    opacity : 0.4;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
}
#loadinggif.show
{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 101;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
}
div.content {
   width : 1000px;
   height : 1000px;
}
    </style>
  </body>
</html>