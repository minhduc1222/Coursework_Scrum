
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
    }
    ?>

    <!-- Cart Contents -->
    <div>
    <?php if (empty($_SESSION['cart'])): ?>
        <p class="text-gray-600">Your cart is empty. <a href="packages.php" class="text-blue-600 hover:underline">Browse packages</a>.</p>
        <?php else: ?>
            <!-- Cart Items -->
            <div class="space-y-4">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $package_id => $item):
                    $price = $item['package']['Price'];
                    $total += $price;
                ?>
                    <div class="flex items-center bg-white border border-gray-200 rounded-lg p-4 shadow">
                        <!-- Package Icon -->
                        <div class="<?php
                            echo match ($item['package']['Type']) {
                                'Mobile' => 'bg-blue-100',
                                'Broadband' => 'bg-green-100',
                                'Tablet' => 'bg-yellow-100',
                                default => 'bg-gray-200',
                            };
                        ?> rounded-full w-16 h-16 flex items-center justify-center mr-4">
                            <?php if ($item['package']['Type'] === 'Mobile'): ?>
                                <i class="fas fa-mobile-alt text-blue-500 text-xl"></i>
                            <?php elseif ($item['package']['Type'] === 'Broadband'): ?>
                                <i class="fas fa-wifi text-green-500 text-xl"></i>
                            <?php elseif ($item['package']['Type'] === 'Tablet'): ?>
                                <i class="fas fa-tablet-alt text-yellow-500 text-xl"></i>
                            <?php else: ?>
                                <i class="fas fa-box text-gray-500 text-xl"></i>
                            <?php endif; ?>
                        </div>

                        <!-- Package Details -->
                        <div class="flex-1">
                            <h4 class="text-base font-semibold"><?= htmlspecialchars($item['package']['PackageName']) ?></h4>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($item['package']['Type']) ?></p>
                            <p class="text-sm font-bold text-blue-600">£<?= number_format($item['package']['Price'], 2) ?> /mo</p>
                        </div>

                        <!-- Remove -->
                        <div class="text-right">
                            <p class="text-sm font-bold">£<?= number_format($item['package']['Price'], 2) ?> /mo</p>
                            <a href="cart.php?action=remove&id=<?= $package_id ?>" class="text-red-500 text-sm hover:underline">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary -->
            <div class="mt-6 p-4 bg-gray-200 rounded-lg">
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

