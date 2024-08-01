<?php
	$mandatory = null;
	$icon = null;

	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
	if(!empty($maxsize))
	{
		$max = 'size="'.$maxsize.'"';
	}
	if($required == 1)
	{
		$mandatory = 'required=""';
		$icon = '<span>*</span>';
	}
	$name = 'file'.$_row.$_col.$_idModule;
?>

<div class="form-group item-<?= $_row.$_col.$_idModule ?>">
<label><?= $label ?><?= $icon ?></label>
<input <?= $id ?> type="file" class="<?= $_class ?>" placeholder="<?= $label ?>" name="<?= $name ?>" <?= $max ?> />
</div>