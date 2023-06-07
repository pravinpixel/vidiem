<style>
    h1 {
        margin-top: -5px;
    }
</style>

<div style="border:1px solid black;">
    <div class=" inCon">
        <div>
            <div class=" inCon">
                <div style="float:left;">
                    <h1 style="color:#00BFFF;"><img src="<?= base_url('assets/front-end/images/logo.png') ?>" style="display:block; margin:4px auto 0 auto" /></h1>
                </div>
                <div style="float:left;">
                    <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                        <li style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road, Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA.
                            | <span style="list-style:none;line-height:28px; display:inline-block;">Phone</span> : &nbsp; 044-6635 6635 / 77110 06635 | Website</span> : &nbsp; http://vidiem.in/
                            | GST NO</span> : &nbsp; 33AAACM6280D1ZT </li>
                    </ul>
                </div>

                <p style="clear:both;"></p>
                <div class="header_bottom" style="width:100%;">
                    <div style="width:100%;float:right;">
                        <h1 style="color:#000000;">PROFORMA INVOICE</h1>

                        <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;">Order Date:&nbsp; <?= date("d-M-Y", strtotime(@$order_data['created'])) ?>
                            | Order No. :&nbsp;<?= @$order_data['inv_code'] ?> </h3>

                        <div class="detail" style="float:left; width:50%;">

                            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;">Billing Address</h3>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; <?= @$order_data['billing_name'] ?>
                                </li>
                                <?php
                                if (!empty($order_data['billing_company_name'])) {

                                ?>
                                    <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; <?= @$order_data['billing_company_name'] ?></li>
                                <?php } ?>

                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; <?= @$order_data['billing_address'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; <?= @$order_data['billing_city'] . '-' . $order_data['billing_zip'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; <?= @$order_data['billing_state'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; <?= @$order_data['billing_country'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; <?= @$order_data['billing_mobile_no'] ?>
                                </li>
                            </ul>
                        </div>

                        <div class="contact" style="float:left; width:49%;">

                            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">Shipping Address</h3>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; <?= @$order_data['delivery_name'] ?>
                                </li>
                                <?php
                                if (!empty($order_data['delivery_company_name'])) {
                                ?>
                                    <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; <?= @$order_data['delivery_company_name'] ?></li>
                                <?php } ?>

                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; <?= @$order_data['delivery_address'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; <?= @$order_data['delivery_city'] . '-' . $order_data['delivery_zip'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; <?= @$order_data['delivery_state'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; <?= @$order_data['delivery_country'] ?>
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; <?= @$order_data['delivery_mobile_no'] ?>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="form" style="width:100%;">

                        <table style="width:100%; padding:20px 0 10px 0;">
                            <tr>
                                <td style="width:30%">
                                    <img src="<?= base_url('uploads/customizeimg/' . $basiciteminfo['basecolorpath']) ?>" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
                                </td>
                                <td style="width:85%">
                                    <table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
                                        <tbody>
                                            <tr>
                                                <td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
                                                <td style="border-bottom:1px solid #CCC;"><strong><?= $basiciteminfo['cart_code'] ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Body Design</td>
                                                <td><?= $basiciteminfo['basetitle'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Color</td>
                                                <td><?= $basiciteminfo['bc_title'] ?></td>
                                                <td><?= $basiciteminfo['basecolorprice'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Selected Jars</td>
                                                <td><?= $jar_count ?></td>
                                                <td>Price Breakup Below</td>
                                            </tr>
                                            <tr>
                                                <td>Motor Power</td>
                                                <td><?= $basiciteminfo['motorname'] ?></td>
                                                <td><?= $basiciteminfo['motorprice'] ?></td>
                                            </tr>
                                            <?php
                                            if ($basiciteminfo['canvas_text'] != '') {

                                            ?>
                                                <tr>
                                                    <td> Personalised message </td>
                                                    <td><?= $basiciteminfo['canvas_text'] ?></td>
                                                    <td><?= $basiciteminfo['textprice'] ?></td>
                                                </tr>
                                            <?php }
                                            if ($basiciteminfo['occasion_text'] != '') {
                                            ?>
                                                <tr>
                                                    <td>Gift Occasion</td>
                                                    <td><?= $basiciteminfo['occasion_text'] ?></td>
                                                </tr>
                                            <?php }
                                            if ($basiciteminfo['message_text'] != '') {
                                            ?>
                                                <tr>
                                                    <td>Gift Box Message</td>
                                                    <td><?= $basiciteminfo['message_text'] ?></td>
                                                </tr>
                                            <?php }
                                            if ($basiciteminfo['package_id'] != '' && !empty($basiciteminfo['package_id'])) {
                                            ?>
                                                <tr>
                                                    <td> Gift Wrapping Preference </td>
                                                    <td><?= $basiciteminfo['packagename'] ?></td>
                                                    <td><?= $basiciteminfo['packageprice'] ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                    <?php
                                    if (count($jarinfo) > 0) {
                                    ?>
                                        <table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 2px;">
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
                                                foreach ($jarinfo as $jar) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="<?= base_url(" uploads/customizeimg/jar/" . $jar['jarimgpath']) ?>" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60">
                                                            <br />
                                                            <span><?= $jar['capacityname'] . '|' . $jar['typeofjarname'] . '|' . $jar['typeofhandlename'] . '|' . $jar['typeoflidname'] ?>

                                                        </td>
                                                        <td><?= $jar['jarname'] ?></td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            <?= $jar['qty'] ?> Jars
                                                        </td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            Rs.<?= number_format($jar['price']) ?>
                                                        </td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            Rs. <?= number_format($jar['qty'] * $jar['price']) ?>
                                                        </td>
                                                    </tr>
                                            <?php  }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="width: 30%;"></td>
                                                <td>
                                                    <table border="0" cellspacing="5" style="width:600px;border:1px solid #CCC;margin-bottom:2px;padding:2px;font-size:11px;">

                                                        <tr>
                                                            <td>
                                                                <span style="color:#ff0000;font-size:12px;"><strong>Warranty Information</strong>
                                                                </span>
                                                                <br><br>
                                                                - 2 Years Warranty on Product <br>
                                                                - 5 Years Warranty on Motor <br>
                                                                <span style="color:#ff0000;font-size:10px;">
                                                                    <i>(For Domestic Purpose Only)</i>
                                                                    <br>
                                                                    Non Returnable / No Cancellation in all vidiem by you orders
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>

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
                                <th style="text-align:right;width: 200px;">SubTotal + GST 18% Included</th>
                                <th style="padding:10px 0;text-align:right;">
                                    <b>Rs. <?= number_format($order_data['sub_total'], 2, '.', '') ?></b>
                                </th>
                            </tr>
                            <!-- <tr>
                                <td></td>
                                <td></td>
                                <th style="text-align:right;">GST18%</th>
                                <th style="padding:10px 0;text-align:right;">
                                    <b>Rs. <?= number_format($order_data['tax'], 2, '.', '') ?></b>
                                </th>
                            </tr> -->

                            <tr>
                                <td></td>
                                <td></td>
                                <th style="text-align:right;">Package Price</th>
                                <th style="padding:10px 0;text-align:right;width:140px;"><b>Rs. <?= number_format($order_data['packageprice'], 2, '.', '') ?></b></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <th style="text-align:right;font-size:14px;">TOTAL</th>
                                <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. <?= number_format($order_data['amount'], 2, '.', '') ?></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.| If you have any questions about this invoice, please write us to care@vidiem.in </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>