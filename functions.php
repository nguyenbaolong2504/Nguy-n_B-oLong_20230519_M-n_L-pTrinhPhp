<?php
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function valid_slug($slug) {
    return preg_match('/^[a-z0-9-]+$/', $slug);
}
