<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Vidiem - Using mask-image</title>
 
<style>
 .mainbox{ 
 border:1px solid #ff0f00;
 width:600px; 	float:left;
 }
  .clrbox1{ 
 text-align:left;
position: releative;
 border:1px solid #f20f10;
 width:600px;
height:200px; float:left;
 }
   .clrbox2{ 
 text-align:left;
position: releative;
 border:1px solid #f20f10;
 width:600px;
height:200px; float:left;
 }
 .blend1 img { position:relative;}
 
.blend1 img:first-child {
  position: absolute;
  mix-blend-mode: multiply;
  z-index:100;
  
}

.blend2 {position:absolute;top:0;}
.blend2 img:first-child {
  position: absolute;
  mix-blend-mode: multiply;
  z-index:900;
  }

.imgclr
{
background-color: #ff2233;

}




input[type='radio'] {
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 25px;
  height: 25px;
  margin: 5px 0 5px 5px;
  background-size: 225px 70px;
  position: relative;
  float: left;
  display: inline;
  top: 0;
  border-radius: 3px;
  z-index: 99999;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000;
}

input[type='radio']:hover{
  -webkit-filter: opacity(.4);
  filter: opacity(.4);    
}

.red{
  background: red;
}

.red:checked{
  background: linear-gradient(brown, red)
}

.green{
  background: green;
}

.green:checked{
  background: linear-gradient(green, lime);
}

.yellow{
  background: yellow;
}

.yellow:checked{
  background: linear-gradient(orange, yellow);
}

.purple{
  background: purple;
}

.pink{
  background: pink;
}

.purple:checked{
  background: linear-gradient(purple, violet);
}

.red:checked ~ img{
  -webkit-filter: opacity(.5) drop-shadow(0 0 0 red);
  filter: opacity(.5) drop-shadow(0 0 0 red);
}

.green:checked ~ img{
  -webkit-filter: opacity(.5) drop-shadow(0 0 0 green);
  filter: opacity(.5) drop-shadow(0 0 0 green);
}

.yellow:checked ~ img{
  -webkit-filter: opacity(.5) drop-shadow(0 0 0 yellow);
  filter: opacity(.5) drop-shadow(0 0 0 yellow);
}

.purple:checked ~ img{
  -webkit-filter: opacity(.5) drop-shadow(0 0 0 purple);
  filter: opacity(.5) drop-shadow(0 0 0 purple);
}

.pink:checked ~ img{
  -webkit-filter: opacity(.5) drop-shadow(0 0 0 pink);
  filter: opacity(.5) drop-shadow(0 0 0 pink);
}


 

.label{
  width: 150px;
  height: 75px;
  position: absolute;
  top: 170px;
  margin-left: 130px;
}


.b1{
  background: #336699;
}

