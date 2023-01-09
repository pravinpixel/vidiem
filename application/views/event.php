<?php include('container/header.php'); ?>

<section class="ban-next light-gray-bg pb-0">
	<div class="container clearfix">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Events</h1>
				<h2 class="pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">sponsorship, recognition<br/>and Partners</h2>
			</div>
		</div>
	


<div class="bgPro eventPageFul clearfix">
		<div class="row eventPage" id="myList">
		<?php if(!empty($eventsss)){
				    foreach ($eventsss as $info) { ?>
			<div class="col-sm-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
				<a href="<?php echo base_url('event/'.$info['id']); ?>">
					<div class="evImg">
						<img src="<?= base_url('uploads/event/'.$info['image']); ?>" alt="event" class="img-fluid" />
					</div>
					<div class="evCon">
						<p class="dateOfEvent"><?= $info['eventdate']; ?></p>
						<h4 class="eventTitleName"><?= $info['title']; ?></h4>
						<p class="sponDetEv">
							<?= $info['content']; ?>
						</p>
						<i class="lni lni-arrow-right"></i>
					</div>
				</a>
			</div>
          <?php } } else { ?>
           	<h4>No Data Available...</h4>
           <?php } ?>
		</div>
		<div class="row justify-content-center">
		<div class="col-sm-12 col-md-6 col-lg-3">
			<?php if(!empty($eventsss)){?>
		<a id="loadMore" class="red-btn">Older Posts</a>
		<?php } ?>
		</div>
		</div>
</div>

</div>
<div class="container-fluid">
<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="event-bottom-text" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Recognition</h1>
			</div>
		</div>
</div>
</section>

<?php require_once('container/footer.php'); ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
	$(document).ready(function () {
    size_li = $("#myList li").size();
    x=3;
    $('#myList li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('#myList li:lt('+x+')').show();
         $('#showLess').show();
        if(x == size_li){
            $('#loadMore').hide();
        }
        if(x == 3){
            $('#loadMore').hide();
        }
    });
    $('#showLess').click(function () {
        x=(x-5<0) ? 3 : x-5;
        $('#myList li').not(':lt('+x+')').hide();
        $('#loadMore').show();
         $('#showLess').show();
        if(x == 3){
            $('#showLess').hide();
        }
    });
});
</script>
<style>
	#myList li{ display:none;
}

</style>