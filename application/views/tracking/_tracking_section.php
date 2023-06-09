<ul class="track-order">
    
    <li <?= ((isset($trackingDetails[1]) && !empty( $trackingDetails[1])) || (isset($trackingDetails[2]) && !empty( $trackingDetails[2]) ) ||  (isset($trackingDetails[5]->created_at) && !empty( $trackingDetails[5]->created_at))) ? 'class="active"' : '' ?>>
        <span>1</span>
        <h5>Order Accepted</h5>
        <?= (isset($trackingDetails[1]->created_at) && !empty( $trackingDetails[1]->created_at) ) ? '<p>on '.date('d M Y H:i A', strtotime($trackingDetails[1]->created_at)).'</p>' : '' ?>
        <?= (isset($trackingDetails[1]->notes) && !empty( $trackingDetails[1]->notes) ) ? '<p style="margin: 0 20px;">'.$trackingDetails[1]->notes.'</p>' : '' ?>
    </li>
    <li <?= ((isset($trackingDetails[5]) && !empty( $trackingDetails[5]) )  || (isset($trackingDetails[2]) && !empty( $trackingDetails[2]) ))? 'class="active"' : '' ?>>
        <span>2</span>
        <h5>In Production</h5>
        <?= (isset($trackingDetails[5]->created_at) && !empty( $trackingDetails[5]->created_at) ) ? '<p>on '.date('d M Y H:i A', strtotime($trackingDetails[5]->created_at)).'</p>' : '' ?>
        <?= (isset($trackingDetails[5]->notes) && !empty( $trackingDetails[5]->notes) ) ? '<p style="margin: 0 20px;">'.$trackingDetails[5]->notes.'</p>' : '' ?>
    </li>
    <li <?= (isset($trackingDetails[2]) && !empty( $trackingDetails[2]) ) ? 'class="active"' : '' ?>>
        <span>3</span>
        <h5>Ready for Dispatch</h5>
        <?= (isset($trackingDetails[2]->created_at) && !empty( $trackingDetails[2]->created_at) ) ? '<p>on '.date('d M Y H:i A', strtotime($trackingDetails[2]->created_at)).'</p>' : '' ?>
        <?= (isset($trackingDetails[2]->notes) && !empty( $trackingDetails[2]->notes) ) ? '<p style="margin: 0 20px;">'.$trackingDetails[2]->notes.'</p>' : '' ?>
        <?= (isset($trackingDetails[2]->tracking) && !empty( $trackingDetails[2]->tracking) ) ? '<div style="margin-top:10px;"> Tracking No:</div><b>'.$trackingDetails[2]->tracking.'</b>' : '' ?>
        <?= (isset($trackingDetails[2]->courier_name) && !empty( $trackingDetails[2]->courier_name) ) ? '<div style="margin-top:10px;"> Courier:</div><b>'.$trackingDetails[2]->courier_name.'</b>' : '' ?>

    </li>
  
    <li <?= (isset($trackingDetails[3]) && !empty( $trackingDetails[3]) ) ? 'class="active"' : '' ?>>
        <span>4</span>
        <h5>Delivered</h5>
        <?= (isset($trackingDetails[3]->created_at) && !empty( $trackingDetails[3]->created_at) ) ? '<p>on '.date('d M Y H:i A', strtotime($trackingDetails[3]->created_at)).'</p>' : '' ?>
        <?= (isset($trackingDetails[3]->notes) && !empty( $trackingDetails[3]->notes) ) ? '<p style="margin: 0 20px;">'.$trackingDetails[3]->notes.'</p>' : '' ?>
       <!-- <?= (isset($trackingDetails[2]->tracking) && !empty( $trackingDetails[2]->tracking) ) ? '<div style="margin-top:10px;"> Tracking No: </div><b>'.$trackingDetails[2]->tracking.'</b>' : '' ?>
        <?= (isset($trackingDetails[2]->courier_name) && !empty( $trackingDetails[2]->courier_name) ) ? '<div style="margin-top:10px;"> Courier:</div><b>'.$trackingDetails[2]->courier_name.'</b>' : '' ?>
    -->
    </li>
</ul>