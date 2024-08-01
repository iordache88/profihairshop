<?php

use common\models\Media;

$alt = Media::showInfo($image, 'alt_title');
$titleImg = Media::showInfo($image, 'title');
if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}
?>

<div <?= $id ?> class="module module-image <?= $_class ?>">

	<?php
	$imageUrl = Media::showImg($image);
	$image = '<img src="' . $imageUrl . '" alt="' . $alt . '" title="' . $titleImg . '" />';

	if ($open == 'lightbox') {
		$dataTitle = '';

		if ($title == 1) {
			$dataTitle = 'data-title="' . $alt . '"';
		}

		echo '<a href="' . $imageUrl . '" data-lightbox="image-module' . $_col . $_id . '" ' . $dataTitle . '>' . $image . '</a>';
	} elseif ($open == 'link') {

		echo '<a href="' . $url . '" target="' . $target . '">' . $image . '</a>';
	} else {
		echo $image;
	}

	?>
</div>