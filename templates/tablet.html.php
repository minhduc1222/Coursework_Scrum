
<section class="py-6">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="gradient-header text-white p-6 rounded-lg mb-6">
            <h2 class="text-3xl font-bold mb-2">Tablet Packages</h2>
            <p class="text-sm">Get the newest tablets with flexible data plans.</p>
            <p class="text-sm">Perfect for work and entertainment on the go.</p>
            <div class="flex gap-2 mt-4">
                <span class="bg-white text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">15% App Discount</span>
                <span class="bg-white text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Free Delivery</span>
            </div>
        </div>

        <!-- Tablet Packages List -->
        <?php if ($tabletPackages->rowCount() > 0): ?>
            <?php while ($pkg = $tabletPackages->fetch(PDO::FETCH_ASSOC)): ?>
                <?php
                    // Get specifications for the package
                    $specifications = $tabletSpec->getSpecsByPackageId($pkg['PackageID']);
                ?>
                <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden relative">
                    <!-- Tablet Image and Popular Badge -->
                    <div class="relative">
                        <img src="<?= htmlspecialchars($pkg['ImageURL']) ?>" alt="<?= htmlspecialchars($pkg['PackageName']) ?>" class="w-full h-48 object-contain p-4">
                        <?php if ($pkg['IsPopular']): ?>
                            <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm">Popular</span>
                        <?php endif; ?>
                    </div>

                    <!-- Package Details -->
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($pkg['PackageName']) ?></h3>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($pkg['Brand']) ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-red-500 font-bold text-xl">From £<?= number_format($pkg['Price'], 2) ?>/mo</p>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center mb-2">
                            <?php
                                $rating = floatval($pkg['Rating']);
                                $fullStars = floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - $fullStars - $halfStar;
                            ?>
                            <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                <i class="fas fa-star text-yellow-400"></i>
                            <?php endfor; ?>
                            <?php if ($halfStar): ?>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            <?php endif; ?>
                            <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                                <i class="far fa-star text-yellow-400"></i>
                            <?php endfor; ?>
                            <span class="ml-1 text-gray-600"><?= number_format($pkg['Rating'], 1) ?></span>
                        </div>

                        <!-- Data and Contract -->
                        <div class="flex justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-wifi text-pink-400 mr-1"></i>
                                <span class="text-gray-600">Data</span>
                                <span class="ml-1 font-bold"><?= htmlspecialchars($pkg['FreeGB']) ?>GB</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-pink-400 mr-1"></i>
                                <span class="text-gray-600">Contract</span>
                                <span class="ml-1 font-bold"><?= htmlspecialchars($pkg['Contract']) ?></span>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="mb-4">
                            <p class="text-gray-600 font-semibold">Specifications</p>
                            <ul class="list-none">
                                <?php if (!empty($specifications)): ?>
                                    <?php foreach ($specifications as $spec): ?>
                                        <li class="flex items-center text-gray-600 text-sm">
                                            <i class="fas fa-check text-gray-400 mr-2"></i>
                                            <?= htmlspecialchars($spec['SpecName'] . ': ' . $spec['SpecValue']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-gray-600 text-sm">No specifications listed</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Upfront Cost and View Deal Button -->
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600">Upfront cost £<?= number_format($pkg['UpfrontCost'], 2) ?></p>
                            <a href="package-details.php?id=<?= $pkg['PackageID'] ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center">
                                View Deal
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-gray-500">No tablet packages available.</p>
        <?php endif; ?>
    </div>
</section>
