<?php
require_once "./Include/database.php";
require_once "./Include/databasefunction.php";
session_start();

// Static Data
$popularSearches = [
    'unlimited data',
    'fiber broadband',
    '5G',
    'tablet deals',
    'samsung',
    'apple',
    'budget friendly',
    'family plans'
];

$pageTitle = "Search";
$categories = [
    ['name' => 'Mobile', 'description' => 'Plans & devices', 'icon' => 'mobile-alt', 'color' => 'blue', 'link' => 'category.php?type=mobile'],
    ['name' => 'Broadband', 'description' => 'Internet packages', 'icon' => 'wifi', 'color' => 'green', 'link' => 'category.php?type=broadband'],
    ['name' => 'Tablet', 'description' => 'Devices & data', 'icon' => 'tablet-alt', 'color' => 'purple', 'link' => 'category.php?type=tablet'],
    ['name' => 'Bundles', 'description' => 'Combined packages', 'icon' => 'box', 'color' => 'orange', 'link' => 'category.php?type=bundles']
];

// Logic
if (isset($_GET['query']) && !empty($_GET['query'])) {
    addRecentSearch(trim($_GET['query']));
    header("Location: search_results.php?query=" . urlencode($_GET['query']));
    exit;
}

if (isset($_GET['clear_recent']) && $_GET['clear_recent'] == 1) {
    clearRecentSearches();
    header("Location: search.php");
    exit;
}

$recentSearches = getRecentSearches();

// Include template
ob_start();
include "./templates/search.html.php";
$page_content = ob_get_clean();
include './layout-mobile.html.php';