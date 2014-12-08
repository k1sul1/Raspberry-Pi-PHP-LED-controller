<?php

$dsn = "mysql:host=localhost;dbname=YOUR_DATABASE_NAME;charset=utf8";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$db = new PDO($dsn,'YOUR_USERNAME','YOUR_PASSWORD', $opt);
$install = 0; # If you want to setup the database and so on, change this to one, and load index.php. Change to 0 after you've done that!


require "functions.php";
require "class.database.php";
require "class.rgbcontrol.php";

$led = new LedControl(18,23,24); # My RPi has red wire connected to GPIO pin 18, green wire to 23 and blue to 24. Adjust to your needs.

$dbh = new Database($db); # Adjust the variables above to your need for database connections. 

if($install == 1){
 $dbh->SetupDatabase();
}

?>