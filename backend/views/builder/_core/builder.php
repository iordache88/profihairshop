<?php

$data = json_decode($content, false);

if (!empty($data)) {
    foreach ($data as $idRow => $row) {
        // ---- ROW OPTION ---- //
        foreach ($row as $idCol => $col) {
            if ($idCol == 'opt') {
                $background = NULL;
                if ($col->background_type == 'image') {
                    $background = 'background: url(\'/uploads/' . $col->background_info . '\');';
                } else {
                    if (!empty($col->background_info)) {
                        $background = 'background: ' . $col->background_info . ';';
                    }
                }

                $ID = '';
                $class = '';

                if ($col->id != NULL) {
                    $ID = ' | ID: <b>' . $col->id . '</b>';
                }
                if ($col->class != NULL) {
                    $class = ' | class: <b>' . $col->class . '</b>';
                }

                echo '<div class="row row-' . $idRow . '" style="' . $background . '" data-order="' . $idRow . '" data-order-target="row" data-order-page="' . $pageID . '">';
                echo '<div class="topRow"><label>row' . $ID . $class . '</label>';

                echo '<span class="handle text-primary"><i class="fas fa-arrows-alt"></i></span>';

                echo '<div class="row_actions">';
                echo '<button type="button" data-bs-toggle="modal" data-bs-target="#modalLayout" class="btn btn-success btn-sm btn-link content-edit-btn save-btn" data-bs-toggle="tooltip" data-placement="top" title="Save to library" onclick="savetolibrary(\'' . $idRow . '\',\'section\', \'show\')"><i class="fas fa-save"></i></button>';

                echo '<button type="button" data-bs-toggle="modal" data-bs-target="#modal_builder" class="btn btn-info btn-sm btn-link content-edit-btn edit-btn" data-view="row" data-action="edit" data-page="' . $pageID . '" data-item="' . $idRow . '" title="Edit row"><i class="fas fa-pencil-alt"></i></button>';

                echo '<button type="button" class="btn btn-warning btn-sm btn-link content-edit-btn btn-submit-edit" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="row" data-action="clone" data-page="' . $pageID . '" data-item="' . $idRow . '" title="Delete row"><i class="fa fa-clone"></i></button>';

                echo '<button type="button" class="btn btn-danger btn-sm btn-link content-edit-btn btn-submit-edit" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="row" data-action="remove" data-page="' . $pageID . '" data-item="' . $idRow . '" title="Delete row"><i class="fas fa-times"></i></button>';

                echo '</div>';
                echo '</div>';
                echo '<div class="contentRow">';
            }
        }
        // ---- END ROW OPTION ---- //

        // ---- COLUMNS ---- //
        foreach ($row as $idCol => $col) {
            $background = NULL;
            if ($idCol != 'opt') {
                if ($col->background_type == 'image') {
                    $background = 'background: url(/uploads/' . $col->background_info . ');';
                } else {
                    if (!empty($col->background_info)) {
                        $background = 'background: ' . $col->background_info . ';';
                    }
                }

                $id = '';
                if (isset($col->id)) {
                    $id = 'id="' . $col->id . '"';
                }

                /* ----- CONTENT -----*/
                $color = NULL;
                if (!empty($col->color)) {
                    $color = 'color: ' . $col->color . ';';
                }

                echo '<div ' . $id . ' class="col col-' . $idCol . ' ' . $col->size . ' ' . $col->class . '" style="' . $background . ' ' . $color . '" data-order="' . $idCol . '" data-order-target="col" data-order-parents="' . htmlentities(json_encode([$idRow])) . '" data-order-page="' . $pageID . '">';

                echo '<div class="topColumn"><label>col ' . $idCol . '</label>';

                echo '<div class="column_actions">';
                echo '<button type="button" data-bs-toggle="modal" data-bs-target="#modal_builder" class="btn btn-info btn-sm btn-link content-edit-btn edit-btn" data-view="column" data-action="edit" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" title="Edit column"><i class="fas fa-pencil-alt"></i></button>';

                echo '<button type="button" class="btn btn-warning btn-sm btn-link content-edit-btn btn-submit-edit" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="column" data-action="clone" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" title="Clone column"><i class="fa fa-clone"></i></button>';

                echo '<button type="button" class="btn btn-danger btn-sm btn-link content-edit-btn btn-submit-edit" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="column" data-action="remove" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" title="Delete column"><i class="fas fa-times"></i></button>';
                echo '</div>';
                echo '</div>';

                echo '<div class="contentColumn">';

                include('shortcode.php');

                echo '<span class="col-md-12 module-action-btn text-center">';
                echo '<button type="button" data-bs-toggle="modal" data-bs-target="#modal_builder" class="btn btn-primary btn-sm btn-builder-add" data-view="module" data-action="add" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" data-type="' . $type . '"><i class="fas fa-plus"></i> Module</button>';
                echo '</span>';

                echo '</div>';
                echo '</div>';
                // include('_edit_column.php');

                /* ----- CONTENT -----*/
            }
        }

        $idCol = '';
        echo '</div>';
        echo '<span class="col-md-12 text-center"><button type="button" class="btn btn-success btn-sm btn-builder-add" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="column" data-action="add" data-page="' . $pageID . '" data-item="' . $idRow . '" data-type="' . $type . '"><i class="fas fa-plus"></i> Column</button></span>';
        echo '</div>';
    }
}
/// return convert function for old builders
elseif (!empty($data)) {
    include('convert.php');
}
