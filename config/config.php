<?php
define("ClientId", "AXB7G1iHWdLRD0Rh1I9FaJ_iOVBTmTZ9K7Qa4L2GuNN1e5Kul8PDcYIawcA-2Cx2ygt3RfhVnT43E4b5");
define("Currency", "MXN");
define("KEY_TOKEN", "ABFR.mB-p45&");
define("moneda", "$");
define("Icon", "images/icon.png");
session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart=count($_SESSION['carrito']['productos']);
}
?>