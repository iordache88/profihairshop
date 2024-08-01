<?php

use common\models\Media;

$images = json_decode($gallery, true);
if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}
?>

<div <?= $id ?> class="module module-gallery <?= $_class ?>">

	<?php
	if (!empty($images)) {
		foreach ($images as $key => $image) {
			$dataTitle = '';

			if ($title == 1) {
				$dataTitle = 'data-title="' . Media::showInfo($image, 'alt_title') . '"';
			}

			// lightbox documentation: https://lokeshdhakar.com/projects/lightbox2/ 
			echo '
				<figure>
                <a href="' . Media::showImg($image) . '" data-lightbox="gallery-module' . $_row . $_col . $_idModule . '" ' . $dataTitle . '>
                <img src="' . Media::showImg($image) . '" class="img-fluid" alt="' . Media::showInfo($image, 'alt_title') . '"  title="' . Media::showInfo($image, 'title') . '" longdesc="' . Media::showInfo($image, 'description') . '">
                </a>
				</figure>
				';
		}
	}
	?>

</div>