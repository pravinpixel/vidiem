<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/Combinebasecolor/save/'); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/Combinebasecolor/update/'.$basedataitems->base_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Combine Base Color
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/Combinebasecolor'); ?>">Combine Base Color</a></li>
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
              <h3 class="box-title"><?php echo $action; ?> Combine Base Color</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			<div class="base-color">
			 <div class="row">
			   <div class="col-md-12 col-sm-12">
			
                  <div class="col-md-3">
				  <label for="basetitle">Image</label>
                      <img src="<?= base_url('uploads/customizeimg/'.$basedataitems->basepath); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
           
			
		  	   <div class="col-md-3">
                  <label for="basetitle">Base Title<span class="red">:</span></label><?php echo $basedataitems->basetitle;?>              
               </div>
			    <div class="col-md-3">
                  <label for="basetitle">Base Code<span class="red">:</span></label><?php echo $basedataitems->code;?>             
               </div>
			    <div class="col-md-3">
                  <label for="basetitle">Base Price<span class="red">:</span></label> <?php echo $basedataitems->price;?>             
               </div>
			   </div>
			  </div>
			   </div>
			
			  <form class="form-horizontal" id="frmbasecolor" name="frmbasecolor" method="post" onsubmit="return false;"   enctype="multipart/form-data">
					
                
                        <div id="repeater">
                            <div class="repeater-heading col-md-12" align="center">
							<br>
                                <button type="button" onclick="insertrow();" class="btn btn-primary repeater-add-btn">Add base Color</button>
							<br><br>
                            </div>
                            <div class="clearfix"></div>
					 <?php 
						
					if(count($dataitems)>0) { 
					
				 foreach($dataitems as $data) { 
				 
				 
				 
				 $data=(object)$data;
				 
				 
				 ?>    		
						

					<input type="hidden" data-skip-name="true" data-name="bm_color_id[]" id="bm_color_id" name="bm_color_id[]" value="<?= set_value('bm_color_id',@$data->bm_color_id); ?>">
						
                            <div class="items" data-group="base_color">
                                <div class="item-content row">
				<div class="form-group">
				<div class="col-md-2">
                  <label for="inputCategory" class="col-sm-12 text-left">Color *</label>
                  <div class="col-md-12 col-sm-12">
                  <select data-skip-name="true" data-name="color_id[]" class="selectpicker required js-states form-control custome-select " data-live-search="true" name="color_id[]" id="color_id">
                      <option value="">Select color</option>
                      <?php if(!empty($color)){ 
                          foreach($color as $info){
							
							  ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('color_id', $info['id'] ,($info['id'] == $data->color_id ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
						<div class="errorcls"></div>
                    <?= form_error('color_id'); ?>
                  </div>
                </div>
				
				 <div class="col-md-2">
                  <label for="basepath" class="col-sm-12 text-left">Image</label>
                  <div class="col-sm-12">
                      <input type="file" class="form-control imgUpload"  data-skip-name="true" data-name="basepath[]"  id="basepath" name="basepath[]">
					  	<span></span>
                      <?= form_error('basepath[]'); ?>
					  <small>(image size should be upload: 1000 * 1000)</small>
					  <div class="errorcls"></div>
                    </div>
                   <div class="col-sm-12">
                      <img src="<?= base_url('uploads/customizeimg/basecolor/'.$data->basepath); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
					
                </div>
				
				 <div class="col-md-2">
                  <label for="title" class="col-sm-12 text-left">Title<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="title[]"  class="form-control" id="title" required name="title[]" value="<?= set_value('title',@$data->title); ?>">
					<div class="errorcls"></div>
                    <?= form_error('title'); ?>
                  </div>
                </div>
				
				
				 <div class="col-md-2">
                  <label for="price" class="col-sm-12 text-left">Price<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="price[]"  class="form-control" id="price" onkeypress="return isNumber(this.event);" required name="price[]" value="<?= set_value('price',@$data->price); ?>">
					<div class="errorcls"></div>
                    <?= form_error('price'); ?>
                  </div>
                </div>
				
				 <div class=" col-md-2">
                  <label for="sortby" class="col-sm-12 text-left">Sortby</label>
                  <div class="col-md-9 col-sm-9"> 
                    <input type="text" class="form-control"  data-skip-name="true" data-name="sortby[]"  id="sortby" onkeypress="return isNumber(this.event);" name="sortby[]" value="<?php echo $data->sortby; ?>">
					<div class="errorcls"></div>
                    <?= form_error('sortby'); ?>
                  </div>
				  <div class="col-md-2 col-sm-3">
				   <button id="remove-btn" onclick="deleterow($(this).parents('.items'),'<?php echo $data->bm_color_id; ?>','<?php echo $basedataitems->base_id; ?>');" class="btn btn-danger">Remove</button>
                </div>
                </div>
				</div>
				 </div>
				 </div>
						 <?php } 
					} else { ?>
					
					   <div class="items" data-group="base_color">
                                <div class="item-content row">
					<input type="hidden" data-skip-name="true" data-name="bm_color_id[]" id="bm_color_id" name="bm_color_id[]" value="">				
								
								
				<div class="form-group">
				<div class="col-md-2">
                  <label for="inputCategory" class="col-sm-12 text-left">Color *</label>
                  <div class="col-md-12 col-sm-12">
                  <select data-skip-name="true" data-name="color_id[]" class="selectpicker required js-states form-control custome-select " data-live-search="true" name="color_id[]" id="color_id">
                      <option value="">Select color</option>
                      <?php if(!empty($color)){ 
                          foreach($color as $info){
							
							  ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('color_id', $info['id'] ,($info['id'] == $data->color_id ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                	<div class="errorcls"></div>
                    <?= form_error('color_id'); ?>
                  </div>
                </div>
				
				 <div class="col-md-2">
                  <label for="basepath" class="col-sm-12 text-left">Image *</label>
                  <div class="col-sm-12">
                      <input type="file" class="form-control imgUpload"  data-skip-name="true" data-name="basepath[]"  id="basepath" name="basepath[]">
					  	<span></span>
                      <?= form_error('basepath[]'); ?>
					  <small>(image size should be upload: 1000 * 1000)</small>
					  <div class="errorcls"></div>
                    </div>
                   <div class="col-sm-12">
                      <img src="<?= base_url('uploads/customizeimg/'.$data->data); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
					
                </div>
				
				 <div class="col-md-2">
                  <label for="title" class="col-sm-12 text-left">Title<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="title[]"  class="form-control" id="title" required name="title[]" value="<?= set_value('title',@$data->title); ?>">
					<div class="errorcls"></div>
                    <?= form_error('title'); ?>
                  </div>
                </div>
				
				 <div class="col-md-2">
                  <label for="price" class="col-sm-12 text-left">Price<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="price[]"  class="form-control" id="price" onkeypress="return isNumber(this.event);" required name="price[]" value="<?= set_value('price',@$data->price); ?>">
						<div class="errorcls"></div>
                    <?= form_error('price'); ?>
                  </div>
                </div>
				
				 <div class=" col-md-2">
                  <label for="sortby" class="col-sm-12 text-left">Sortby</label>
                  <div class="col-md-9 col-sm-9">
                    <input type="text" class="form-control"  data-skip-name="true" data-name="sortby[]"  id="sortby" onkeypress="return isNumber(this.event);" name="sortby[]" value="<?= set_value('sortby',@$data->sortby); ?>">
						<div class="errorcls"></div>
                    <?= form_error('sortby'); ?>
                  </div>
				  <div class="col-md-2 col-sm-3">
				   <button id="remove-btn" onclick="deleterow($(this).parents('.items'),'','<?php echo $basedataitems->base_id; ?>');" class="btn btn-danger">Remove</button>
                </div>
                </div>
				</div>
				 </div>
				 </div>

					<?php	 } 

					?>		
							
                        </div>
								
						
                        <div class="clearfix"></div>
                        <div class="col-md-12" style="margin-top:24px;" align="center">
				    
					 
					   <button id="btninsert" onclick="frmsubmt('<?php echo $actionurl; ?>','frmbasecolor');" class="btn btn-success">Submit</button>
                 </div>
                    </form>
			
			
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  
  
 <div style="display:none;" >
 
  <div class="newitems" data-group="base_color">
                                <div class="item-content row">
					<input type="hidden" data-skip-name="true" data-name="bm_color_id[]" id="bm_color_id" name="bm_color_id[]" value="">				
								
								
				<div class="form-group">
				<div class="col-md-2">
                  <label for="inputCategory" class="col-sm-12 text-left">Color *</label>
                  <div class="col-md-12 col-sm-12">
                  <select data-skip-name="true" data-name="color_id[]" class="selectpicker required js-states form-control newcust-select " data-live-search="true" name="color_id[]" id="color_id">
                      <option value="">Select color</option>
                      <?php if(!empty($color)){ 
                          foreach($color as $info){
							
							  ?>
                          <option  value="<?= $info['id'] ?>"  ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                	<div class="errorcls"></div>
                    <?= form_error('color_id'); ?>
                  </div>
                </div>
				
				 <div class="col-md-2">
                  <label for="basepath" class="col-sm-12 text-left">Image</label>
                  <div class="col-sm-12">
                      <input type="file" class="form-control imgUpload"  data-skip-name="true" data-name="basepath[]"  id="basepath" name="basepath[]">
					  	<span></span>
                      <?= form_error('basepath[]'); ?>
					  <small>(image size should be upload: 1000 * 1000)</small>
					  <div class="errorcls"></div>
                    </div>
                   <div class="col-sm-12">
                      <img src="" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
					
                </div>
				
				 <div class="col-md-2">
                  <label for="title" class="col-sm-12 text-left">Title<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="title[]"  class="form-control" id="title" required name="title[]" value="">
					<div class="errorcls"></div>
                    <?= form_error('title'); ?>
                  </div>
                </div>
				
				 <div class="col-md-2">
                  <label for="price" class="col-sm-12 text-left">Price<span class="red">*</span></label>
                  <div class="col-md-12 col-sm-12">
                    <input type="text" data-skip-name="true" data-name="price[]"  class="form-control" id="price" onkeypress="return isNumber(this.event);" required name="price[]" value="">
						<div class="errorcls"></div>
                    <?= form_error('price'); ?>
                  </div>
                </div>
				
				 <div class=" col-md-2">
                  <label for="sortby" class="col-sm-12 text-left">Sortby</label>
                  <div class="col-md-9 col-sm-9">
                    <input type="text" class="form-control"  data-skip-name="true" data-name="sortby[]"  id="sortby" onkeypress="return isNumber(this.event);" name="sortby[]" value="">
						<div class="errorcls"></div>
                    <?= form_error('sortby'); ?>
                  </div>
				  <div class="col-md-2 col-sm-3">
				   <button id="remove-btn" onclick="deleterow($(this).parents('.items'),'','<?php echo $basedataitems->base_id; ?>');" class="btn btn-danger">Remove</button>
                </div>
                </div>
				</div>
				 </div>
				 </div>
  </div>
  
  
  
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  
<script>
var rowcnt="<?php echo count($dataitems) > 0 ? count($dataitems) : '1'; ?>";
  $(document).ready(function(){
          $('.custome-select').select2();
		  
		  $(".reset").click(function() {
			  $('input[type=text]').attr('value', ''); 
			  $("select").val('').trigger('change')
			  $('input:checkbox').iCheck('uncheck');
			  $('input:radio').iCheck('uncheck');
});

//console.log($($('[name="color_id[]"]')["1"]).next().find(".errorcls").text("dfsfdsfdsf  dfsf ds"));
//console.log($($('[name="price[]"]')["1"]).next("span").text("dfsfdsfdsf  dfsf ds"));



      });
	  
function frmsubmt(url,frmname)
{
		// alert("ggg");
		 
		    var m_data = new FormData();
            var formdatas = $("#" + frmname).serializeArray();
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
							//	$($('[name="'+key+'"]')[errindval]).next().find(".errorcls").text(value.error);
							//$($('[name="color_id[]"]')[errindval]).siblings("div").text(value.error);
							$($('[name="'+key+'"]')[errindval]).siblings("div").text(value.error);
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

function deleterow(objrow,bmid,bid)
{
	
	swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
	
	if(rowcnt>1)
	{	
	 
	if(bmid==""){	
	
		objrow.remove();
		rowcnt--;
		}
		else		
		{
			// alert("gg3");
			$.ajax({
                url:"<?php echo base_url('Admin/combinebasecolor/delete/') ?>"+bmid,
                type: "POST",
				data : "bid="+bid,
				dataType :"json",
				processData: false,				
                success:function(data)
                {
                  //objrow.remove();
				  //rowcnt--;  
				  if(data.status==1)
					{
						location.href=data.action_url;
						
					}
				  
				  
                }
            });		
		}
			
	}
  } else {
   
  }
});
	
	
}

function insertrow()
{
	  var repeater =  $('#frmbasecolor');	
	  var items = $(".newitems");
	   rowcnt++;
       addItem(items, rowcnt);
	   $('#repeater .newcust-select').select2();	
	   $(".imgUpload").on("change", function()
		{
		var x=$(this).parent().parent().find(".UploadImgPreview");
		var files = !!this.files ? this.files : [];
		if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		if (/^image/.test( files[0].type)){ // only image file
			var reader = new FileReader(); // instance of the FileReader
			reader.readAsDataURL(files[0]); // read the local file
			reader.onloadend = function(){ // set image data as background of div
				x.attr("src",this.result);
			}
		}
		});
	   
	   
}

var addItem = function (items, key) {
		var itemContent = items;
		var group = itemContent.data("group");
		var item = itemContent;
		var input = item.find('input,select');
		input.each(function (index, el) {
			var attrName = $(el).data('name');
			var skipName = $(el).data('skip-name');
			if (skipName != true) {
				$(el).attr("name", group + "[" + key + "]" + attrName);
			} else {
				if (attrName != 'undefined') {
					$(el).attr("name", attrName);
				}
			}
		})
		var itemClone = items;

		/* Handling remove btn */
		var removeButton = itemClone.find('.remove-btn');

		if (key == 0) {
			removeButton.attr('disabled', true);
		} else {
			removeButton.attr('disabled', false);
		}

		$("<div class='items'>" + itemClone.html() + "<div/>").appendTo(repeater);
	};
	  
 </script>