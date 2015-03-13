<?php

# If you are going with the AIO package (just setup and leave), take note that this page doesn't require any kind of authentication. It could, but in my own needs, it's better that it doesn't. 
# You can add that functionality pretty easily, just use $dbh->checkLogin().

require "includes/php/config.php";


if(isset($_POST['colour'])){
	$led->setHex($_POST['colour']);
	#setHex will sanitize the colour for you.
}
if(isset($_POST['function'])){

	$function = $_POST['function'];

	if($function == "police"){
		$sanitizedInput = "police";
	}
	elseif ($function == "disco") {
		$sanitizedInput = "disco";
	}
	elseif ($function == "strobe") {
		$sanitizedInput = "strobe";
	}
	elseif ($function == "off") {
		$sanitizedInput = "off";
	}

	else{
		$sanitizedInput = "naughty";
	}



	if(is_numeric($_POST['times'])){
		$times = $_POST['times'];
	}

	else{
		$times = 5;
	}
	$led->$sanitizedInput($times);

	# $led->$_POST['function']($_POST['times']); // OH NEIN YOU WILL NOT DO THAT. _ALWAYS_ sanitize user input. Even when that user is you.
	# It will probably mean more work for you, but at least you can sleep in peace. 
}
else{
	//print_r($_POST);
}
