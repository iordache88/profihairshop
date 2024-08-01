<?php
foreach ($col->content as $idModule => $shortcode) {
    $paramSet = [];
    $label = null;
    preg_match_all("/(?<={{).*?(?=}})/", $shortcode, $match);
    foreach ($match[0] as $m) {
        # code...
        $syntax = explode(' ', $m);
        $moduleName = $syntax[0];
        array_shift($syntax);
        $beforeParams = $syntax;

        if (isset($syntax[2]) && strpos($syntax[2], '_label') !== false) {
            
            $label = explode('=', $syntax[2]);
            $label = $label[1];
        }

        break;
    }

    preg_match_all("/(?<=}}).*?(?={{)/", $shortcode, $content);

    echo '<div class="module module-' . $moduleName . '" " data-order="' . $idModule . '" data-order-target="module" data-order-parents="' . htmlentities(json_encode([$idRow, $idCol])) . '" data-order-page="' . $pageID . '">';

    if (!empty($content[0][0]) && $moduleName == 'text') {

        $content = strip_tags(html_entity_decode(htmlspecialchars_decode(urldecode($content[0][0]))));
        if (strlen($content) > 30) {
            $content = substr($content, 0, 30) . '...';
        }
        echo '"' . $content . '"';

    } elseif (!empty($label)) {

        echo '<p>' . urldecode($label) . ' <small>(' . $moduleName . ')</small></p>';

    } else {

        if ($moduleName === 'startwrap') {

            $startwrap_element_name = explode('=', $beforeParams[4])[1];
            echo '< ';
            if (empty($startwrap_element_name)) {
                echo $moduleName;
            } else {
                echo $startwrap_element_name;
            }
            echo ' >';
        } elseif ($moduleName === 'endwrap') {

            $endwrap_element_name = explode('=', $beforeParams[1])[1];
            echo '< /';
            if (empty($endwrap_element_name)) {
                echo $moduleName;
            } else {
                echo $endwrap_element_name;
            }
            echo ' >';
        } else {

            echo $moduleName;
        }
    }

    echo '<div class="module_actions">';
    echo '<button type="button" class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="getmodule" data-action="' . $moduleName . '" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" data-module="' . $idModule . '" data-type="' . $type . '"><i class="fa fa-pencil" aria-hidden="true"></i></button>';

    echo '<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="actionmodule" data-action="clone" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" data-module="' . $idModule . '" title="Duplicate"><i class="fa fa-clone"></i></button>';

    echo '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_builder" data-view="actionmodule" data-action="remove" data-page="' . $pageID . '" data-item="' . $idRow . '" data-column="' . $idCol . '" data-module="' . $idModule . '" title="Delete module"><i class="fas fa-times"></i></button>';
    echo '</div>';

    echo '</div>';
}
