<?php
declare(strict_types=1);

function cart_add(int $id, int $qty = 1): void {
    if ($qty < 1) $qty = 1;
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
}

function cart_update(int $id, int $qty): void {
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

function cart_clear(): void {
    unset($_SESSION['cart']);
}
