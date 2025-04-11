
<!-- Header with Back Button -->
<header class="gradient-green text-white p-6">
    <div class="container mx-auto">
        <div class="flex items-center mb-4">
            <a href="index.php" class="mr-2"><i class="fas fa-arrow-left"></i></a>
            <h1 class="text-2xl font-bold">Broadband Packages</h1>
        </div>
        <p class="mb-4">Superfast Broadband</p>
        <p class="text-sm mb-2">Reliable connections with speeds up to 900 Mbps. Perfect for streaming, gaming, and working from home.</p>
        <div class="flex space-x-2 mt-4">
            <span class="bg-white text-green-500 px-3 py-1 rounded-full text-sm">15% App Discount</span>
            <span class="bg-white text-green-500 px-3 py-1 rounded-full text-sm">Free Setup</span>
        </div>
    </div>
</header>

<!-- Broadband Packages -->
<section class="py-6">
    <div class="container mx-auto px-4">
        <?php if ($broadbandPackages->rowCount() > 0): ?>
            <?php while ($pkg = $broadbandPackages->fetch(PDO::FETCH_ASSOC)): ?>
                <?php
                    // Get features for the package
                    $features = $packageFeature->getFeaturesByPackageId($pkg['PackageID']);
                ?>
                <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
                    <div class="bg-green-500 text-white p-4 flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        <div>
                            <h3 class="font-bold"><?= htmlspecialchars($pkg['PackageName']) ?></h3>
                            <p class="text-sm"><?= htmlspecialchars($pkg['Contract']) ?></p>
                        </div>
                        <?php if ($pkg['IsPopular']): ?>
                            <span class="ml-auto bg-white text-green-500 px-2 py-1 rounded-lg text-xs">Popular</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between mb-4">
                            <div>
                                <i class="fas fa-arrow-down text-red-500 mr-1"></i>
                                <span class="font-bold"><?= htmlspecialchars($pkg['DownloadSpeed']) ?> Mbps</span>
                            </div>
                            <div>
                                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                <span class="font-bold"><?= htmlspecialchars($pkg['UploadSpeed']) ?> Mbps</span>
                            </div>
                        </div>
                        <div class="border-t border-b border-gray-200 py-4 mb-4">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">STANDARD PRICE</p>
                                    <p class="text-gray-500 line-through">£<?= number_format($pkg['StandardPrice'], 2) ?>/mo</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500 text-sm">APP PRICE</p>
                                    <p class="text-green-500 font-bold text-xl">£<?= number_format($pkg['Price'], 2) ?>/mo</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php if (!empty($features)): ?>
                                <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm"><?= htmlspecialchars($feature) ?></span>
                                <?php endforeach; ?>
                                <?php if (count($features) > 3): ?>
                                    <button class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">+<?= count($features) - 3 ?> more</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">No features listed</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-gray-500"><?= $pkg['SetupFee'] == 0 ? 'Free setup' : 'Setup Fee: £' . number_format($pkg['SetupFee'], 2) ?></p>
                            <a href="package-details.php?id=<?= $pkg['PackageID'] ?>" class="text-green-500 flex items-center">
                                View Details
                                <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-gray-500">No broadband packages available.</p>
        <?php endif; ?>
    </div>
</section>



    <!-- Scripts -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> -->