.b1:checked{
  background: linear-gradient(#000, #336699)
}

.b2{
  background: #ffcccc;
}

.b2:checked{
  background: linear-gradient(#000, #ffcccc)
}
 
 .b3{
  background: #cc99cc;
}

.b3:checked{
  background: linear-gradient(#000, #cc99cc)
}

 .b4{
  background: #cc3333;
}

.b4:checked{
  background: linear-gradient(#000, #cc3333)
}

 .b5{
  background: #cccc66;
}

.b5:checked{
  background: linear-gradient(#000, #cccc66)
}

 .b6{
  background: #ffcc00;
}

.b6:checked{
  background: linear-gradient(#000, #ffcc00)
}

 .b7{
  background: #ff6633;
}

.b7:checked{
  background: linear-gradient(#000, #ff6633)
}

 .b8{
  background: #99ccff;
}

.b8:checked{
  background: linear-gradient(#000, #99ccff)
}

 .b9{
  background: #33ccff;
}

.b9:checked{
  background: linear-gradient(#000, #33ccff)
}

 .b10{
  background: #ffffff;
}

.b10:checked{
  background: linear-gradient(#000, #ffffff)
}


</style>

 


</head>

<body>

 <div class="mainbox">
<div class="blend1">
  <img src="eva_Layer3.png" width="600" height="620" >

 <?php if(file_exists(__DIR__."/base_".session_id().".gif")){ ?> 
  <img id="basetemp" src="base_<?php echo session_id(); ?>.gif" width="600" height="620"   >
 <?php } else { ?>
	<img id="basetemp" src="eva_Layer3.png" width="600" height="620" >
 <?php } ?> 

</div>
 
 <div class="blend2">
  <img src="eva_Layer4.png" width="600" height="620" >
  <?php if(file_exists(__DIR__."/bottom_".session_id().".gif")){ ?> 
  <img id="bottomtemp" src="bottom_<?php echo session_id(); ?>.gif" width="600" height="620"  >
   <?php } else { ?>
	<img id="bottomtemp" src="eva_Layer4.png" width="600" height="620" >
 <?php } ?> 
</div>
 </div>
  <div class="clrbox1">
  <div>Change Body Colour</div>
  <div>
 
  <input onclick="chngbasecolor('#336699');" class='b1' name='color' type='radio' />
  <input  onclick="chngbasecolor('#ffcccc');"  class='b2' name='color' type='radio' />
    <input  onclick="chngbasecolor('#cc99cc');" class='b3' name='color' type='radio' />
  <input  onclick="chngbasecolor('#cc3333');" checked class='b4' name='color' type='radio' />
  <input  onclick="chngbasecolor('#cccc66');" class='b5' name='color' type='radio' />  
    <input  onclick="chngbasecolor('#ffcc00');" class='b6' name='color' type='radio' /> 
	    <input  onclick="chngbasecolor('#ff6633');" class='b7' name='color' type='radio' /> 
		<input  onclick="chngbasecolor('#99ccff');" class='b8' name='color' type='radio' /> 
		<input  onclick="chngbasecolor('#33ccff');" class='b9' name='color' type='radio' /> 
		<input  onclick="chngbasecolor('#ffffff');" class='b10' name='color' type='radio' /> 
  
  </div>
 
  </div>
  <div class="clrbox2"><div>Change Bottom Panel Colour</div>
  
    <div>
	
	  <input onclick="chngbottomcolor('#336699');" class='b1' name='color' type='radio' />
  <input  onclick="chngbottomcolor('#ffcccc');"  class='b2' name='color' type='radio' />
    <input  onclick="chngbottomcolor('#cc99cc');" class='b3' name='color' type='radio' />
  <input  onclick="chngbottomcolor('#cc3333');" checked class='b4' name='color' type='radio' />
  <input  onclick="chngbottomcolor('#cccc66');" class='b5' name='color' type='radio' />  
    <input  onclick="chngbottomcolor('#ffcc00');" class='b6' name='color' type='radio' /> 
	    <input  onclick="chngbottomcolor('#ff6633');" class='b7' name='color' type='radio' /> 
		<input  onclick="chngbottomcolor('#99ccff');" class='b8' name='color' type='radio' /> 
		<input  onclick="chngbottomcolor('#33ccff');" class='b9' name='color' type='radio' /> 
		<input  onclick="chngbottomcolor('#ffffff');" class='b10' name='color' type='radio' /> 
  
	
	
 
  </div>
  
  
  </div>  

</body>
<script  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
<script>
function chngbasecolor(ccode)   
{ 
   	$.ajax({
			url : "base_color.php",
			type : "post",
			data : "ccode="+ccode,
			dataType : "json",			
			success : function(res) {
				
				if(res.rslt=="1")
				{		
					$('#basetemp').attr('src',res.imgsrc);
					
					
				}
			}
		});	 
		
}
</script>
			  crossorigin="anonymous"></script>
<script>
function chngbottomcolor(ccode)   
{ 
   	$.ajax({
			url : "bottom_color.php",
			type : "post",
			data : "ccode="+ccode,
			dataType : "json",			
			success : function(res) {
				
				if(res.rslt=="1")
				{		
					$('#bottomtemp').attr('src',res.imgsrc);
					
					
				}
			}
		});	 
		
}
</script>


</html>
 
