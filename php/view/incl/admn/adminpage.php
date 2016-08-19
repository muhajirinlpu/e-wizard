<section class="navigation" style="height:70px">
	<h1 style="position:absolute">&nbsp&nbspHy, <?php echo ADMIN::getName() ?></h1>
	<ul class="right icons">
		<li class="button" style="">Logout</li>
	</ul>
</section>
<section class="panel">
	<ul>
		<li><a href="./?p=admin&frame=order">Order data</a></li>
		<li><a href="./?p=admin&frame=barang">Add barang</a></li>
		<li><a href="./?p=admin&frame=kategori">Add kategori</a></li>
	</ul>
</section>

<section class="body-panel">
	<?php 

		if (isset($_GET['frame'])) {
			# code...
		switch ($_GET['frame']) {
			case 'order':
				include_once '';
				break;

			case 'barang':
				include_once '';
				break;

			case 'kategori':
				include_once '';
				break;
			
			default:
				# code...
				break;
		}
		}

	?>
</section>