<a href="/ikari/">
    <header><p>Entrega a todo AGUASCALIENTES</p></header>
</a>
<nav>
    <input type="checkbox" name="" id="check">
    <label for="check" class="checkbtn">
        <img src="https://img.uxwing.com/wp-content/themes/uxwing/download/web-app-development/hamburger-menu-icon.png" alt="" class="menu" height="50px">
    </label>
    <a href="/ikari/" class="enlace">
        <img src="images/logoIkari.jpg" height="50px">
    </a>
    <a href="carrito.php" class="menu">
        <img src="https://cdn-icons-png.flaticon.com/512/107/107831.png" alt="" height="30px">
        <span id="num_cart" class=""><?php echo $num_cart ?></span>
    </a>
    <?php if(isset($_SESSION['user_name'])){ ?>
        <a href="cuenta.php" class="menu" style="padding:5px; text-align: center">
            <img src="https://img.freepik.com/free-icon/user_318-286823.jpg" alt="" height="30px">
        </a>
        <?php }else{ ?>
        <a href="login.php" class="menu" style="text-align: center;">
            <img src="https://img.freepik.com/free-icon/user_318-286823.jpg" alt="" height="30px">
        </a>
    <?php } ?>
    <ul class="list">
        <li id="x" class="op"><a href=""><label for="check">X</label></a></li>
        <li class="op"><a href="/ikari/">Home</a></li>
        <li class="op"><a href="/ikari/">Informacion</a></li>
        <li class="op"><a href="/ikari/tienda.php">Camisas</a></li>
        <li class="op"><a href="/ikari/">Contacto</a></li>
    </ul>
</nav>