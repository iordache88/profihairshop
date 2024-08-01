<tr data-key="<?= $item->id; ?>" data-src="<?= $item->showSrc(); ?>" class="tr-media-item">

    <td class="td-add-media-item" style="width: 50px;">
        <button type="button" class="btn btn-icon btn-sm btn-success btn_add_media_item">
            <i class="fas fa-plus"></i>
        </button>
    </td>

    <td scope="row" class="td-media-item-img">
        <!-- <img width="50" height="50" src="/uploads/<?= $item->folder->url; ?>/<?= $item->url; ?>" alt="<?= $item->alt_title ?>"> -->
        <?= $item->getFile($item, 'icon'); ?>
    </td>

    <td class="text-center">
        <?= $item->id; ?>
    </td>

    <td class="td-media-item-src">
        <div class="input-group input-group-outline">
            <p class="copy_url" title="Click to copy"><?= $item->showSrc(); ?></p>
        </div>
    </td>

    <td>
        <div class="input-group input-group-outline">
            <input type="text" name="alt_title" value="<?= $item->alt_title; ?>" class="form-control input-update-media-attribute">
        </div>
    </td>



    <td>
        <div class="input-group input-group-outline">
            <textarea name="description" class="form-control media-item-description-textarea input-update-media-attribute"><?= $item->description; ?></textarea>
        </div>
    </td>


    <td>
        <div class="input-group input-group-outline">
            <select class="form-control change_item_folder" data-id="<?= $item->id; ?>">
                <?php 

                $folders = $item->find()->andWhere(['parent_id' => 0, 'status' => 10])->orderBy('alt_title asc')->all();

                foreach($folders as $folder) {
                    ?>
                    <option value="<?= $folder->id; ?>" <?= $item->parent_id == $folder->id ? 'selected' : ''; ?>><?= $folder->alt_title; ?></option>
                    <?php
                }

                ?>
            </select>
        </div>
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-sm btn-icon btn_delete_media_item" data-id="<?= $item->id; ?>" title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>
    </td>
</tr>