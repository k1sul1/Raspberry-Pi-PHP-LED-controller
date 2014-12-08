<?php
function hex2rgb($hex) {
	
	$hex = str_replace("#", "", $hex); 

	if(validateHex($hex) == false){
	  return false;
	}

	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	 } 
	else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);

    return $rgb; 
}


function validateHex($color) {	 
	if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
	    // OK
	}
	elseif(preg_match('/^[a-f0-9]{3}$/i', $color)){
	  	// ok
	}
	else{
	  	return false;
	}
	  return $color;
}

function SaltThePassword($password){

	# just in case you're adding a login of somesort. 
	
	$salt = "ADDMORESALTpls";
	return sha1($salt.$password);
}

?>