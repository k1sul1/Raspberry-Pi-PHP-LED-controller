<?php
class LedControl {


	##############################################################################################################################

	# NOTICE:
	# I am not responsible for any damage you might cause to your power supply, Raspberry Pi, LEDs or to yourself. 
	# If you plug a wrong wire into wrong pin, you might fry your RPi. I, myself, managed to do it by accident once.  

	# What you will need:
	# Raspberry Pi, preferably model B(+), as it has more RAM. 
	# 3 TIP120 transistors, which can be found on ebay for about 1€ for five (including shipping)
	# RGB LED (strip)
	# Hookup wire (can be bought from ebay for about 1€)
	# Jumper wire (can be bought from ebay for about 1€)

	##############################################################################################################################

	# This class was written for one reason: easy usage of RGB LEDs with Raspberry Pi. 
	# Should be easy to use, and each function has a simple help section to it. 

	# This class was written to be used in conjuction with PiBlaster (https://github.com/sarfata/pi-blaster).
	# PiBlaster creates a special file in /dev/pi-blaster, and any application can write to it, meaning you don't have to be root to control the LEDs. 

	# Simplest usage would be:

    	/*
    	<?php 
		require "class.rgbcontrol.php";
		$led = new LedControl(18,23,24); #G PIO Pins on RPi
		$led->setHex("#FFF000"); # Will provide yellowish color.
	?>
	*/

	# However, I've included a all-in-one package which requires nothing else but you setting up the RPi and connecting the LEDs correctly. 

	# About file_put_contents: 
	# PiBlaster guides you to use 'echo "18=0.2" > /dev/pi-blaster' directly to command-line. That is the fastest way. 
	# So you might think that shell_exec('echo "18=0.2" > /dev/pi-blaster'); would be faster, than file_put_contents, but it isn't. 
	# I ran some rough tests with PHPs built in function, microtime, and file_put_contents was 44 times faster. 

	public $GPIORed;
	public $GPIOGreen;
	public $GPIOBlue;

	function __construct($red,$green,$blue) {

	# Whatever you do, don't touch this. Unless you know what you're doing. 
			
      $this->GPIORed = $red;
      $this->GPIOGreen = $green;
      $this->GPIOBlue = $blue;
   	}

	public function setColor($color,$power){

		# RGB LED strips generally consist of three parts. Red LEDs, Green LEDs and Blue LEDs. 
		# Each LED color can be invidually powered. (Then there's RGB LED strips that allow control of each INVIDUAL LED, but I won't go further on that subject. You probably don't have one of those. )
		# This function allows you to power each of these three colours. 
		# Example: 
		# $led->setColor("red",0.1);
		# The first parameter is for colour, and it can be red, green or blue. Case sensitive, but you can do something about that, if you want.
		# The second parameter is for amount of power you want to use. Basically 0-1, but you can use decimal values, 0.47 for example. This is how you generate different colours. 
		# This function is mainly useful when developing custom "disco" lights, as it's easier to edit a value between quotes than setRed to setGreen. Try double clicking the word green. setColor("green",0.1).

		try{
			if(is_float($power) || is_int($power)){
			// ok, good
			}
			else{
				throw new Exception("Amount of power was not int or float! Exiting.", 1);
				return false;				
			}
		}

		catch(Exception $e){
			echo "Exception: ".$e->getMessage()."\n";
			exit;
		}


		if($color == "red"){
			file_put_contents("/dev/pi-blaster", "{$this->GPIORed}=$power\n");
		}

		if($color == "green"){
			file_put_contents("/dev/pi-blaster", "{$this->GPIOGreen}=$power\n");
		}

		if($color == "blue"){
			file_put_contents("/dev/pi-blaster", "{$this->GPIOBlue}=$power\n");
		}
	}


	public function setRed($power){
		# Alternative function to power Red LEDs on the strip. One parameter, power. Anything between 0-1. 
		file_put_contents("/dev/pi-blaster", "{$this->GPIORed}=$power\n");
	}

	public function setGreen($power){
		# Alternative function to power Green LEDs on the strip. One parameter, power. Anything between 0-1. 
		file_put_contents("/dev/pi-blaster", "{$this->GPIOGreen}=$power\n");
	}

	public function setBlue($power){
		# Alternative function to power Blue LEDs on the strip. One parameter, power. Anything between 0-1. 
		file_put_contents("/dev/pi-blaster", "{$this->GPIOBlue}=$power\n");
	}

	function setRGB($rgb){
		# This function is to be used with an array of RGB values. The array should look like this:
		# Array ( [red] => 255 [green] => 255 [blue] => 255 )
		# Use this function in conjuction with database function getColor(). For example:
		# $led->setRGB($dbh->getColor());

		$r = $rgb['red']/255;
		$g = $rgb['green']/255;
		$b = $rgb['blue']/255;

		# RGB consists of 3 main colors:  Red, Green & Blue. Each of these colors have 255 possible values, and when combined, you can pretty much get 16 million colors from them. 
		# However, the RGB LEDs get their colors from the amount of power you give each color. If you combine red and green, you get yellow. 
		# Most of the LED strips are "analog". Analog is anything between 0-1. When each color has 256 possible values, and you need that value to be something between 0-1, you can simply divide the color with 255. 
		# 255 because 0 is a possible number. I might be wrong on that, but it's either 255 or 256, and you won't notice a difference on that.

		file_put_contents("/dev/pi-blaster", "{$this->GPIORed}=$r\n");
		file_put_contents("/dev/pi-blaster", "{$this->GPIOGreen}=$g\n");
		file_put_contents("/dev/pi-blaster", "{$this->GPIOBlue}=$b\n");

	}

