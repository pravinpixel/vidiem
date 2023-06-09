<?php
// include Config File
include_once './includes/config.inc.php';
// Authenticate user login
auth();


if(isset($_GET['action']) && $_GET['action']=='approve') {
	
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'bad','msg'=>$lang['ADMIN_INVALID_ID']);
		redirect(ROOT_URL.'categories.php');
	}

	
	$db = db_connect();
	if($db->update('categories',array('approved'=>1),$_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'good','msg'=>$lang['ADMIN_STORE_APPROVED']);
	} else {
		$_SESSION['notification'] = array('type'=>'bad','msg'=>$lang['ADMIN_APPROVE_FAILED']);
	}
redirect(ROOT_URL.'categories.php');
}


if(isset($_GET['action']) && $_GET['action']=='delete') {
	
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'bad','msg'=>$lang['ADMIN_INVALID_ID']);
		redirect(ROOT_URL.'categories.php');
	}

	
	$db = db_connect();
	if($db->delete('categories', $_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'good','msg'=>$lang['SSF_ADMIN_CAT_DELETED']);
	} else {
		$_SESSION['notification'] = array('type'=>'bad','msg'=>$lang['SSF_ADMIN_CAT_DELETE_FAILED']);
	}
redirect(ROOT_URL.'categories.php');
}


$db = db_connect();

$limit = 20; 

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

mysql_query("SET NAMES utf8"); 
$cats = $db->get_rows("SELECT categories.* FROM categories WHERE categories.id!='' ORDER BY categories.cat_name ASC LIMIT $start_from, $limit");



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang['STORE_FINDER']; ?> - <?php echo $lang['ADMIN_STORE_LIST']; ?></title>
	<?php include 'header.php'; ?>
</head>
<body id="stores">
	<div id="wrapper">
		<div id="header">
			
			<?php include 'nav.php'; ?>
		</div>
		<div id="main">
		
			<h2><?php echo $lang['SSF_CATEGORY_LIST']; ?></h2>
			<?php echo notification(); ?>

			<table class="table table-bordered" style="width:100%;">
				<thead>
				<tr>
					<th><?php echo $lang['SSF_CATEGORY_NAME']; ?></th>
					<th><?php echo $lang['SSF_CATEGORY_ICON']; ?></th>
					
					<th class="actions"><?php echo $lang['ADMIN_ACTION']; ?></th>
				</tr>
				</thead>
				<tbody>
				
				<?php if(!empty($cats)): ?>
					<?php foreach($cats as $k=>$v): ?>
					<tr class='<?php echo ($k%2==0) ? 'odd':'even'; ?>'>
						<td><?php echo $v['cat_name']; ?></td>
						<td>
						
						
						
					<?php $upload_dir = ROOT.'imgs/categories/'.$v['id'].'/';

							    $images = array();
								if(is_dir($upload_dir)) {

									$images = get_files($upload_dir);
									foreach($images as $a=>$b) {
										$images[$a] = ROOT_URL.'imgs/categories/'.$v['id'].'/'.$b;
									}
							    }
							
					if(!empty($images)): ?>
					<div class="input">
						<?php foreach($images as $c=>$d): ?>
						<div class="image">
							<img src="<?php echo $d; ?>" alt="Image" style="max-width:30px; max-height:30px;"/>
						</div>
						<?php endforeach; ?>
					</div>
					<?php else: ?>
					<?php echo $lang['SSF_CATEGORY_NO_ICON']; ?>
					<?php endif; ?>
					
					</td>
						
						<td class="actions">
							<a href='./category_edit.php?id=<?php echo $v['id']; ?>'><i class="icon-pencil"></i></a>
							<a href='javascript:delItem(<?php echo $v['id']; ?>)' class="confirm_delete"><i class="icon-trash"></i></a>
							
						</td>
					</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="7"><?php echo $lang['SSF_CATEGORY_NO_CAT']; ?></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>

			
		<?php  
			$sql = "SELECT COUNT(id) FROM categories";  
			$rs_result = mysql_query($sql);  
			$row = mysql_fetch_row($rs_result);  
			$total_records = $row[0];  
			$total_pages = ceil($total_records / $limit);  
			$active = "";

			$pagLink = "<div class='pagination'><ul>";  
			for ($i=1; $i<$total_pages; $i++) { 
					if(isset($_GET['page'])){
						if($i==$_GET["page"]){
						  $active="class='active'";
						} else {
						   $active="";
						}
					}
						 $pagLink .= "<li ".$active."><a href='categories.php?page=".$i."'>".$i."</a></li>";  
			};  
			echo $pagLink . "</ul></div>";  
		?>  
	
		</div>
	</div>
	
	<script>
	function delItem(id){

	var a = confirm("<?php echo $lang['ADMIN_DELETE_CONFIRM']; ?>");
		if(a){
		document.location.href='?action=delete&id='+id;
		}
	
	}
	</script>
	<?php include '../themes/footer.inc.php'; ?>
</body>
</html>