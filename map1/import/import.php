<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry,places"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="js/import.js"></script>
<script>

<?php
$handle = fopen('sample_data.csv', 'r');
$rc = 0;
$trc = 0;
while (($row = fgetcsv($handle)) !== false) {
?>
import_address(
<?php
    foreach ($row as $field) {
	$rc++;

		if($rc<9){
			echo $field . ',';
		} else {
		    echo $field . '); ';
			$rc=1;
			$trc++;
		}
    }
}
fclose($handle);
?>

</script>

<?php echo $trc." number of stores successfully imported"; ?>
