
<div class="p-4">
    <!-- Header with Gradient -->
    <div class="gradient-purple text-white p-4 rounded-t-lg">
        <div class="flex justify-between items-center">
            <a href="packages.php">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
            <h1 class="text-xl font-bold">Mobile Packages</h1>
            <i class="fas fa-share-alt text-white"></i>
        </div>
        <p class="mt-2 text-sm">Find the perfect mobile plan with flexible data, minutes, and texts to suit your needs.</p>
        <div class="flex space-x-2 mt-4">
            <span class="bg-white text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">15% App Discount</span>
            <span class="bg-white text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">Free Setup</span>
        </div>
    </div>

    <!-- Package List -->
    <div class="mt-4 space-y-4">
        <?php while ($row = $mobilePackages->fetch(PDO::FETCH_ASSOC)): ?>
            <?php
            // Fetch features for this package
            $features = $mobileFeature->getFeaturesByPackageId($row['PackageID']);
            $isPopular = $row['IsPopular'] == 1;
            ?>

            <div class="bg-white p-4 rounded-lg shadow-md relative">
                <!-- Popular Badge -->
                <?php if ($isPopular): ?>
                    <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Popular</span>
                <?php endif; ?>

                <!-- Package Name and Contract -->
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row['PackageName']) ?></h2>
                    <span class="text-sm text-gray-500"><?= htmlspecialchars($row['Contract']) ?></span>
                </div>

                <!-- Core Features (Data, Minutes, Texts) -->
                <div class="grid grid-cols-3 gap-2 mt-2">
                    <div class="bg-blue-50 p-2 rounded-lg text-center">
                        <p class="text-sm text-gray-600">DATA</p>
                        <p class="text-base font-semibold"><?= in_array('Unlimited Data', $features) ? 'Unlimited' : htmlspecialchars($row['FreeGB']) . 'GB' ?></p>
                    </div>
                    <div class="bg-red-50 p-2 rounded-lg text-center">
                        <p class="text-sm text-gray-600">MINUTES</p>
                        <p class="text-base font-semibold"><?= in_array('Unlimited Minutes', $features) ? 'Unlimited' : htmlspecialchars($row['FreeMinutes']) ?></p>
                    </div>
                    <div class="bg-green-50 p-2 rounded-lg text-center">
                        <p class="text-sm text-gray-600">TEXTS</p>
                        <p class="text-base font-semibold"><?= in_array('Unlimited Texts', $features) ? 'Unlimited' : htmlspecialchars($row['FreeSMS']) ?></p>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="flex justify-between items-center mt-4">
                    <div>
                        <p class="text-sm text-gray-500 line-through">STANDARD PRICE<br>£<?= number_format($row['old_price'], 2) ?>/mo</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">APP PRICE</p>
                        <p class="text-xl font-bold text-blue-600">£<?= number_format($row['Price'], 2) ?>/mo</p>
                    </div>
                </div>

                <!-- Additional Features -->
                <div class="flex flex-wrap gap-2 mt-4">
                    <?php foreach ($features as $feature): ?>
                        <?php if (!in_array($feature, ['Unlimited Data', 'Unlimited Minutes', 'Unlimited Texts'])): ?>
                            <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full"><?= htmlspecialchars($feature) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <a href="#" class="text-blue-500 text-xs font-semibold px-2 py-1">+2 more</a>
                </div>

                <!-- Setup Fee and Add to Cart -->
                <div class="flex justify-between items-center mt-4">
                    <p class="text-sm text-gray-500">Free setup</p>
                    <a href="package-details.php?id=<?= $row['PackageID'] ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center">
                        View Details
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>