<?php


if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = null;
}
?>

<div <?= $id ?> class="module module-widget <?= $_class ?>">

	<?php
	if ($global_section->status == 10) {
		echo $global_section->render();
	}
	?>

</div>