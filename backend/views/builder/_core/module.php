<?php 
use yii\helpers\Url;
 ?>
<!-- Modal content-->
<div class="modal-content modules">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title text-center">Modules</h4>
	</div>
	<div class="modal-body">
		<div class="row text-center">

			<?php

			$modules = $this->context->listModules(null, $type);

			foreach ($modules as $key => $module) {
				echo '<div class="col-md-3">';
				echo '<form method="POST" action="' . Url::to(['builder/module']) . '">';
				echo '<input type="hidden" name="' . Yii::$app->request->csrfParam . '" value="' . Yii::$app->request->csrfToken . '" />';
				echo '<input type="hidden" name="action" value="' . $action . '">';
				echo '<input type="hidden" name="page" value="' . $page . '">';
				echo '<input type="hidden" name="item" value="' . $item . '">';
				echo '<input type="hidden" name="column" value="' . $column . '">';
				echo '<input type="hidden" name="module" value="' . $key . '">';
				echo '<input type="hidden" name="type" value="' . $type . '">';

				echo '<button type="submit" class="btn w-100 module-btn">
				<i class="fa ' . $module['icon'] . '"></i>
				' . $module['title'] . '
				</button>';

				echo '</form>';
				echo '</div>';
			}
			?>

		</div>
	</div>
</div>