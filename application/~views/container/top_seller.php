<div class="top_sellers clearfix">
  <div class="ts_ctn">
    <?php  $top_sellers=$this->ProjectModel->FetchTopSeller(); ?>
    <p>Top Sellers</p>
    <ul><?php if(!empty($top_sellers)){
      foreach ($top_sellers as $info) { ?>
      <li><a href="<?= base_url('product/'.$info['slug']); ?>"><?= $info['name'];?></a></li>
      <?php } } ?>
    </ul>
  </div>
</div>