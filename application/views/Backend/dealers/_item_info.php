<style>
h1 {
    margin-top: -5px;
}

.container {
    width: 100%;
}
</style>
<div style="">
    <div class="container inCon">
        <div style="float:left;">
            <h1 style="color:#00BFFF;"><img src="<?= base_url('assets/front-end/images/logo.png') ?>"
                    style="display:block; margin:0px auto 0 auto" /></h1>
        </div>
        <?php 
        $jar_count = 0;
        $jar_amount = 0;
            if( isset( $jarInfo ) && !empty( $jarInfo ) ) {
                foreach ($jarInfo as $key => $value) {
                    $jar_amount += $value['qty'] * $value['price'];
                    $jar_count += $value['qty'];
                }
            }
        ?>
        <p style="clear:both;"></p>
        <div class="header_bottom" style="width:100%; padding:10px 0;">

            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">

                <li style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E84;"><strong>Order Date</span>
                        :&nbsp;
                        &nbsp;&nbsp;<?= date("d-M-Y", strtotime(@$order_data->created)) ?> &nbsp;&nbsp;|
                        &nbsp;&nbsp;Order No. : &nbsp;<?= @$order_data->inv_code ?? $order_data->order_no  ?></strong></li>
            </ul>

            <div class="detail" style="float:left; width:50%; margin-top:-15px;border-left:1px #ffffff solid;">
                <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                    <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Billing Address </h3>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :
                        <?= @$order_data->billing_name ?>
                    </li>
                    <?php
                    if(!empty($order_data->billing_company_name)){ ?>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :
                        <?= @$order_data->billing_company_name ?></li>
                    <?php } ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> :
                        <span style="width:65%;display:inline-flex;"><?= @$order_data->billing_address ?>,
                            <?= @$order_data->billing_address2 ?>
                        </span></li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">City</span> :
                        <?= @$order_data->billing_city.'-'.$order_data->billing_zip ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">State</span> :
                        <?= @$order_data->billing_state ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Country</span> :
                        <?= @$order_data->billing_country ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Mobile</span> :
                        <?= @$order_data->billing_mobile_no ?>
                    </li>
                </ul>
            </div>
            <div class="logo" style="float:left; width:35%; "></div>
            <div class="contact" style="float:right; width:50%; margin-top:-15px;">


                <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                    <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Shipping Address</h3>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :
                        <?= @$order_data->delivery_name ?>
                    </li>
                    <?php 
                    if(!empty($order_data->delivery_company_name)){ ?>
                    <li style="font-size:14px;">
                        <span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :
                        <?= @$order_data->delivery_company_name ?></li>
                    <?php 
                    } ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> :
                        <span style="width:65%;display:inline-flex;">
                            <?= @$order_data->delivery_address.','.@$order_data->delivery_address2 ?>
                        </span></li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">City</span> :
                        <?= @$order_data->delivery_city.'-'.$order_data->delivery_zip ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">State</span> :
                        <?= @$order_data->delivery_state ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Country</span> :
                        <?= @$order_data->delivery_country ?>
                    </li>
                    <li style="font-size:14px;"><span
                            style="width:22%;list-style:none;line-height:20px; display:inline-block;">Mobile</span> :
                        <?= @$order_data->delivery_mobile_no ?>
                    </li>
                </ul>

            </div>
        </div>
        <div class="form" style="width:100%;">
                   
            <table style="width:100%; padding:20px 0 40px 0;border:1px solid #ddd">
                <tr>
                    <td style="width:15%">
                        <img src="<?= base_url('uploads/customizeimg/'.$basicItemInfo['basecolorpath']) ?>"
                            style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
                    </td>
                    <td style="width:85%;">
                        <table border="0" cellpadding="7" cellspacing="0"
                            style="width:600px;border:1px solid #CCC; margin-bottom: 20px;margin-top:10px;">
                            <tbody>
                                <tr>
                                    <td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
                                    <td style="border-bottom:1px solid #CCC;">
                                        <strong><?= $basicItemInfo['cart_code'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Body Design</td>
                                    <td><?= $basicItemInfo['basetitle'] ?></td>
                                </tr>
                                <tr>
                                    <td>Color</td>
                                    <td><?= $basicItemInfo['bc_title'] ?></td>
                                    <td><?= $basicItemInfo['basecolorprice'] ?></td>
                                </tr>
                                <tr>
                                    <td>Selected Jars</td>
                                    <td><?= $jar_count ?></td>
                                    <td> Rs.<?= number_format($jar_amount, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Motor Power</td>
                                    <td><?= $basicItemInfo['motorname'] ?></td>
                                    <td><?= $basicItemInfo['motorprice'] ?></td>
                                </tr>
                                <?php 
                                if($basicItemInfo['canvas_text']!='') { ?>
                                <tr>
                                    <td> Personalised message </td>
                                    <td><?= $basicItemInfo['canvas_text'] ?></td>
                                    <td><?= $basicItemInfo['textprice'] ?></td>
                                </tr> 
                                <?php 
                                }
                                if($basicItemInfo['occasion_text']!='') {

                                ?>
                                <tr>
                                    <td>Gift Occasion</td>
                                    <td><?= $basicItemInfo['occasion_text'] ?></td>
                                </tr>
                                <?php
                                }
                                if($basicItemInfo['message_text']!='') {

                                ?>
                                <tr>
                                    <td>Gift Box Message</td>
                                    <td><?= $basicItemInfo['message_text'] ?></td>
                                </tr> 
                                <?php 
                                }
                                if($basicItemInfo['package_id']!='' && !empty($basicItemInfo['package_id'])) {
                                ?>
                                <tr>
                                    <td> Gift Wrapping Preference </td>
                                    <td><?= $basicItemInfo['packagename'] ?></td>
                                    <td><?= $basicItemInfo['packageprice'] ?></td>
                                </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table> 
                        <?php 

                        if(count($jarinfo)>0) {

                        ?>
                        <table border="0" cellpadding="7" cellspacing="0"
                            style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th style="border-bottom:1px solid #CCC;"></th>
                                    <th style="border-bottom:1px solid #CCC;">Jar Information</th>
                                    <th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
                                    <th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
                                    <th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($jarinfo as $jar) {
                                    ?>
                                <tr>
                                    <td>
                                        <img src="<?= base_url(" uploads/customizeimg/jar/".$jar->jarimgpath) ?>" alt=""
                                            style="margin: 0; border: 0; padding: 0; display: block;" width="60"
                                            height="60">
                                        <br />
                                        <span><?= $jar->capacityname.'|'.$jar->typeofjarname.'|'.$jar->typeofhandlename.'|'.$jar->typeoflidname ?>

                                    </td>
                                    <td><?= $jar->jarname ?></td>
                                    <td style="text-align:center;color:#F7000A;">
                                        <?= $jar->qty ?> Jars
                                    </td>
                                    <td style="text-align:center;color:#F7000A;">
                                        Rs.<?= number_format($jar->price) ?>
                                    </td>
                                    <td style="text-align:center;color:#F7000A;">
                                        Rs. <?= number_format($jar->qty*$jar->price) ?>
                                    </td>
                                </tr> 
                                <?php 
                                }
                                }

                                ?>

                                </tbody>
                        </table>

                        <table border="0" cellspacing="5"
                            style="width:600px;border:1px solid #CCC;margin-bottom:10px;padding:10px;font-size:11px;">

                            <tr>
                                <td><span style="color:#ff0000;font-size:12px;"><strong>Warranty
                                            Information</strong></span><br><br>
                                    - 2 Years Warranty on Product <br> - 5 Years Warranty on Motor <br> <span
                                        style="color:#ff0000;font-size:10px;"><i>(For Domestic Purpose Only)</i></span>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            </td>
            </tr>
            </table>

            <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs.
                            <?= number_format($order_data->sub_total,2,'.','') ?></b></th>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">Package Price</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs.
                            <?= number_format($order_data->packageprice,2,'.','') ?></b></th>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;width:20%;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;width:20%;">Rs.
                       <?= number_format($order_data->amount,2,'.','') ?></th>
                </tr>

                <tr>
                    <td></td>
                    <td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.|
                        If you have any questions about this invoice, please write us to care@vidiem.in </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with
                            Vidiem</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>