<?php
$content = '';
$pageID = 0;

if (!empty($page)) {

	if (isset($page->type)) {

		$content = $page->content;
		$pageID  = $page->id;

	} elseif ($type == 'footer') {

		$content = $page->data;
		$pageID  = 'f' . $page->id;

	} elseif ($type == 'header') {

		$content = $page->data;
		$pageID  = 'h' . $page->id;

	} elseif ($type == 'globalsection') {

		$content = $page->content;
		$pageID  = 'gs' . $page->id;

	} else {

		$content = $page->data;
		$pageID  = 'c' . $page->id;
	}

} elseif (empty($page) && !empty($id)) {

	$pageID = $id;
}
?>

<div id="magic_builder" data-item="<?= $pageID ?>">

	<?php
	include('_core/builder.php');
	?>

</div>

<div class="panel panel-default col-md-12">
	<div class="panel-body text-center mt-4">

		<?php if ($type == null) { ?>
		<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="layout" data-action="show" data-page="<?= $pageID ?>"><i class="fas fa-download"></i> Load</button>
		<?php } ?>

		<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="row" data-action="add" data-page="<?= $pageID ?>" data-type="<?= $type ?>"><i class="fas fa-plus"></i> Section</button>

	</div>
</div>

