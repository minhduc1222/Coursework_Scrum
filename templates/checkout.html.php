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
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <!-- Image or Fallback -->
                    <?php if (!empty($package['img'])): ?>
                        <img src="<?= htmlspecialchars($package['img']) ?>" alt="<?= htmlspecialchars($package['PackageName']) ?>" class="w-16 h-16 object-cover rounded mr-4">
                    <?php elseif ($package['Type'] === 'Broadband'): ?>
                        <div class="bg-green-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                            <i class="fas fa-wifi text-green-500 text-xl"></i>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                            <span class="text-gray-500"><?= htmlspecialchars($package['Type'][0]) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Package Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($package['PackageName']) ?></h3>
                        <p class="text-gray-600"><?= htmlspecialchars($package['Type']) ?></p>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($package['Description']) ?: 'No description available.' ?></p>
                        <?php if (isset($package['FreeMinutes']) && $package['FreeMinutes'] > 0): ?>
                            <p class="text-gray-600 text-sm">Minutes: <?= $package['FreeMinutes'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($package['FreeSMS']) && $package['FreeSMS'] > 0): ?>
                            <p class="text-gray-600 text-sm">SMS: <?= $package['FreeSMS'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($package['FreeGB']) && $package['FreeGB'] > 0): ?>
                            <p class="text-gray-600 text-sm">Data: <?= $package['FreeGB'] ?>GB</p>
                        <?php endif; ?>
                        <p class="text-blue-600 font-bold package-price" data-original-price="<?= number_format($package['Price'] * (1 - $dealModel->DiscountPercentage / 100), 2) ?>">
                            £<?= number_format($package['Price'] * (1 - $dealModel->DiscountPercentage / 100) * (1 - $special_offer_discount / 100), 2) ?>/mo
                        </p>
                    </div>
                    <div class="text-right mt-2">
                        <p class="text-gray-600">Original: £<?= number_format($package['Price'], 2) ?>/mo</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Special Offers and Payment Method -->
        <form method="POST" action="checkout.php?deal_id=<?= $deal_id ?>" id="checkout-form">
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Apply Additional Discounts</h2>
                <div class="mb-4">
                    <label for="special_offer_id" class="block text-gray-700 font-medium mb-1">Select a Special Offer</label>
                    <select name="special_offer_id" id="special_offer_id" class="w-full p-2 border rounded">
                        <option value="" data-discount="0">No Special Offer</option>
                        <?php foreach ($specialOffers as $specialOffer): ?>
                            <option value="<?php echo $specialOffer['SpecialOfferID']; ?>" 
                                    data-discount="<?php echo $specialOffer['DiscountPercentage']; ?>" 
                                    <?php echo isset($_POST['special_offer_id']) && $_POST['special_offer_id'] == $specialOffer['SpecialOfferID'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($specialOffer['Description']) . " (" . $specialOffer['DiscountPercentage'] . "% off)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Payment Method</h2>
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-medium mb-1">Select Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full p-2 border rounded" required>
                        <?php if ($customer['PaymentMethod']): ?>
                            <option value="<?= htmlspecialchars($customer['PaymentMethod']) ?>" selected>
                                <?= htmlspecialchars($customer['PaymentMethod']) ?>
                            </option>
                        <?php else: ?>
                            <option value="" disabled selected>No payment method available</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Total -->
            <div class="mt-4 p-4 bg-gray-200 rounded-lg" id="total-section">
                <div class="space-y-2 text-right">
                    <div>
                        <span class="text-gray-600 font-medium">Subtotal</span>
                        <span class="ml-4 text-gray-800">£<?= number_format($subtotal, 2) ?>/mo</span>
                    </div>
                    <div>
                        <span class="text-red-600 font-medium">Deal Discount (<?= $dealModel->DiscountPercentage ?>%)</span>
                        <span class="ml-4 text-red-600">-£<?= number_format($subtotal - $total, 2) ?>/mo</span>
                    </div>
                    <div id="special-offer-discount" <?php if ($special_offer_discount == 0): ?>style="display: none;"<?php endif; ?>>
                        <span class="text-red-600 font-medium special-offer-label">Special Offer Discount (<?= $special_offer_discount ?>%)</span>
                        <span class="ml-4 text-red-600 special-offer-amount">-£<?= number_format($special_offer_discount_amount, 2) ?>/mo</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="ml-4 text-lg font-bold text-blue-700 total-amount">£<?= number_format($final_total, 2) ?>/mo</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex justify-between">
                <a href="deal-details.php?deal_id=<?= $deal_id ?>" class="text-blue-600 font-medium">Back to Deal Details</a>
                <button type="submit" name="checkout" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Place Order</button>
            </div>
        </form>
    <?php else: ?>
        <!-- Cart-based Checkout -->
        <div class="space-y-4">
            <?php foreach ($cart_items as $packageID => $item): ?>
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <?php if (!empty($item['img'])): ?>
                            <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['PackageName']) ?>" class="w-16 h-16 object-cover rounded mr-4">
                        <?php elseif ($item['Type'] === 'Broadband'): ?>
                            <div class="bg-green-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                                <i class="fas fa-wifi text-green-500 text-xl"></i>
                            </div>
                        <?php else: ?>
                            <div class="bg-gray-100 rounded w-16 h-16 flex items-center justify-center mr-4">
                                <span class="text-gray-500"><?= htmlspecialchars($item['Type'][0]) ?></span>
                            </div>
                        <?php endif; ?>

                    <!-- Package Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['PackageName']) ?></h3>
                        <p class="text-gray-600"><?= htmlspecialchars($item['Type']) ?> (<?= htmlspecialchars($item['type']) ?>)</p>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($item['Description']) ?: 'No description available.' ?></p>
                        <?php if ($item['type'] === 'Package' && isset($item['FreeMinutes']) && $item['FreeMinutes'] > 0): ?>
                            <p class="text-gray-600 text-sm">Minutes: <?= $item['FreeMinutes'] ?></p>
                        <?php endif; ?>
                        <?php if ($item['type'] === 'Package' && isset($item['FreeSMS']) && $item['FreeSMS'] > 0): ?>
                            <p class="text-gray-600 text-sm">SMS: <?= $item['FreeSMS'] ?></p>
                        <?php endif; ?>
                        <?php if ($item['type'] === 'Package' && isset($item['FreeGB']) && $item['FreeGB'] > 0): ?>
                            <p class="text-gray-600 text-sm">Data: <?= $item['FreeGB'] ?>GB</p>
                        <?php endif; ?>
                        <p class="text-blue-600 font-bold package-price" data-original-price="<?= number_format($item['Price'], 2) ?>">
                            £<?= number_format($item['Price'] * (1 - $special_offer_discount / 100), 2) ?>/mo
                        </p>
                    </div>
                    <div class="text-right mt-2">
                        <p class="text-gray-600">Price: £<?= number_format($item['Price'], 2) ?>/mo</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Customer Information -->
        <div class="bg-white p-4 rounded-lg shadow mb-4 mt-8">
            <h2 class="text-lg font-semibold mb-2">Customer Information</h2>
            <div class="space-y-2">
                <p><span class="font-medium">Name:</span> <?= htmlspecialchars($customer['Name']) ?></p>
                <p><span class="font-medium">Email:</span> <?= htmlspecialchars($customer['Email']) ?></p>
                <p><span class="font-medium">Address:</span> <?= htmlspecialchars($customer['Address']) ?: 'Not provided' ?></p>
                <p><span class="font-medium">Phone:</span> <?= htmlspecialchars($customer['PhoneNumber']) ?: 'Not provided' ?></p>
            </div>
        </div>
        <!-- Special Offers and Payment Method -->
        <form method="POST" action="checkout.php" id="checkout-form">
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Apply Additional Discounts</h2>
                <div class="mb-4">
                    <label for="special_offer_id" class="block text-gray-700 font-medium mb-1">Select a Special Offer</label>
                    <select name="special_offer_id" id="special_offer_id" class="w-full p-2 border rounded">
                        <option value="" data-discount="0">No Special Offer</option>
                        <?php foreach ($specialOffers as $specialOffer): ?>
                            <option value="<?php echo $specialOffer['SpecialOfferID']; ?>" 
                                    data-discount="<?php echo $specialOffer['DiscountPercentage']; ?>" 
                                    <?php echo isset($_POST['special_offer_id']) && $_POST['special_offer_id'] == $specialOffer['SpecialOfferID'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($specialOffer['Description']) . " (" . $specialOffer['DiscountPercentage'] . "% off)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Payment Method</h2>
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-medium mb-1">Select Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full p-2 border rounded" required>
                        <?php if ($customer['PaymentMethod']): ?>
                            <option value="<?= htmlspecialchars($customer['PaymentMethod']) ?>" selected>
                                <?= htmlspecialchars($customer['PaymentMethod']) ?>
                            </option>
                        <?php else: ?>
                            <option value="" disabled selected>No payment method available</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            
            <!-- Total -->
            <div class="mt-4 p-4 bg-gray-200 rounded-lg" id="total-section">
                <div class="space-y-2 text-right">
                    <div>
                        <span class="text-gray-600 font-medium">Subtotal</span>
                        <span class="ml-4 text-gray-800">£<?= number_format($subtotal, 2) ?>/mo</span>
                    </div>
                    <div id="special-offer-discount" <?php if ($special_offer_discount == 0): ?>style="display: none;"<?php endif; ?>>
                        <span class="text-red-600 font-medium special-offer-label">Special Offer Discount (<?= $special_offer_discount ?>%)</span>
                        <span class="ml-4 text-red-600 special-offer-amount">-£<?= number_format($special_offer_discount_amount, 2) ?>/mo</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="ml-4 text-lg font-bold text-blue-700 total-amount">£<?= number_format($final_total, 2) ?>/mo</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 flex justify-between">
                <a href="cart.php" class="text-blue-600 font-medium">Back to Cart</a>
                <button type="submit" formaction="confirm_checkout.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Place Order</button>
            </div>
        </form>
    <?php endif; ?>
</main>

<!-- JavaScript for Real-time Total Updates -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const specialOfferSelect = document.getElementById('special_offer_id');
    const totalSection = document.getElementById('total-section');
    const specialOfferDiscountDiv = document.getElementById('special-offer-discount');
    const specialOfferLabel = specialOfferDiscountDiv.querySelector('.special-offer-label');
    const specialOfferAmount = specialOfferDiscountDiv.querySelector('.special-offer-amount');
    const totalAmount = totalSection.querySelector('.total-amount');
    const packagePrices = document.querySelectorAll('.package-price');

    // Base price for calculations (after deal discount for deal-based checkout)
    const baseTotal = <?php echo json_encode($total); ?>;
    const isDealCheckout = <?php echo json_encode($is_deal_checkout); ?>;
    const dealDiscountPercentage = <?php echo json_encode($dealModel->DiscountPercentage ?? 0); ?>;

    specialOfferSelect.addEventListener('change', () => {
        // Get selected discount percentage
        const selectedOption = specialOfferSelect.options[specialOfferSelect.selectedIndex];
        const discountPercentage = parseFloat(selectedOption.getAttribute('data-discount')) || 0;

        // Calculate new total
        const discountMultiplier = 1 - discountPercentage / 100;
        const newTotal = baseTotal * discountMultiplier;
        const discountAmount = baseTotal - newTotal;

        // Update package prices
        packagePrices.forEach(priceEl => {
            const originalPrice = parseFloat(priceEl.getAttribute('data-original-price'));
            const discountedPrice = originalPrice * discountMultiplier;
            priceEl.textContent = `£${discountedPrice.toFixed(2)}/mo`;
        });

        // Update special offer discount display
        if (discountPercentage > 0) {
            specialOfferLabel.textContent = `Special Offer Discount (${discountPercentage}%)`;
            specialOfferAmount.textContent = `-£${discountAmount.toFixed(2)}/mo`;
            specialOfferDiscountDiv.style.display = 'block';
        } else {
            specialOfferDiscountDiv.style.display = 'none';
        }

        // Update total
        totalAmount.textContent = `£${newTotal.toFixed(2)}/mo`;
    });
});
</script>