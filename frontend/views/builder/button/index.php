<?php


if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}
?>

<div <?= $id ?> class="module module-button <?= $_class ?>">

	<?php $target_ =  $target == '_blank' ? ' target="_blank"' : ''; ?>

	<a href="<?= $link ?>" class="btn btn-<?= $type ?>" <?= $target_ ?>><?= $text ?></a>

</div>