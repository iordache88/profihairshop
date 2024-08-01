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
	$name = 'check'.$_row.$_col.$_idModule.'[]';
	$options = json_decode($options, true);
?>

<div <?= $id ?> class="form-group checkbox item-<?= $_row.$_col.$_idModule ?> <?= $_class ?>">
<label><?= $label ?><?= $icon ?></label>

<?php foreach($options as $key=>$option) : ?>

	<div class="check">
		<label><input type="checkbox" name="<?= $name ?>" value="<?= $option ?>"/> <?= $option ?></label>
	</div>

<?php endforeach; ?>

</div>