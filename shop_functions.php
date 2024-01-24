<?php
session_start();
include("etc/connection.php");

function add_to_basket($id, $stock) {
    if(isset($_SESSION['basket'])) {
        foreach($_SESSION['basket'] as $key => $basket_item) {
            if($basket_item['item'] == $id) {
                if ($stock > ($_SESSION['basket'][$key]['quantity'] + 1)) {
                    $_SESSION['basket'][$key]['quantity']++;
                }
                return;
            }
        }
    }

    if ($stock > 0) {
        $_SESSION['basket'][] = array('item' => $id, 'quantity' => 1);
    }
}

function remove_from_basket($id) {
    if(isset($_SESSION['basket'])) {
        foreach($_SESSION['basket'] as $key => $basket_item) {
            if($basket_item['item'] == $id) {
                if($basket_item['quantity'] > 1) {
                    $_SESSION['basket'][$key]['quantity']--;
                } else {
                    unset($_SESSION['basket'][$key]);
                }
                return;
            }
        }
    }
}

function clear_basket() {
    unset($_SESSION['basket']);
}

if ($_GET['action'] == 'add_item') {
    $id = $_GET['id'];
    $stock = $_GET['stock'];

    add_to_basket($id, $stock);
    header("Location: shop_basket.php");
} else if ($_GET['action'] == 'remove_item') {
    $id = $_GET['id'];

    remove_from_basket($id);
    header("Location: shop_basket.php");
} else if ($_GET['action'] == 'clear_basket') {
    clear_basket();
    header("Location: shop_basket.php");
} else if ($_GET['action'] == 'place_order') {
    place_order();
}