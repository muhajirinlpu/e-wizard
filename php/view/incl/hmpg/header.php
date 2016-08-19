<div id="blanker"></div>
<div class="pop-ups center">

	<div class="loginPage popup-content">
		<form method="POST" action="php/process/form.php?do=login" >
			<input type="text" name="uname" placeholder="username">
			<input type="password" name="pass" placeholder="password">
			<button type="submit">LOGIN</button>
		</form>
	</div>

	<div class="registerPage popup-content">
		<form method="POST" action="php/process/form.php?do=register" class="form">
			<input type="text" name="uname" placeholder="username">
			<input type="password" name="pass" placeholder="password">
			<input type="password" name="passv" placeholder="password verification">
			<button type="submit">register</button>
		</form>
	</div>

	<div class="keranjang popup-content">

	</div>

	<div class="detail-product popup-content">

	</div>

</div>

<section class="navigation">
	<img src="assets/pic/logo.jpg" id="banner" width="79px" height="70px">
	<ul class="right icons">
		<li class="cart" style="margin-right:40px;"><img src="assets/pic/cart.png" style="" width="30px" height="30px"><span><?php echo CART::count() ?></span></li>
		<?php if (USER::isLogin()): ?>
		<li class="profil button">PROFILE</li>
		<li class="logout button">LOGOUT</li>
		<?php else: ?>
		<li class="login button">LOGIN</li>
		<li class="register button">REGISTER</li>
		<?php endif ?>
	</ul>
</section>