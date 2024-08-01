<?php

use common\models\Tools;

if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
} else {
	$id = '';
}
?>

<div <?= $id ?> class="module module-text <?= $_class ?>" style="color: <?= $color ?>">

	<?php
	$body = Tools::decodeBody($_bodyContent);
	echo $body;
	?>

</div>