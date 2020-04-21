<?php

/*
 * type (string): primary, secondary, success, danger, warning, info, light, dark
 * message (string):
 */
function add_flash($type, $message)
{
    if (!isset($_SESSION['flash'][$type])) {
        $_SESSION['flash'][$type] = array();
    }

    $_SESSION['flash'][$type][] = $message;
}

function show_flash()
{
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $messages) {
            foreach ($messages as $message) {
                echo sprintf('<div class="alert alert-%s" role="alert">%s</div>', $type, $message);
            }
        }
        unset($_SESSION['flash']);
    }
}


function remove_flash()
{
    unset($_SESSION['flash']);
}
