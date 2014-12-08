<?php

class Database {

	# NOTICE:
	# Please don't use this file as an examle on how to connect to database . The code is held together by paperclips and bubble gum. It works, but it ain't recommended. 
	# Please refer to http://stackoverflow.com/tags/pdo/info if you need help with database connections. 

	# This is just to save a color to database. Useful when using a cronjob to set the color, for example, at reboot. 

	public $db;

	public function __construct($db){
		$this->db = $db;		
	}

	function SetupDatabase(){

	# Just an useless function to create the necessary table(s) to painlessly control RGB LEDs from your Raspberry Pi. 

		$pdo = $this->db->prepare("CREATE TABLE IF NOT EXISTS 
			colors (
				cID int AUTO_INCREMENT PRIMARY KEY,
				red int(3) NOT NULL,
				green int(3) NOT NULL,
				blue int(3) NOT NULL,
				time varchar(20) NOT NULL);
			");
		if($pdo->execute()){
			echo "Table colors created. Populating table colors.<br>";
		}
		$pdo = $this->db->prepare("INSERT INTO colors (red,green,blue,time) VALUES (?,?,?,?)");

		if($pdo->execute(array(247,42,220,date("Y-m-d H:i:s")))){
			# yes it is a manly pink, you got a problem with that?
			echo "Table colors populated. <br>";
		}

	}

	function saveColor($color){

		# Take not that you _MUST_ make sure that the color is actually a color before using this function.
		# You could do that with the hex2rbg function.
		# $dbh->saveColor(hex2rbg($hex));
		# Not that it would do any harm, but then you would be wondering why you have no lights :>

		$pdo = $this->db->prepare("INSERT INTO colors (red,green,blue,time) VALUES (?,?,?,?)");

		if($pdo->execute(array($red,$green,$blue,date("Y-m-d H:i:s")))){

			return "Color saved.";
		}
	}


	function getColor(){
		# This function simply gets the last addition to database and returns it in an array format. 
		# Like this: Array ( [red] => 255 [green] => 255 [blue] => 255 )
		# You could then use it with the setRGB function (See class.rgbcontrol.php for that.)
		# Simple usage is $led->setRBG($dbh->getColor());

		$pdo = $this->db->prepare("SELECT red,green,blue FROM colors ORDER BY cID DESC LIMIT 1");
		$pdo->execute();

		return $pdo->fetch();
	}
}