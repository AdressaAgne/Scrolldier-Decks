<div class="container">

	<div class="row">

	<?php //fetching each page to display on the tool page
		foreach ($base->pagestructure as $key => $value) {
			if (isset($value['tool']) && $value['tool'] == true) { ?>
			<a href='<?= $key ?>'>
				<div class="col-4">
					<img src="<?= $value['image'] ?>" alt="" />
					<div class="col-12 tag">
						<?= $value['name'] ?>
						
					</div>
				</div>
			</a>
			<?php }
		} ?>
	</div>
</div>