<?php

namespace common\models;
use Yii;

class Tools extends \yii\db\ActiveRecord
{

    public static function encode($input)
    {
        preg_match_all("/[a-z0-9]+/i", $input, $chunks);
        $return_ = strtolower(implode("-", $chunks[0]));
        return $return_;
    }




    public static function adminNoImageSrc()
    {
        return '/backend/web/theme/img/no-image.svg';
    }



    public static function renderShortcode($data, $row = false, $col = false, $id = false)
    {
        // GET CONTENT FROM SHORTCODE TAG
        $bodyContent = '';
        if (preg_match_all("/(?<=}}).*?(?={{)/", $data, $contentText)) {
            $bodyContent = $contentText[0][0];
        }

        // GET DATA INFO FROM SHORTCODE TAG
        $render = $data;
        $dataShortcode = [];
        if (preg_match_all("/(?<={{).*?(?=}})/", $data, $match)) {
            $m = $match[0][0];
            $syntax = explode(' ', $m);
            $function = $syntax[0];
            array_shift($syntax);
            $beforeParams = $syntax;

            foreach ($beforeParams as $param) {
                $attr = explode('=', $param);
                $dataShortcode[$attr[0]] = urldecode($attr[1]);
            }
            $dataShortcode['_bodyContent'] = $bodyContent;
            $dataShortcode['_row'] = $row;
            $dataShortcode['_col'] = $col;
            $dataShortcode['_idModule'] = $id;
            
            $content = Yii::$app->runAction('builder/' . $function, $dataShortcode);

            if($content != null) {

                if (!empty($match[0][1])) {

                    $render = str_replace('{{' . $m . '}}' . $bodyContent . '{{' . $match[0][1] . '}}', $content, $render);

                } else {

                    $render = str_replace('{{' . $m . '}}', $content, $render);
                }
            }



        } else {
            return $data;
        }

        return $render;
    }




    public static function shortcodeContent($data)
    {
        // GET CONTENT FROM SHORTCODE TAG
        $bodyContent = '';
        if (preg_match_all("/(?<=}}).*?(?={{)/", $data, $contentText)) {
            $bodyContent = $contentText[0][0];
        }

        return $bodyContent;
    }




    public static function decodeBody($content)
    {
        $decoded = html_entity_decode(htmlspecialchars_decode(urldecode($content)));
        return $decoded;
    }





    public static function renderBuilder($data)
    {
        foreach ((array)$data as $idRow => $row) {

            // ---- ROW OPTION ---- //
            foreach ($row as $idCol => $col) {
                if ($idCol == 'opt') {
                    $background = null;
                    if ($col->background_type == 'image') {
                        $background = 'background-image: url(' . Media::showImg($col->background_info) . ');';
                    } else {
                        if (strlen($col->background_info) != 0) {
                            $background = 'background-color: ' . $col->background_info . ';';
                        }
                    }

                    $ID = '';
                    $class = '';

                    if ($col->id != null) {
                        $ID = 'id="' . $col->id . '"';
                    }
                    if ($col->class != null) {
                        $class = ' ' . $col->class;
                    }

                    echo '<div class="builder-section' . $class . '" style="' . $background . '">';

                    if (strpos($col->class, 'no-section') === false) {
                        if ($col->container == 'boxed') {
                            echo '<div class="container">';
                        } else {
                            echo '<div class="container-fluid">';
                        }

                        $addContainer = true;
                    } else {
                        $addContainer = false;
                    }

                    echo '<div ' . $ID . ' class="row builder-row">';
                }
            }
            // ---- END ROW OPTION ---- //

            // ---- COLUMNS ---- //
            foreach ($row as $idCol => $col) {
            
                if ($idCol != 'opt') {
                    $background = null;
                    if ($col->background_type == 'image') {
                        $background = 'background-image: url(' . Media::showImg($col->background_info) . ');';
                    } else {
                        if ($col->background_info != null && strlen($col->background_info) != 0) {
                            $background = 'background-color: ' . $col->background_info . ';';
                        }
                    }

                    $id = '';
                    if (isset($col->id)) {
                        if (strlen($col->id) > 0) {
                            $id = 'id="' . $col->id . '"';
                        }
                    }

                    /* ----- CONTENT -----*/
                    $color = null;
                    if (strlen($col->color) != 0) {
                        $color = 'color: ' . $col->color . ';';
                    }
                    echo '<div ' . $id . ' class="' . $col->size . ' ' . $col->class . '" style="' . $background . ' ' . $color . '">';

                    foreach ($col->content as $key => $data) {
                        echo Tools::renderShortcode($data, $idRow, $idCol, $key);
                    }

                    echo '</div>';
                }

                /* ----- CONTENT -----*/
            }
            // ---- END COLUMNS ---- //
            if ($addContainer) {
                echo '</div>';
                echo '</div>';
            } else {

                echo '</div>';
            }
            echo '</div>';
        }
    }




    public static function shortenText($text, $max_length = 140, $cut_off = '...', $keep_word = true)
    {
        $text = strip_tags($text);
        if (strlen($text) <= $max_length) {
            return $text;
        }

        if (strlen($text) > $max_length) {
            if ($keep_word) {
                $text = substr($text, 0, $max_length + 1);

                if ($last_space = strrpos($text, ' ')) {
                    $text = substr($text, 0, $last_space);
                    $text = rtrim($text);
                    $text .= $cut_off;
                }
            } else {
                $text = substr($text, 0, $max_length);
                $text = rtrim($text);
                $text .= $cut_off;
            }
        }
        return $text;
    }


}
