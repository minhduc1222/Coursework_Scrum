<?php
require_once "include/database.php";
require_once "include/databasefunction.php";
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
include "template/search_results.html.php";
