<section class="py-6">
    <div class="container mx-auto px-4">
        <!-- Header with Gradient -->
        <div class="gradient-green text-white p-6 rounded-lg mb-6">
            <div class="flex justify-between items-center">
                <a href="packages.php">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
                <h2 class="text-xl font-bold">Tablet Packages</h2>
                <i class="fas fa-tablet-alt text-white"></i>
            </div>
            <p class="mt-2 text-sm">Get the newest tablets with flexible data plans. Perfect for work and entertainment on the go.</p>
            <div class="flex space-x-2 mt-4">
                <span class="bg-white text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">15% App Discount</span>
                <span class="bg-white text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">Free Delivery</span>
            </div>
        </div>

        <!-- Package List -->
        <div class="mt-4 space-y-4">
            <?php if ($tabletPackages->rowCount() > 0): ?>
                <?php while ($pkg = $tabletPackages->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php
                        $tabletFeature = new TabletFeature($pdo); // Ensure $pdo is available
                        $features = $tabletFeature->getFeaturesByPackageId($pkg['PackageID']);
                        $isPopular = $pkg['IsPopular'] == 1;
                    ?>
                    <div class="bg-white p-4 rounded-lg shadow-md relative">
                        <!-- Full-Width Image -->
                        <?php if (!empty($pkg['img'])): ?>
                            <img src="<?= htmlspecialchars($pkg['img']) ?>" alt="<?= htmlspecialchars($pkg['PackageName']) ?>" class="w-full h-48 object-cover rounded-t-lg">
                        <?php endif; ?>

                        <!-- Popular Badge -->
                        <?php if ($isPopular): ?>
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Popular</span>
                        <?php endif; ?>

                        <!-- Title, Brand, and Description -->
                        <div class="mt-2">
                            <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($pkg['PackageName']) ?></h2>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($pkg['Brand']) ?></p>
                            <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($pkg['Description']) ?: 'No description available.' ?></p>
                        </div>

                        <!-- Data & Contract -->
                        <div class="grid grid-cols-2 gap-4 text-center mt-4">
                            <div class="bg-pink-50 p-2 rounded-lg">
                                <p class="text-sm text-gray-600">DATA</p>
                                <p class="text-base font-semibold"><?= htmlspecialchars($pkg['FreeGB']) ?>GB</p>
                            </div>
                            <div class="bg-purple-50 p-2 rounded-lg">
                                <p class="text-sm text-gray-600">CONTRACT</p>
                                <p class="text-base font-semibold"><?= htmlspecialchars($pkg['Contract']) ?></p>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <p class="text-sm text-gray-500 line-through">STANDARD<br>£<?= number_format($pkg['old_price'], 2) ?>/mo</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">APP PRICE</p>
                                <p class="text-xl font-bold text-purple-600">£<?= number_format($pkg['Price'], 2) ?>/mo</p>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="flex flex-wrap gap-2 mt-4">
                            <?php if (!empty($features)): ?>
                                <?php foreach ($features as $f): ?>
                                    <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full"><?= htmlspecialchars($f) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-xs text-gray-400">No features listed</span>
                            <?php endif; ?>
                        </div>

                        <!-- Upfront Cost and View -->
                        <div class="flex justify-between items-center mt-4">
                            <p class="text-sm text-gray-500">Upfront cost £<?= number_format($pkg['UpfrontCost'], 2) ?></p>
                            <a href="package-details.php?id=<?= (int)$pkg['PackageID'] ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center">
                                View Deal
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-500">No tablet packages available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>