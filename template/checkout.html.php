<!-- Header -->
<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Checkout</h1>
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
    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($is_deal_checkout): ?>
        <!-- Deal-based Checkout -->
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
            <?php foreach ($deal_packages as $package): ?>
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Icon Badge based on Package Type -->
                        <div class="<?php
                            echo match ($package['Type']) {
                                'MobileOnly' => 'bg-blue-100',
                                'BroadbandOnly' => 'bg-green-100',
                                'TabletOnly' => 'bg-yellow-100',
                                default => 'bg-gray-200',
                            };
                        ?> rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <?php if ($package['Type'] === 'MobileOnly'): ?>
                                <i class="fas fa-mobile-alt text-blue-500 text-lg"></i>
                            <?php elseif ($package['Type'] === 'BroadbandOnly'): ?>
                                <i class="fas fa-wifi text-green-500 text-lg"></i>
                            <?php elseif ($package['Type'] === 'TabletOnly'): ?>
                                <i class="fas fa-tablet-alt text-yellow-500 text-lg"></i>
                            <?php else: ?>
                                <i class="fas fa-box text-gray-500 text-lg"></i>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold"><?= htmlspecialchars($package['PackageName']) ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($package['Type']) ?></p>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($package['Description']) ?></p>
                            <?php if ($package['FreeMinutes'] > 0): ?>
                                <p class="text-gray-600 text-sm">Minutes: <?= $package['FreeMinutes'] ?></p>
                            <?php endif; ?>
                            <?php if ($package['FreeSMS'] > 0): ?>
                                <p class="text-gray-600 text-sm">SMS: <?= $package['FreeSMS'] ?></p>
                            <?php endif; ?>
                            <?php if ($package['FreeGB'] > 0): ?>
                                <p class="text-gray-600 text-sm">Data: <?= $package['FreeGB'] ?>GB</p>
                            <?php endif; ?>
                            <p class="text-blue-600 font-bold">
                                £<?= number_format($package['Price'] * (1 - $dealModel->DiscountPercentage / 100), 2) ?>/mo
                            </p>


                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Original: £<?= number_format($package['Price'], 2) ?>/mo</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Special Offers -->
        <form method="POST" action="checkout.php?deal_id=<?= $deal_id ?>">
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Apply Additional Discounts</h2>
                <div class="mb-4">
                    <label for="special_offer_id" class="block text-gray-700 font-medium mb-1">Select a Special Offer</label>
                    <select name="special_offer_id" id="special_offer_id" class="w-full p-2 border rounded">
                        <option value="">No Special Offer</option>
                        <?php foreach ($specialOffers as $specialOffer): ?>
                            <option value="<?php echo $specialOffer['SpecialOfferID']; ?>">
                                <?php echo htmlspecialchars($specialOffer['Description']) . " (" . $specialOffer['DiscountPercentage'] . "% off)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-gray-200 p-4 rounded-lg mt-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Total</h2>
                <div class="text-right">
                    <?php if ($discount_percentage > 0): ?>
                        <p class="text-sm text-gray-600 line-through">£<?= number_format($total, 2) ?>/mo</p>
                    <?php endif; ?>
                    <p class="text-xl font-bold">£<?= number_format($discounted_total, 2) ?>/mo</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex justify-between">
                <a href="deal-details.php?deal_id=<?= $deal_id ?>" class="text-blue-600 font-medium">Back to Deal</a>
                <button type="submit" name="checkout" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Place Order</button>
            </div>
        </form>
    <?php else: ?>
        <!-- Cart-based Checkout -->
        <div class="space-y-4">
            <?php foreach ($cart_items as $packageID => $item): ?>
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Icon Badge based on Package Type -->
                        <div class="<?php
                            echo match ($item['Type']) {
                                'MobileOnly' => 'bg-blue-100',
                                'BroadbandOnly' => 'bg-green-100',
                                'TabletOnly' => 'bg-yellow-100',
                                default => 'bg-gray-200',
                            };
                        ?> rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <?php if ($item['Type'] === 'MobileOnly'): ?>
                                <i class="fas fa-mobile-alt text-blue-500 text-lg"></i>
                            <?php elseif ($item['Type'] === 'BroadbandOnly'): ?>
                                <i class="fas fa-wifi text-green-500 text-lg"></i>
                            <?php elseif ($item['Type'] === 'TabletOnly'): ?>
                                <i class="fas fa-tablet-alt text-yellow-500 text-lg"></i>
                            <?php else: ?>
                                <i class="fas fa-box text-gray-500 text-lg"></i>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['PackageName']) ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($item['Type']) ?></p>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($item['Description']) ?></p>
                            <?php if ($item['FreeMinutes'] > 0): ?>
                                <p class="text-gray-600 text-sm">Minutes: <?= $item['FreeMinutes'] ?></p>
                            <?php endif; ?>
                            <?php if ($item['FreeSMS'] > 0): ?>
                                <p class="text-gray-600 text-sm">SMS: <?= $item['FreeSMS'] ?></p>
                            <?php endif; ?>
                            <?php if ($item['FreeGB'] > 0): ?>
                                <p class="text-gray-600 text-sm">Data: <?= $item['FreeGB'] ?>GB</p>
                            <?php endif; ?>
                            <p class="text-blue-600 font-bold">£<?= number_format($item['Price'], 2) ?>/mo</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Price: £<?= number_format($item['Price'], 2) ?>/mo</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- and Special Offers -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Apply Discounts</h2>
            <form method="POST" action="checkout.php">
                <!-- Special Offers -->
                <div class="mb-4">
                    <label for="special_offer_id" class="block text-gray-700 font-medium mb-1">Select a Special Offer</label>
                    <select name="special_offer_id" id="special_offer_id" class="w-full p-2 border rounded">
                        <option value="">No Special Offer</option>
                        <?php foreach ($specialOffers as $specialOffer): ?>
                            <option value="<?php echo $specialOffer['SpecialOfferID']; ?>">
                                <?php echo htmlspecialchars($specialOffer['Description']) . " (" . $specialOffer['DiscountPercentage'] . "% off)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Total -->
                <div class="bg-gray-200 p-4 rounded-lg mt-4 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Total</h2>
                    <p class="text-xl font-bold">£<?= number_format($cart_total, 2) ?>/mo</p>
                </div>

                <!-- Buttons -->
                <div class="mt-4 flex justify-between">
                    <a href="cart.php" class="text-blue-600 font-medium">Back to Cart</a>
                    <button type="submit" name="checkout" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Place Order</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</main>