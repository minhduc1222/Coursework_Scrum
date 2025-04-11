<?php
// Include database configuration
include '../config/db.php';

// Include model files
include '../models/Package.php';
include '../models/Deal.php';
include '../models/SpecialOffer.php';

// DB Connection

// Get all deals
$deal = new Deal($pdo);
$deal_stmt = $deal->readAll();

// Get all Package
$package = new Package($pdo);
$package_stmt = $package->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheapDeals - Affordable Packages for Mobile, Broadband and Tablets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .gradient-purple {
            background: linear-gradient(90deg, #8e44ad 0%, #9b59b6 100%);
        }
        .gradient-green {
            background: linear-gradient(135deg, #2ecc71 0%, #1abc9c 100%);
        }
        .gradient-red-purple {
            background: linear-gradient(135deg, #9b59b6 0%, #e74c3c 100%);
        }
        .gradient-blue {
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="bg-white rounded-full w-10 h-10 flex items-center justify-center mr-2">
                    <span class="text-transparent">.</span>
                </div>
                <h1 class="text-xl font-bold">CheapDeals</h1>
            </div>
            <div class="flex items-center">
                <a href="cart.php" class="mr-4"><i class="fas fa-shopping-cart"></i></a>
                <button class="focus:outline-none"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        <div class="container mx-auto mt-4">
            <div class="relative">
                <input type="text" placeholder="Search packages and deals..." class="w-full p-2 pl-10 rounded-lg bg-gray-700 text-white">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </header>

    <!-- Main Promotion Banner -->
    <section class="gradient-purple text-white p-6">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold">15% OFF</h2>
            <p class="mb-4">All packages when ordered through the app</p>
            <a href="#packages" class="bg-white text-purple-700 px-6 py-2 rounded-lg font-medium inline-block">Shop Now</a>
        </div>
    </section>

    <!-- Package Categories -->
    <section class="py-4 bg-white">
        <div class="container mx-auto flex justify-around">
            <a href="mobile.php" class="flex flex-col items-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                    <i class="fas fa-mobile-alt text-blue-500 text-xl"></i>
                </div>
                <span>Mobile</span>
            </a>
            <a href="broadband.php" class="flex flex-col items-center">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                    <i class="fas fa-wifi text-green-500 text-xl"></i>
                </div>
                <span>Broadband</span>
            </a>
            <a href="tablet.php" class="flex flex-col items-center">
                <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                    <i class="fas fa-tablet-alt text-yellow-500 text-xl"></i>
                </div>
                <span>Tablet</span>
            </a>
            <a href="bill.php" class="flex flex-col items-center">
                <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                    <i class="fas fa-file-invoice text-red-500 text-xl"></i>
                </div>
                <span>Pay Bill</span>
            </a>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="py-6">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Special Offers</h2>
                <a href="offers.php" class="text-blue-600">View All</a>
            </div>
            
            <!-- Double Package Deal -->
            <?php while ($row = $deal_stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <?php
                $discount = $row['DiscountPercentage'];
                $name = htmlspecialchars($row['DealName']);
                $desc = htmlspecialchars($row['Description']);
            ?>
            <div class="bg-white rounded-lg shadow-md mb-4 flex overflow-hidden">
                <div class="gradient-blue text-white p-4 flex flex-col justify-center items-center w-24">
                    <div class="text-2xl font-bold"><?= $discount ?>%</div>
                    <div class="text-sm">OFF</div>
                </div>
                <div class="p-4 flex-1">
                    <h3 class="font-bold"><?= $name ?></h3>
                    <p class="text-gray-600 text-sm"><?= $desc ?></p>
                    <a href="offers.php" class="text-blue-600 text-sm">View All</a>
                </div>
            </div>
        <?php endwhile; ?>

        </div>
    </section>

    <!-- Popular Packages -->
    <section id="packages" class="py-6 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Popular Packages</h2>
                <a href="packages.php" class="text-blue-600">View All</a>
            </div>

            <?php if ($package_stmt && $package_stmt->rowCount() > 0): ?>
                <?php while ($row = $package_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php
                        $id = htmlspecialchars($row['PackageID']);
                        $name = htmlspecialchars($row['PackageName']);
                        $desc = htmlspecialchars($row['Description']);
                        $price = number_format($row['Price'], 2);
                        $type = strtolower($row['Type']);

                        // Icon logic (example based on type)
                        $icon = 'fa-box';
                        $bgColor = 'bg-gray-200';
                        $textColor = 'text-gray-600';

                        if ($type === 'mobile') {
                            $icon = 'fa-mobile-alt';
                            $bgColor = 'bg-blue-100';
                            $textColor = 'text-blue-500';
                        } elseif ($type === 'broadband') {
                            $icon = 'fa-wifi';
                            $bgColor = 'bg-green-100';
                            $textColor = 'text-green-500';
                        } elseif ($type === 'tablet') {
                            $icon = 'fa-tablet-alt';
                            $bgColor = 'bg-purple-100';
                            $textColor = 'text-purple-500';
                        }
                    ?>
                    <a href="package-details.php?id=<?= $id ?>" class="block bg-white rounded-lg shadow-md mb-4 p-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="<?= $bgColor ?> rounded-full w-12 h-12 flex items-center justify-center mr-3">
                                    <i class="fas <?= $icon ?> <?= $textColor ?>"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold"><?= $name ?></h3>
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 text-sm"><?= $desc ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">£<?= $price ?></p>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-500">No packages available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Account Section -->
    <section class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-xl font-bold mb-4">My Account</h2>
            
            <a href="account-usage.php" class="block border-b border-gray-200 py-3 flex justify-between items-center">
                <span>Current Usage</span>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">3.2GB / 5GB</span>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </a>
            
            <a href="account-bill.php" class="block border-b border-gray-200 py-3 flex justify-between items-center">
                <span>Current Bill</span>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">£34.99 due</span>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </a>
            
            <a href="account-settings.php" class="block py-3 flex justify-between items-center">
                <span>Account Settings</span>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        </div>
    </section>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200">
        <div class="flex justify-around">
            <a href="index.php" class="flex flex-col items-center p-2 text-blue-500">
                <i class="fas fa-home"></i>
                <span class="text-xs">Home</span>
            </a>
            <a href="packages.php" class="flex flex-col items-center p-2 text-gray-500">
                <i class="fas fa-box"></i>
                <span class="text-xs">Package</span>
            </a>
            <a href="search.php" class="flex flex-col items-center p-2 text-gray-500">
                <i class="fas fa-search"></i>
                <span class="text-xs">Search</span>
            </a>
            <a href="bill.php" class="flex flex-col items-center p-2 text-gray-500">
                <i class="fas fa-file-invoice"></i>
                <span class="text-xs">Bill</span>
            </a>
            <a href="support.php" class="flex flex-col items-center p-2 text-gray-500">
                <i class="fas fa-headset"></i>
                <span class="text-xs">Support</span>
            </a>
        </div>
    </nav>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>