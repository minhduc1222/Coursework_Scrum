<?php
require_once "./Include/database.php";
require_once "./Include/databasefunction.php";
session_start();

// Check if query parameter exists
if (!isset($_GET['query']) || empty($_GET['query'])) {
    header("Location: search.php");
    exit;
}

$query = trim($_GET['query']);
$pageTitle = "Search Results: " . htmlspecialchars($query);

// Perform the search using reusable function
$searchResults = searchContent($query);

$packages = $searchResults['packages'];
$deals = $searchResults['deals'];
$totalResults = $searchResults['total'];
$error = $searchResults['error'] ?? null;

// Include template
// Include template
ob_start();
include "./templates/search_results.html.php";
$page_content = ob_get_clean();
include './layout-mobile.html.php';