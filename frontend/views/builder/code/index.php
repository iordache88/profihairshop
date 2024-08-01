<?php

use common\models\Tools;

$content = Tools::decodeBody($_bodyContent);

if (!empty($_id)) {
	$id = 'id="' . $_id . '"';
}
?>

<div <?= $id ?> class="module module-code <?= $_class ?>">
	<?= Tools::renderShortcode($content) ?>
</div>