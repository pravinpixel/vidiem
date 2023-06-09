<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Frequently Asked Question</h2>
	</div>
</section>
<div class="bgPro contactUs clearfix">
			<?php if(!empty($faq_cat)){ ?>
	<div class="container clearfix faqSet">
		<ul class="faqTab clearfix">
				<?php  $x=1; foreach ($faq_cat as $info) { 
				$items=$this->FunctionModel->Select('vidiem_faq_category',array('parent_id'=>$info['id'],'status'=>1));
         if(!empty($items)){
				?>
	        <li class="tab-link <?= ($x==1)?'current':''; ?>" data-tab="tab-<?= @$x; ?>">
	         <?= $info['title']; ?>
	        </li>
	         <?php $x++; } } ?>
	    </ul>
	    <?php $x=1;
	    foreach ($faq_cat as $info) {
	     $items=$this->FunctionModel->Select('vidiem_faq_category',array('parent_id'=>$info['id'],'status'=>1));
	      if(!empty($items)){
				?>
	    <div id="tab-<?= $x; ?>" class="tab-content ansQus clearfix <?= ($x==1)?'current':''; ?>">
	    	<h3>   <?= $info['title']; ?></h3>
	    	<ul class="qsSet">
	    		<?php foreach($items as $tmp){ ?>
	    		<li>
	    			<h4 class="question_trigger"><?= $tmp['question']; ?></h4>
	    			<div class="ans_section">
	    				<p><?= $tmp['content']; ?></p>
	    			</div>
	    		</li>
	    		<?php } ?>
	    	</ul>
	    </div>
	    <?php $x++; } } ?> 
	</div>
	<?php } ?>
</div>

<?php require_once('container/footer.php'); ?>