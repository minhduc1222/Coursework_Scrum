<!-- Header -->
<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold"><?= htmlspecialchars($dealModel->DealName) ?></h1>
    <div>
        <a href="cart.php" class="text-white">
            <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-2 13H5L3 3zm4 16a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
        </a>
    </div>
</header>

<!-- Main Content -->
<main class="p-4">
    <!-- Deal Info -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex items-center mb-4">
            <div class="gradient-blue text-white p-4 flex flex-col justify-center items-center w-24 rounded-lg">
                <div class="text-2xl font-bold"><?= $dealModel->DiscountPercentage ?>%</div>
                <div class="text-sm">OFF</div>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold"><?= htmlspecialchars($dealModel->DealName) ?></h2>
                <p class="text-gray-600"><?= htmlspecialchars($dealModel->Description) ?></p>
            </div>
        </div>
    </div>

    <!-- Packages -->
    <div class="space-y-4">
    <?php foreach ($deal_packages as $package): 
    $originalPrice = $package['Price'];
    $discount = ($dealModel->DiscountPercentage / 100) * $originalPrice;
    $finalPrice = $originalPrice - $discount;
?>
    <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
        <div class="flex items-center">
            <!-- Icon Badge based on Package Type -->
            <div class="<?php
                echo match ($package['Type']) {
                    'Mobile' => 'bg-blue-100',
                    'Broadband' => 'bg-green-100',
                    'Tablet' => 'bg-yellow-100',
                    default => 'bg-gray-200',
                };
            ?> rounded-full w-12 h-12 flex items-center justify-center mr-4">
                <?php if ($package['Type'] === 'Mobile'): ?>
                    <i class="fas fa-mobile-alt text-blue-500 text-lg"></i>
                <?php elseif ($package['Type'] === 'Broadband'): ?>
                    <i class="fas fa-wifi text-green-500 text-lg"></i>
                <?php elseif ($package['Type'] === 'Tablet'): ?>
                    <i class="fas fa-tablet-alt text-yellow-500 text-lg"></i>
                <?php else: ?>
                    <i class="fas fa-box text-gray-500 text-lg"></i>
                <?php endif; ?>
            </div>

            <div>
                <h3 class="text-lg font-semibold"><?= htmlspecialchars($package['PackageName']) ?></h3>
                <p class="text-gray-600"><?= htmlspecialchars($package['Type']) ?></p>
                <p class="text-gray-500 line-through">£<?= number_format($originalPrice, 2) ?>/mo</p>
                <p class="text-blue-600 font-bold">£<?= number_format($finalPrice, 2) ?>/mo</p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    </div>

    <!-- Total -->
    <!-- Total -->
<div class="mt-6 p-4 bg-gray-200 rounded-lg">
    <div class="space-y-2 text-right">
        <div class="flex justify-between">
            <span class="text-gray-600 font-medium">Subtotal</span>
            <span class="text-gray-800">£<?= number_format($total, 2) ?>/mo</span>
        </div>
        <div class="flex justify-between">
            <span class="text-red-600 font-medium">Discount (<?= $dealModel->DiscountPercentage ?>%)</span>
            <span class="text-red-600">-£<?= number_format($total - $discounted_total, 2) ?>/mo</span>
        </div>
        <div class="flex justify-between border-t pt-2 mt-2">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-lg font-bold text-blue-700">£<?= number_format($discounted_total, 2) ?>/mo</span>
        </div>
    </div>
    <div class="mt-4">
        <a href="checkout.php?deal_id=<?= $deal_id ?>" class="block bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700">
            Proceed to Checkout
        </a>
    </div>
</div>

</main>