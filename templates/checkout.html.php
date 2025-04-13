
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

    <!-- Cart Items -->
    <div class="space-y-4">
        <?php foreach ($_SESSION['cart'] as $packageID => $item): ?>
            <?php
            $packageModel->PackageID = $packageID;
            $packageModel->readOne();
            $subtotal = $packageModel->Price * $item['quantity'];
            ?>
            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div class="flex items-center">
                <!-- Icon Badge based on Package Type -->
                <div class="<?php
                    echo match ($item['package']['Type']) {
                        'Mobile' => 'bg-blue-100',
                        'Broadband' => 'bg-green-100',
                        'Tablet' => 'bg-yellow-100',
                        default => 'bg-gray-200',
                    };
                ?> rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <?php if ($item['package']['Type'] === 'Mobile'): ?>
                        <i class="fas fa-mobile-alt text-blue-500 text-lg"></i>
                    <?php elseif ($item['package']['Type'] === 'Broadband'): ?>
                        <i class="fas fa-wifi text-green-500 text-lg"></i>
                    <?php elseif ($item['package']['Type'] === 'Tablet'): ?>
                        <i class="fas fa-tablet-alt text-yellow-500 text-lg"></i>
                    <?php else: ?>
                        <i class="fas fa-box text-gray-500 text-lg"></i>
                    <?php endif; ?>
                </div>

                <div>
                    <h2 class="text-lg font-semibold"><?php echo htmlspecialchars($packageModel->Type); ?></h2>
                    <p class="text-gray-600"><?php echo htmlspecialchars($packageModel->PackageName); ?></p>
                    <p class="text-blue-600 font-bold">£<?php echo number_format($packageModel->Price, 2); ?>/mo</p>
                </div>
            </div>

            <!-- Subtotal and Quantity -->
            <div class="text-right">
                <p class="text-gray-600">Subtotal: £<?php echo number_format($subtotal, 2); ?>/mo</p>
                <p class="text-gray-600">Quantity: <?php echo $item['quantity']; ?></p>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <!-- Deals and Special Offers -->
    <div class="mt-6">
        <h2 class="text-lg font-semibold mb-2">Apply Discounts</h2>
        <form method="POST" action="checkout.php">
            <!-- Deals -->
            <div class="mb-4">
                <label for="deal_id" class="block text-gray-700 font-medium mb-1">Select a Deal</label>
                <select name="deal_id" id="deal_id" class="w-full p-2 border rounded">
                    <option value="">No Deal</option>
                    <?php foreach ($deals as $deal): ?>
                        <option value="<?php echo $deal['DealID']; ?>">
                            <?php echo htmlspecialchars($deal['DealName']) . " (" . $deal['DiscountPercentage'] . "% off)"; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

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
                <p class="text-xl font-bold">£<?php echo number_format($cartTotal, 2); ?>/mo</p>
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex justify-between">
                <a href="cart.php" class="text-blue-600 font-medium">Back to Cart</a>
                <button type="submit" name="checkout" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Place Order</button>
            </div>
        </form>
    </div>
</main>
