<?php

use common\models\Media;

if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}

?>

<div <?= $id ?> class="module module-video <?= $_class ?>">
	<?php
	if ($type == 'upload') {
		$metaControls = '';
		$metaAutoplay = '';
		$metaMuted = '';
		$metaLoop = '';
		if ($controls == 1) {
			$metaControls = 'controls="true"';
		}
		if ($autoplay == 1) {
			$metaAutoplay = 'autoplay="true"';
			$metaMuted = 'muted="true"';
		}
		if ($loop == 1) {
			$metaLoop = 'loop="true"';
		}

		echo '<video id="' . $id . '" class="video-js" preload="auto" ' . $metaControls . ' ' . $metaAutoplay . ' ' . $metaMuted . ' ' . $metaLoop . 'poster="' . Media::showImg($thumb) . '">';

		$videoSource = Media::showImg($video);
		echo '<source src="' . $videoSource . '" type="video/mp4">';
		echo '  <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that
    						<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
  						</p>';
		echo '</video>';
	?>

	<?php
	}
	if ($type == 'url') {
		$videoUrl = $url;
		$videoUrl = explode('?v=', $videoUrl);
		$videoID = $videoUrl[1];

		echo '<iframe ';
		echo 'width="100%" ';
		echo 'height="400px" ';
		echo 'frameborder="0" ';
		echo 'src="https://www.youtube.com/embed/' . $videoID . '?controls=' . $controls . '"';
		echo '></iframe>';
	}
	?>
</div>