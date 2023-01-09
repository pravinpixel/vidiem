/**
 * Import a single address
 * @param string address
 * @param string region
 */

 
function import_address(address, storename, tel, email, website, desc, status_type, approved) {
	region = '';
	if(region==null || region == '') {
		region = 'us';
	}

	// address not empty
	if(address != '') {

		geocoder = new google.maps.Geocoder();
		// lookup the address
		geocoder.geocode( {'address':address,'region':region}, function(results, status) {
			// if the address was found
			if(status == google.maps.GeocoderStatus.OK) {
				
				// return lat/lang
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				
				//return results[0].geometry.location.lat()+", "+results[0].geometry.location.lng();
				$.ajax({
					type:"POST",
					url:'import_insert.php',
					data:"ajax=1&action=import_data&latitude="+latitude+"&longitude="+longitude+"&name="+storename+"&telephone="+tel+"&website="+website+"&description="+desc+"&status="+status_type+"&approved="+approved+"&email="+email+"&address="+address,
					success:function(msg) {
						//alert(msg);
						if(msg=='1'){
						
						}
					}
				});
				
				
				
			} else {
				
				// display error
				//return '';
			}
		});
	}
}