<?php
	$mandatory = null;
	$icon = null;

	if(!empty($_id))
	{
		$id = 'id="'.$_id.'"';
	}
	if($required == 1)
	{
		$mandatory = 'required=""';
		$icon = '<span>*</span>';
	}
	$name = 'radio'.$_row.$_col.$_idModule;
	$options = json_decode($options, true);
?>

<div <?= $id ?> class="form-group radio item-<?= $_row.$_col.$_idModule ?> <?= $_class ?>">
<label><?= $label ?><?= $icon ?></label>

<?php foreach($options as $key=>$option) : ?>

	<div class="radio">
		<label><input type="radio" name="<?= $name ?>" value="<?= $option ?>"/> <?= $option ?></label>
	</div>

<?php endforeach; ?>

</div>