	function setHex($hex){

		# This function is to be used with hexadecimal color value. For example, #FFF000 which will produce yellow. 
		# It's pretty simple. 


		$color = hex2rgb($hex);

		# This simply converts the hexadecimal to rgb.

		$r = $color[0]/255;
		$g = $color[1]/255;
		$b = $color[2]/255;

		file_put_contents("/dev/pi-blaster", "{$this->GPIORed}=$r\n");
		file_put_contents("/dev/pi-blaster", "{$this->GPIOGreen}=$g\n");
		file_put_contents("/dev/pi-blaster", "{$this->GPIOBlue}=$b\n");
	}

	
	# Custom function help:
	# Just in case you have little to none experience with PHP or any kind of programming, here's a little help text.
	# To use the functions inside this class, you can use $this. You could do $led = new LedControl(1,2,3), but that would defy everything this class is designed for, and would be plain wrong. 
	# What if you changed the order of the wires on your RPi? Then you would have to modify every instance of new LedControl(1,2,3) to get correct colors. 
	# So you can use pretty much any function inside this class, if you simply use $this instead of $led when you're calling those functions.
	# Scroll down for examples.  

	# About sleeping ("fading"):
	# PHP has a function "sleep()" which allows to wait for x number of seconds. But it doesn't work with 0.5 for example.
	# Use usleep() for less than second waits.



	 function police($times){

	 	# Scare your friends or hamster or cat with these amazing police-lights!  
		# Call with $led->police(100); to run trough the police a 100 times. Be vary of maximum php execution times. 


	 	$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);

		


		for($i=0;$i<$times;$i++){

			$this->setColor("red",0.2);usleep(50000);
			$this->setColor("red",0.8);usleep(50000);
			$this->setColor("red",1.0);usleep(50000);
			$this->setColor("red",0.8);usleep(50000);
			$this->setColor("red",0.2);usleep(50000);
			$this->setColor("red",0.0);usleep(50000);

			usleep(50000);

			$this->setColor("blue",0.2);usleep(50000);			
			$this->setColor("blue",0.8);usleep(50000);
			$this->setColor("blue",1.0);usleep(50000);
			$this->setColor("blue",0.8);usleep(50000);
			$this->setColor("blue",0.2);usleep(50000);
			$this->setColor("blue",0.0);usleep(50000);
			
		}

	}

	 function disco($times){

		# Yeah. You read it right. Awesome party hosted by your RPi. 
		# Call with $led->disco(100); to run trough the disco a 100 times. Be vary of maximum php execution times. 

		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);

		


		for($i=0;$i<$times;$i++){

			$this->setColor("blue",0.2);usleep(50000);	
			$this->setColor("green",0.2);usleep(50000);
			$this->setColor("red",0.2);usleep(50000);
			$this->setColor("blue",0.8);usleep(50000);
			$this->setColor("green",0.8);usleep(50000);
			$this->setColor("red",0.8);usleep(50000);
			$this->setColor("blue",1.0);usleep(50000);
			$this->setColor("green",1.0);usleep(50000);
			$this->setColor("red",1.0);usleep(50000);
			$this->setColor("blue",0.8);usleep(50000);
			$this->setColor("green",0.8);usleep(50000);
			$this->setColor("red",0.8);usleep(50000);
			$this->setColor("blue",0.2);usleep(50000);
			$this->setColor("green",0.2);usleep(50000);
			$this->setColor("red",0.2);usleep(50000);
			$this->setColor("blue",0.0);usleep(50000);
			$this->setColor("green",0.0);usleep(50000);
			$this->setColor("red",0.0);usleep(50000);
	
			
			
		}

	}

	function naughty($times){
		# Angry looking red color.

		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);
		for($i=0;$i<$times;$i++){
			$this->setRed(0.1);usleep(100000);
			$this->setRed(0.2);usleep(100000);
			$this->setRed(0.8);usleep(100000);
			$this->setRed(0.4);usleep(100000);
			$this->setRed(0.5);usleep(100000);
			$this->setRed(0.6);usleep(100000);
			$this->setRed(0.7);usleep(100000);
			$this->setRed(0.8);usleep(100000);
			$this->setRed(0.9);usleep(100000);
			$this->setRed(1);usleep(100000);
			$this->setRed(0.9);usleep(100000);
			$this->setRed(0.8);usleep(100000);
			$this->setRed(0.7);usleep(100000);
			$this->setRed(0.6);usleep(100000);
			$this->setRed(0.5);usleep(100000);
			$this->setRed(0.4);usleep(100000);
			$this->setRed(0.8);usleep(100000);
			$this->setRed(0.2);usleep(100000);
			$this->setRed(0.1);usleep(100000);
		}
		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);
	}

	function strobe($times){

		# A lame strobe light. Lame you ask? Depending on the quality of your LED strip, it could be lame, or it could not be lame. White made from RGB isn't really white. 
		# But if you'd connect a white LED strip to this, it would probably look cool.

		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);


		for($i=0;$i<$times;$i++){

			$this->setRed(0);
			$this->setGreen(0);
			$this->setBlue(0);
			usleep(10000);
			$this->setRed(1);
			$this->setGreen(1);
			$this->setBlue(1);		
			
		}

		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);
	}

	function off(){
		# Yeah. A function to turn off the LEDs. Pretty much set the LEDs to black and it's off.

		$this->setColor("red",0);
		$this->setColor("green",0);
		$this->setColor("blue",0);
	}

}




?>
