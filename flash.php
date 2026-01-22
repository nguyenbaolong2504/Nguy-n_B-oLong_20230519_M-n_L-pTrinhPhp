<?php
session_start();

function set_flash($msg, $type = 'success') {
    $_SESSION['flash'] = compact('msg', 'type');
}

function get_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}
