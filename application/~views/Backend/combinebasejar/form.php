<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/combinebasejar/save/'.$basedataitems->bm_color_id); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/combinebasejar/update/'.$basedataitems->bm_color_id.'/'.$basedataitems->base_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Combine Base Jar
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/combinebasejar'); ?>">Combine Base Jar</a></li>
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
              <h3 class="box-title"><?php echo $action; ?> Combine Base Jar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			   <div class="col-md-12 col-sm-12 tpm-bx">
			
                  <div class="col-md-3">
				  <label for="basetitle" class="col-sm-12">Image</label>
                      <img src="<?= base_url('uploads/customizeimg/'.$basedataitems->basepath); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
           
			
		  	   <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Title<span class="red">:</span></label><?php echo $basedataitems->title;?>              
               </div>
			    <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Code<span class="red">:</span></label><?php echo $basedataitems->code;?>             
               </div>
			    <div class="col-md-3">
                  <label for="basetitle" class="col-sm-12">Base Price<span class="red">:</span></label> <?php echo $basedataitems->price;?>             
               </div>
			   
			  
			   </div>
			
			  <form class="form-horizontal" id="frmbasejar" name="frmbasejar" method="post" onsubmit="return false;"  enctype="multipart/form-data">
					
					<div class="col-md-6 divdefault_jar_id">
                  <label for="inputCategory" class="col-sm-12 text-left">Choose default Jars *</label>
                  <div class="col-md-12 col-sm-12">
				  <a href='#' id='select-all'>select all</a>
					<a href='#' id='deselect-all'>deselect all</a>	
                  <select data-skip-name="true" data-name="default_jar_id[]" class="selectpicker required js-states form-control newcust-select " multiple data-live-search="true" name="default_jar_id[]" id="default_jar_id"> 
					<option value=""></option>				  
                      <?php if(!empty($jar)){ 
                          foreach($jar as $info){	
						  $selcls="";
							$defaultjars=explode(",",$dataitems->default_jar_ids);
						if(in_array($info['id'],$defaultjars))
						{
							$selcls=" selected ";
						}
						  
							  ?>
                          <option <?= $selcls; ?>  value="<?= $info['id'] ?>"  ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                	<span class="errorcls"></span>
                    <?= form_error('default_jar_id'); ?>
                  </div>
                </div>
				
				<div class="col-md-6 divexculde_jar_id">
                  <label for="inputCategory" class="col-sm-12 text-left">Choose Exculde Jars *</label>
                  <div class="col-md-12 col-sm-12">
				  <a href='#' id='select-all'>select all</a>
					<a href='#' id='deselect-all'>deselect all</a>	
                  <select data-skip-name="true" data-name="exculde_jar_id[]" class="selectpicker required js-states form-control newcust-select " multiple data-live-search="true" name="exculde_jar_id[]" id="exculde_jar_id"> 
					<option value=""></option>				  
                      <?php if(count($jar)>0){ 
					 
                          foreach($jar as $info){
							  $selcls="";
							$excludejars=explode(",",$dataitems->exclude_jar_id);
						if(in_array($info['id'],$excludejars))
						{
							$selcls=" selected='selected' ";
						}
							  
							
							  ?>
                          <option <?= $selcls; ?>  value="<?= $info['id'] ?>"  ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                	<div class="errorcls"></div>
                    <?= form_error('exculde_jar_id[]'); ?>
                  </div>
                </div>
					
				
                		
						
                        <div class="clearfix"></div>
                        <div class="col-md-12" style="margin-top:24px;" align="center">
				    
					 
					   <button id="btninsert" onclick="frmsubmt('<?php echo $actionurl; ?>','frmbasejar');" class="btn btn-success">Submit</button>
                 </div>
                    </form>
			
			
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