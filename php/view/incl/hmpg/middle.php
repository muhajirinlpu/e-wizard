<section>
	<form action="./?p=home&frame=search" method="GET" id="search">
		<input type="text" name="q" placeholder="Cari disini ....">
		<button type="submit">Search</button>
	</form>
</section>
<section id="top">
	<div class="popular-product">
		<table>
			<thead>
				<th><h1>Top product...</h1></th>
			</thead>
			<tbody>
				<?php 

					foreach (ITEM::seeFavorite()['message'] as $key => $value) { ?>
					<tr class="TopProduct-view">
						<td><img src="assets/uploads/default.png" width="160px" height="100px"></td>
						<td class="TopProduct-text">
							<h3><? echo $value['merk']." ".$value['type'] ?></h3>
							<p><? APP::custom_echo($value['spoiler'],70) ?></p>
							<a href="#<? echo $value['id_barang'] ?>">klik for detail...</a>
						</td>
					</tr>

				<?	}

				 ?>
				<tr class="TopProduct-view">
					<td><img src="assets/uploads/default.png" width="160px" height="100px"></td>
					<td class="TopProduct-text">
						<h3>Motorolla HX6L</h3>
						<p>Something stext here for description and many more broh</p>
						<a href="#1">klik for detail...</a>
					</td>
				</tr>
				<tr class="TopProduct-view">
					<td><img src="assets/uploads/default.png" width="160px" height="100px"></td>
					<td class="TopProduct-text">
						<h3>Motorolla HX6L</h3>
						<p>Something stext here for description and many more broh</p>
						<a href="#1">klik for detail...</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="spoiler-text right">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
</section>
<h1 id="banner-tengah">OUR PRODUCT</h1>
<section id="bottom">
	<div style="width:80%;margin-left:10%;margin-top:10%;">
		<?php for ($i=0; $i <10 ; $i++) {
			?>
		<div class="product">
			<img src="assets/uploads/default.png" width="160px" height="100px">
			<h5>HTC NEXUS</h5> <!-- judul -->
			<p>blablaba lbalbalab lbalbalablab lbalabbla...</p>
			<a href="#13">klik for detail..</a>
		</div>
			<?php
		} ?>
	</div>
	<ul id="ProductNavigation">
		<li><</li>
		<li>></li>
	</ul>
</section>
