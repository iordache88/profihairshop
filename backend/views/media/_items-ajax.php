<?php

use yii\bootstrap5\LinkPager;

?>

<?php
if(empty($items)) {

?>
    <p>No items found, try another search...</p>
    <?php 
    if(is_object($folder)){
        ?>
        <p><button type="button" class="btn btn-danger btn_remove_folder" data-id="<?= $folder->id; ?>">Remove folder</button></p>
        <?php
    }
     ?>
    <?php
    echo '<form method="POST" action="/backend/web/index.php/?r=site%2Fmedia&folder='.$folder->id.'">';
    echo '<input type="hidden" name="action" value="removeFolder"/>';
    echo '<input type="hidden" name="idFolder" value="'.$folder->id.'"/>';
        if(Yii::$app->user->identity['role'] == 'admin')
        {
            echo '<button type="submit" class="btn btn-link btn-danger btn-block" style="width:fit-content;" data-confirm="You want to delete this folder?"><i class="fas fa-trash"></i> remove folder</button>';
        }
    echo '</form>';
?>
<?php

} else {

    if(isset($search_keyword) && strlen($search_keyword) > 0) {

        echo "<p><strong>Showing {$items_count} items found by word '{$search_keyword}'</strong></p>.";

    } elseif(is_object($folder)) {

        echo "<p><strong>Showing last added files from <em>'{$folder->alt_title}'</em></strong></p>";

    } else {
        echo "<p><strong>Showing last added files.</strong></p>";
    }
    ?>
    <div class="table-responsive">

        <table class="table table-media-items">
            <thead>
                <tr>
                    <th class="th-add-media-item" style="width: 50px;"></th>
                    <th style="width: 60px;"></th>
                    <th class="text-center">ID</th>
                    <th style="width: 150px;">Src</th>
                    <th>Alt title</th>
                    <th>Description</th>
                    <th style="width: 150px;">Move to folder</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($items as $item) {

                    echo $this->render('_item-ajax-part', ['item' => $item]);
                
                }
                ?>

            </tbody>
        </table>
    </div>


    <?php
    echo LinkPager::widget([
        'pagination' => $pagination
    ]);
    ?>
    <?php 
    if(is_object($folder)){
    ?>
    <p><button type="button" class="btn btn-danger btn_remove_all_files_from_folder" data-id="<?= $folder->id; ?>">Remove all files from "<?= $folder->url; ?>"</button></p>
    <?php } ?>
    <?php
}
?>


<div class="modal fade" id="modalMediaUsedInfo" tabindex="-1" role="dialog" aria-labelledby="modalMediaUsedInfo" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>