<?php
// packages.html.php
?>

<div class="bg-white">
    <!-- Header -->
    <div class="gradient-blue text-white text-center py-4">
        <h1 class="text-2xl font-bold">Packages</h1>
    </div>

    <!-- Search Bar -->
    <div class="px-4 py-3">
        <div class="relative">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search package" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex justify-start px-4 pb-3 overflow-x-auto space-x-2">
        <a href="packages.php?type=All" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $filter_type === 'All' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?>">All</a>
        <a href="packages.php?type=MobileOnly" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $filter_type === 'MobileOnly' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?>">Mobile</a>
        <a href="packages.php?type=BroadbandOnly" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $filter_type === 'BroadbandOnly' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?>">Broadband</a>
        <a href="packages.php?type=TabletOnly" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $filter_type === 'TabletOnly' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?>">Tablet</a>
        <a href="packages.php?type=BundlesOnly" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $filter_type === 'BundlesOnly' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?>">Bundles</a>
    </div>

    <!-- Featured Bundle -->
    <div class="px-4 pb-4">
        <div class="relative bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg p-4">
            <span class="absolute top-4 right-4 bg-purple-300 text-white text-xs font-bold px-2 py-1 rounded-full text-right">Featured</span>
            <h2 class="text-xl font-bold">Triple Play Bundle</h2>
            <p class="text-sm">Mobile + Broadband + Tablet</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-sm">Save 35%</p>
                <p class="text-2xl font-bold">£79.99/mo</p>
            </div>
            <p class="text-sm line-through">£51.99/mo</p>
        </div>
    </div>

    <!-- Trending Now Section -->
    <div class="px-4 pb-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-semibold">Trending Now</h3>
            <a href="#" class="text-blue-500 text-sm">View All</a>
        </div>
        <div class="flex space-x-3 overflow-x-auto">
            <?php
            $package_stmt->execute();
            $count = 0;
            while ($row = $package_stmt->fetch(PDO::FETCH_ASSOC)) {
                if (!$row['IsPopular']) continue;
                if ($count >= 3) break;
                $count++;
                $icon = $row['Type'] === 'MobileOnly' ? 'fa-mobile-alt' : 
                        ($row['Type'] === 'BroadbandOnly' ? 'fa-wifi' : 
                        ($row['Type'] === 'TabletOnly' ? 'fa-tablet-alt' : 'fa-box'));
            ?>
                <a href="package-details.php?id=<?php echo $row['PackageID']; ?>" class="bg-white border border-gray-200 rounded-lg p-3 w-48 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas <?php echo $icon; ?> text-blue-500 text-xl mr-2"></i>
                            <h4 class="text-base font-semibold"><?php echo htmlspecialchars($row['PackageName']); ?></h4>
                        </div>
                        <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded-full">Popular</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($row['Description']); ?></p>
                    <div class="flex items-center mt-1">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star text-yellow-400 text-sm <?php echo $i < floor($row['Rating']) ? '' : 'text-gray-300'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="text-right mt-2">
                        <p class="text-base font-bold text-blue-600">£<?php echo number_format($row['Price'], 2); ?>/mo</p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    <!-- All Packages Section -->
    <div class="px-4 pb-4">
        <h3 class="text-xl font-semibold mb-3">All Packages</h3>
        <?php
        $package_stmt->execute();
        while ($row = $package_stmt->fetch(PDO::FETCH_ASSOC)) {
            // Fetch tags based on package type
            $tags = [];
            if ($row['Type'] === 'MobileOnly') {
                $tags = $mobileFeature->getFeaturesByPackageId($row['PackageID']);
                if ($row['FreeGB'] > 0 && !in_array('Unlimited Data', $tags)) $tags[] = $row['FreeGB'] . 'GB Data';
            } elseif ($row['Type'] === 'BroadbandOnly') {
                if ($row['DownloadSpeed'] > 0) $tags[] = $row['DownloadSpeed'] . 'Mbps';
                if ($row['UploadSpeed'] > 0) $tags[] = 'Up ' . $row['UploadSpeed'] . 'Mbps';
                $features = $broadbandFeature->getFeaturesByPackageId($row['PackageID']);
                $tags = array_merge($tags, $features);
            } elseif ($row['Type'] === 'TabletOnly') {
                if ($row['FreeGB'] > 0) $tags[] = $row['FreeGB'] . 'GB Data';
                if ($row['Contract']) $tags[] = $row['Contract'];
                $specs = $tabletSpec->getSpecsByPackageId($row['PackageID']);
                foreach ($specs as $spec) {
                    $tags[] = $spec['SpecValue'];
                }
            }
            $icon = $row['Type'] === 'MobileOnly' ? 'fa-mobile-alt' : 
                    ($row['Type'] === 'BroadbandOnly' ? 'fa-wifi' : 
                    ($row['Type'] === 'TabletOnly' ? 'fa-tablet-alt' : 'fa-box'));
        ?>
            <a href="package-details.php?id=<?php echo $row['PackageID']; ?>" class="block bg-white border border-gray-200 rounded-lg p-4 mb-3">
                <div class="flex justify-between items-start">
                    <div class="flex items-start">
                        <i class="fas <?php echo $icon; ?> text-blue-500 text-xl mr-3 mt-1"></i>
                        <div>
                            <div class="flex items-center">
                                <h4 class="text-base font-semibold"><?php echo htmlspecialchars($row['PackageName']); ?></h4>
                                <span class="ml-2 bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded-full <?php echo $row['IsPopular'] ? '' : 'invisible'; ?>" style="float: right;">Popular</span>
                            </div>
                            <div class="flex space-x-1 mt-2 flex-wrap gap-1">
                                <?php
                                foreach ($tags as $tag) {
                                    echo '<span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">' . htmlspecialchars($tag) . '</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <?php if ($row['old_price'] > 0) : ?>
                            <p class="text-sm text-gray-500 line-through">£<?php echo number_format($row['old_price'], 2); ?>/mo</p>
                        <?php endif; ?>
                        <p class="text-lg font-bold text-blue-600">£<?php echo number_format($row['Price'], 2); ?>/mo</p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
</div>