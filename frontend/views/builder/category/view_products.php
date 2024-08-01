<?php
$id = null;
if (!empty($_id)) {
    $id = 'id="' . $_id . '"';
}
echo '<div ' . $id . ' class="grid-container' . $_class . '">';

include('_products_loop.php');

echo '</div>';
