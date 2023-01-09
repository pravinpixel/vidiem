<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/combinebasetext/save/'); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/combinebasetext/update/'.$basedataitems->base_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  <style type="text/css">
	.product-image{
		max-width:500px;
		margin: 0 auto;
		position: relative;
	}
	.product-image-text{
		position: absolute;
		font-size: 13px;
		left: 0px;
		top: 0px;
		color: #FFF;
		background: rgba(0,0,0,0.5);
	}
  </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Combine Base Customize Text
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/combinebasetext'); ?>">Combine Base Customize Text</a></li>
        <li class="active"><?php echo $action; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
       <?php if(!empty($this->session->flashdata('msg'))){ ?>
    <div class="alert <?= $this->session->flashdata('class'); ?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa <?= $this->session->flashdata('icon'); ?>"></i> Alert!</h4>
      <?= $this->session->flashdata('msg'); ?>
    </div>
    <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $action; ?> Combine Base Customize Text</h3>
            </div>	
		  
		  <div class="box-body">
            <div class="row">
			   <div class="col-md-12 col-sm-12 tpm-bx">
			
                  <div class="col-md-3">
				  <label for="basetitle" class="col-sm-12">Image</label>
                      <img src="<?= base_url('uploads/customizeimg/'.$basedataitems->basepath); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
           
			
		  	   <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Title<span class="red">:</span></label><?php echo $basedataitems->basetitle;?>              
               </div>
			    <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Code<span class="red">:</span></label><?php echo $basedataitems->code;?>             
               </div>
			    <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Price<span class="red">:</span></label> <?php echo $basedataitems->price;?>             
               </div>
			   
			  </div>
			   </div>
			   <div class="row">
			<div class="col-md-6 col-sm-6">
			  <form class="form-horizontal" id="frmbasejar" name="frmbasejar" method="post" onsubmit="return false;"  enctype="multipart/form-data">
					
				<h4 class="box-title" style="margin-top: 30px;">Text Position</h4>
				<div class="form-group">
                  <label for="desktopleft" class="col-sm-2 control-label">Left (%)</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="desktopleft" name="desktopleft" value="<?php echo !empty($dataitems->desktopleft)?$dataitems->desktopleft:'0'; ?>">
                  </div>
                </div>
				<div class="form-group">
                  <label for="desktoptop" class="col-sm-2 control-label">Top (%)</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="desktoptop" name="desktoptop" value="<?php echo !empty($dataitems->desktoptop)?$dataitems->desktoptop:'0'; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="desktop_vertical" class="col-sm-2 control-label">Vertical (deg)</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="desktop_vertical" name="desktop_vertical" value="<?php echo !empty($dataitems->desktop_vertical)?$dataitems->desktop_vertical:'0'; ?>">
                  </div>
                </div>
				<div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo !empty($dataitems->price)?$dataitems->price:'0'; ?>">
                  </div>
                </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12" style="margin-top:24px;" align="center">
				    
					 
					   <button id="btninsert" onclick="frmsubmt('<?php echo $actionurl; ?>','frmbasejar');" class="btn btn-success">Submit</button>
                 </div>
                    </form>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="product-image">
					<img src="<?= base_url('uploads/customizeimg/'.$basedataitems->basepath); ?>" alt="" class="img-responsive"/>
					<div class="product-image-text" style="left:<?php echo $dataitems->desktopleft;?>%;top:<?php echo $dataitems->desktoptop;?>%;">Lorem Ipsum is simply dummy text of the</div>
				</div>
			</div>
		  </div>
		  		</div>
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  
  
  
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?= LAYOUT_URL; ?>plugins/multiselect/js/jquery.multi-select.js"></script>
<script src="<?= LAYOUT_URL; ?>plugins/multiselect/js/jquery.quicksearch.min.js"></script>

<script>

  $(document).ready(function(){
	  
	  $("#desktopleft").keyup(function(){
		 // alert($(this).val());
		  $('.product-image-text').css('left',$(this).val()+"%");
	  });
	  $("#desktoptop").keyup(function(){
		  $('.product-image-text').css('top',$(this).val()+"%");
	  });
    
  // run pre selected options
  //$('').multiSelect();
  $('.divdefault_jar_id #select-all').click(function(){
  $('#default_jar_id').multiSelect('select_all');
  return false;
});
$('.divdefault_jar_id #deselect-all').click(function(){
  $('#default_jar_id').multiSelect('deselect_all');
  return false;
});
  $('#default_jar_id').multiSelect({
  selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"12\"'><div class='custom-header'>Selectable items</div>",
  selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"4\"'><div class='custom-header'>Selection items</div>",

  afterInit: function(ms){
    var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
    .on('keydown', function(e){
      if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
});



  $('.divexculde_jar_id #select-all').click(function(){
  $('#exculde_jar_id').multiSelect('select_all');
  return false;
});
$('.divexculde_jar_id #deselect-all').click(function(){
  $('#exculde_jar_id').multiSelect('deselect_all');
  return false;
});
  $('#exculde_jar_id').multiSelect({
  selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"12\"'>",
  selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"4\"'>",
  afterInit: function(ms){
    var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
    .on('keydown', function(e){
      if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
});
  
});

//console.log($($('[name="motor_id[]"]')["1"]).next().find(".errorcls").text("dfsfdsfdsf  dfsf ds"));
//console.log($($('[name="price[]"]')["1"]).next("span").text("dfsfdsfdsf  dfsf ds"));

	  
function frmsubmt(url,frmname)
{
		// alert("ggg");
		 
		    var m_data = new FormData();
            var formdatas = $("#" + frmname).serializeArray();
			console.log(formdatas);
			$.each(formdatas, function(key, value) {
                m_data.append(value.name, value.value);
            });
			
			
			
				//alert("fff");
          	//	alert("fff");
					var fileInput = $('input[type="file"][name="basepath[]"]');
					
				  if(fileInput.length>0){
					  for(var i=0;i<fileInput.length-1;i++){
					if (fileInput[i]) {
						
						if (fileInput[i].files.length == 0) {							
							var f = new File([""], "empty.jpg", {type: "image/jpeg"});
							m_data.append('basepath[]',f);
						} else {
						
							//for (var i = 0; i < fileInput.files.length; i++) {
							//	message += "<br /><b>" + (i+1) + ". file</b><br />";
								var file = fileInput[i].files[0];
								m_data.append('basepath[]', file);                       
							//}
						}
					}
					else{
						
					}
					}				
				  }
		
            $.ajax({
                url:url,
                type: "POST",
				data : m_data,
				dataType :"json",
				processData: false,
				contentType: false,
                success:function(data)
                {
				
					if(data.status==0)
					{
						$.each(data.error_data, function(key,value) {
						$temperrind=value.errorindex.split(",");	
							$.each($temperrind,function(errind,errindval) {
								//$($('[id="'+key+'"]')[errindval]).next().find(".errorcls").text(value.error);
							$($('[id="'+key+'"]')[errindval]).siblings("span").text(value.error);
							});
						}); 
					}
					else{
					if(data.status==1)
					{
						location.href=data.action_url;
						
					}
						
					}
                    
                }
            });
   


}	

	  
 </script>