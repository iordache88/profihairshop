<nav class="secondary-menu sticky-menu">

    <ul class="nav">
<?php
foreach ($menu as $item) {
        if ($item->label_title == null) {
            $titlemenu = $item->page->title;
        } else {
            $titlemenu = $item->label_title;
        }

        if ($item->type == 'page') {
            $urlmenu = '/' . $item->page->slug;
        } else {
            $urlmenu = $item->url;
        }

    /* ----- HEADER MENU ----- */
    echo '<li class="nav-item">';
    echo '<a href="' . $urlmenu . '" class="nav-link">' . $titlemenu . '</a>';

    /* ----- CHILD MENU ----- */
    if (count($item->child)) {

        echo '<ul class="dropdown-menu">';

        foreach ($item->child as $child) {
            if ($child->label_title == null) {
                $titleChild = $child->page->title;
            } else {
                $titleChild = $child->label_title;
            }

            if ($child->type == 'page') {
                $urlChild = '/' . $child->page->slug;
            } else {
                $urlChild = $child->url;
            }

            echo '<li class="nav-item"><a class="nav-link" href="' . $urlChild . '">' . $titleChild . '</a></li>';
        }

        echo '</ul>';
    }
    /* ----- END CHILD MENU ----- */

    echo '</li>';
}
?>
    </ul>

</nav>