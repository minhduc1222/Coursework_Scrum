<!-- Header -->
<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Shopping Cart</h1>
    <div>
        <a href="profile.php" class="text-white">
            <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </a>
    </div>
</header>

<!-- Main Content -->
<main class="p-4">
    <!-- Status Message -->
    <?php
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    if ($status == 'added') {
        echo '<div class="px-4 py-2 bg-green-100 text-green-700 rounded">Item added to cart!</div>';
    } elseif ($status == 'updated') {
        echo '<div class="px-4 py-2 bg-blue-100 text-blue-700 rounded">Cart updated!</div>';
    } elseif ($status == 'removed') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700 rounded">Item removed from cart!</div>';
    } elseif ($status == 'cleared') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700 rounded">Cart cleared!</div>';
    } elseif ($status == 'error') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700 rounded">Error adding item to cart!</div>';
    } elseif ($status == 'type_exists') {
        $type = $_GET['type'] ?? 'Unknown';
        echo '<div class="px-4 py-2 bg-red-100 text-red-700 rounded">A ' . htmlspecialchars($type) . ' package is already in your cart!</div>';
    }
    ?>

    <!-- Cart Contents -->
    <div>
    <?php if (empty($_SESSION['cart'])): ?>
        <p class="text-gray-600">Your cart is empty. <a href="packages.php" class="text-blue-600 hover:underline">Browse packages</a> or <a href="custom_package.php" class="text-blue-600 hover:underline">create a custom package</a>.</p>
    <?php else: ?>
        <!-- Cart Items -->
        <div class="space-y-4">
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $package_id => $item):
                $price = $item['package']['Price'];
                $total += $price;
            ?>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow flex items-start">
                    <!-- Icon or Image -->
                    <?php if ($item['package']['Type'] === 'Broadband'): ?>
                        <div class="bg-green-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                            <i class="fas fa-wifi text-green-500 text-xl"></i>
                        </div>
                    <?php elseif ($item['type'] === 'Package' && !empty($item['package']['img'])): ?>
                        <img src="<?= htmlspecialchars($item['package']['img']) ?>" alt="<?= htmlspecialchars($item['package']['PackageName']) ?>" class="w-16 h-16 object-cover rounded mr-4">
                    <?php else: ?>
                        <div class="bg-gray-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                            <span class="text-gray-500"><?php echo htmlspecialchars($item['package']['Type'][0]); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Package Details -->
                    <div class="flex-1">
                        <h4 class="text-base font-semibold"><?= htmlspecialchars($item['package']['PackageName']) ?></h4>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($item['package']['Type']) ?> <?php echo ($item['type'] === 'CustomPackage') ? '(Custom)' : ''; ?></p>
                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($item['package']['Description']) ?: 'No description available.' ?></p>
                        <p class="text-sm font-bold text-blue-600">£<?= number_format($item['package']['Price'], 2) ?> /mo</p>
                    </div>

                    <!-- Remove -->
                    <div class="text-right mt-2">
                        <p class="text-sm font-bold">£<?= number_format($item['package']['Price'], 2) ?> /mo</p>
                        <a href="cart.php?action=remove&id=<?= $package_id ?>" class="text-red-500 text-sm hover:underline">Remove</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Cart Summary -->
        <div class="mt-4 p-4 bg-gray-200 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Total</h3>
                <p class="text-lg font-bold">£<?= number_format($total, 2) ?> /mo</p>
            </div>
            <div class="mt-4 flex justify-between">
                <a href="cart.php?action=clear" class="text-red-500 font-medium hover:underline">Clear Cart</a>
                <a href="<?= isset($_SESSION['customer_id']) ? 'checkout.php' : 'login.php?redirect=checkout'; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
    </div>
</main>