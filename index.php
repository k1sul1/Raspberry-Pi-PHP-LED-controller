<?php
require "includes/php/config.php";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="LED-remote for home.">

<title>Remote</title> 


<link rel="stylesheet" href="css/pure.css">  
<!--[if lte IE 8]>
    <link rel="stylesheet" href="css/layouts/gallery-grid-old-ie.css">
<![endif]-->
<!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="css/layouts/gallery-grid.css">
<!--<![endif]-->
  
<!--[if lte IE 8]>
    <link rel="stylesheet" href="css/layouts/gallery-old-ie.css">
<![endif]-->
<!--[if gt IE 8]><!-->
<link rel="stylesheet" href="css/layouts/gallery.css">
<!--<![endif]-->

<link rel="stylesheet" href="css/custom.css">
</head>
<body>
<div>
    <div class="header">
        <div class="pure-menu pure-menu-open pure-menu-horizontal" id="menu" >
            <a class="pure-menu-heading" href="">LED-remote</a>
            
            <ul>
                <li class="pure-menu-selected"><a href="#colors">Colours</a></li>
                <li><a href="#functions">Functions</a></li>
                
               
            </ul>
            
        </div>
    </div>

    <div class="pure-g">

    <div id="colors"></div>
    <?php for ($i=0; $i < 24; $i++): 
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
    ?>
   
        <div class="photo-box u-1-6 u-med-1-6 u-lrg-1-6 preset-color" data-color="<?=$color?>" style="background-color:<?php echo $color; ?>">
         
                
            

            <aside class="photo-box-caption">
                <span> <?=$color?></span>
            </aside>
            
        </div>
    

    <?php endfor; ?>

        



        <div class="u-1 form-box" id="functions">
        
            <div class="l-box">
            <form class="pure-form" style="margin:0 auto; text-align:center;" id="custom-color-form" method="post" action="#">

            <input type="number" value="5" name="repeat" id="repeat" style="width:100px;"><br>
                
            <a class="button-small pure-button function" data-function="police">Police</a> 
            <a class="button-small pure-button function" data-function="disco">Disco</a>
            <a class="button-small pure-button function" data-function="strobe">Strobe</a>


            <a class="button-small pure-button function" style="background: rgb(202, 60, 60); " data-function="off">Turn off</a>   

             </form>   
            </div>
        </div>
        
    </div>

    <div class="footer">
        &copy; 2014 Christian Nikkanen. May contain nuts.
    </div>
</div>



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">


$(".function").on("click",function(){
    $.post("save.php", "function="+$(this).data("function")+"&times="+$("#repeat").val());
});

$(".preset-color").on("click",function(){
        
        $.post("save.php", "colour="+$(this).data("color"));
});


</script>


</body>
</html>
