    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Load from library</h4>
      </div>

      <div class="modal-body">
        <h6 class="modal-title">Page layouts <small><span class="text-muted">All content will be deleted when loading the layout</span></small></h6>

        <div class="row">
          <div class="col-md-12" style="display: flex; flex-wrap: wrap">
            <?php
            foreach ($layouts as $layout) {
              if ($layout->render == 'page') {
                echo '<form method="POST" action="/backend/web/index.php?r=builder/layout">';
                echo '<input type="hidden" name="' . Yii::$app->request->csrfParam . '" value="' . Yii::$app->request->csrfToken . '" />';
                echo '<input type="hidden" name="action" value="' . $action . '">';
                echo '<input type="hidden" name="page" value="' . $page . '">';
                echo '<input type="hidden" name="item" value="' . $item . '">';
                echo '<input type="hidden" name="column" value="' . $column . '">';
                echo '<input type="hidden" name="module" value="' . $module . '">';
                echo '<input type="hidden" name="layout" value="' . $layout->ID . '">';
                echo '<button type="submit" class="btn btn-info">' . $layout->title . '</button>';
                echo '</form>';
              }
            }

            $btnLayoutUpload = htmlentities(json_encode(['page' => $page, 'action' => 'show']));
            echo '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalGeneral" data-action="builder/uploadlayout" data-values="' . $btnLayoutUpload . '"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>';
            ?>
          </div>
        </div>

        <h6 class="modal-title">Sections</h6>
        <div class="row">
          <div class="col-md-12" style="display: flex; flex-wrap: wrap">
            <?php
            foreach ($layouts as $layout) {
              if ($layout->render == 'section') {
                echo '<form method="POST" action="/backend/web/index.php?r=builder/layout">';
                echo '<input type="hidden" name="' . Yii::$app->request->csrfParam . '" value="' . Yii::$app->request->csrfToken . '" />';
                echo '<input type="hidden" name="action" value="' . $action . '">';
                echo '<input type="hidden" name="page" value="' . $page . '">';
                echo '<input type="hidden" name="item" value="' . $item . '">';
                echo '<input type="hidden" name="column" value="' . $column . '">';
                echo '<input type="hidden" name="module" value="' . $module . '">';
                echo '<input type="hidden" name="layout" value="' . $layout->ID . '">';
                echo '<button type="submit" class="btn btn-success">' . $layout->title . '</button>';
                echo '</form>';
              }
            }
            ?>

          </div>
        </div>
      </div>
    </div>

    </form>