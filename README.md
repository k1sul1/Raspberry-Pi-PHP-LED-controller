    NOTICE

    I am not responsible for any damage you might cause to your power supply, Raspberry Pi, LEDs or to yourself. 
    If you accidentally miswire your RPi, you might sacrifice the whole board for the glory of satan.

[Introduction](#introduction)

[Usage](#usage)

[What you will need](#whatsneeded)

[Guide](#guidefordummies)

<a name="introduction"></a>

This class was written for one reason: easy usage of RGB LEDs with Raspberry Pi. 
Should be easy to use, and each function has a simple help section to it. 

This class was written to be used in conjuction with **PiBlaster** (https://github.com/sarfata/pi-blaster).
PiBlaster creates a special file in `/dev/pi-blaster`, and any application can write to it, meaning you don't have to be root to control the LEDs. 

Using this class is completely free, but you can buy me a cup of coffee if you want. But that is completely optional. I did this for fun and education.

<a href='https://pledgie.com/campaigns/27623'><img alt='Click here to lend your support to: LED-controller PHP class for Raspberry Pi and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/27623.png?skin_name=chrome' border='0' ></a>

This project is licensed under MIT License, which pretty much allows you to do what you want with the code, but requires you to include a license and copyright notice. 

<a name="usage"></a>
Simplest usage would be:

    
    <?php 
	require "class.rgbcontrol.php";
	$led = new LedControl(18,23,24); # GPIO Pins on RPi
	$led->setHex("#FFF000"); # Will provide yellowish color.
    ?>
	

However, I've included a all-in-one package which requires nothing but you setting up the RPi and connecting the LEDs correctly. It's even paired with a "remote" that you can access directly from your browser from other devices.

<a name="whatsneeded"></a>
What you will need:

- Raspberry Pi, preferably model B(+), as it has more RAM. 
- 3 TIP120 transistors, which can be found on ebay for about 1€ for five (including shipping)
- RGB LED (strip)
- Hookup wire (can be bought from ebay for about 1€)
- Jumper wire (can be bought from ebay for about 1€)
- DC power supply (anything with high enough amp rating. 5M of 12V 5050 RGB LEDs draw about 6A of power).

<a name="guidefordummies"></a>
##Guide

Setup a LAMP server if you haven't already, Digital Ocean has an excellent tutorial that will take care of the requirements.

https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu
Having PHPMyAdmin installed can also help later on.

Assuming you're running Debian distribution for RPi, like Raspbian:
```
sudo apt-get update
sudo apt-get install autoconf
sudo apt-get install unzip
wget https://github.com/sarfata/pi-blaster/archive/master.zip
unzip master.zip 
cd pi-blaster-master
sudo make install
```
Then you need to wire it up, like this (photo credit to mitchtech.net)



![Raspberry Pi Wiring](http://i.imgur.com/bQPst0m.png "Raspberry Pi Wiring")


After you've done that, you might as well try it out!
Try running `echo "18=1" > /dev/pi-blaster` into shell and see if anything lights up! 

If it does, here's the rest should you not figure it out yourself.

Assuming your www directory is /var/www/: 

```
cd /var/www/
wget https://github.com/k1sul1/rpi-php-led-controller/archive/master.zip
unzip master.zip
mv rpi-php* led-controller
php /var/www/led-controller/sample.php
```

Then navigate to your RPi's IP address and to the path of led-controller, for example, 192.168.1.50/led-controller/sample.php, and see if a manly color lights up!
