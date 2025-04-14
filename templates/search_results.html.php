
<div class="max-w-md mx-auto">
    <!-- Search header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-700 p-4 flex items-center">
        <!-- Back button -->
        <a href="javascript:history.back()" class="text-white mr-4">
            <i class="fas fa-arrow-left"></i>
        </a>
        
        <!-- Search input -->
        <div class="relative flex-grow">
            <form action="search_results.php" method="GET" class="w-full">
                <div class="flex items-center bg-white rounded-full p-2 shadow-md">
                    <i class="fas fa-search text-gray-400 ml-2 mr-2"></i>
                    <input type="text" name="query" value="<?= htmlspecialchars($query) ?>" 
                        placeholder="Search packages, devices, features..." 
                        class="w-full outline-none bg-transparent">
                    <button type="button" class="text-gray-400 mr-2">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results content -->
    <div class="p-4">
        <!-- Results summary -->
        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800">
                <?= $totalResults ?> results for "<?= htmlspecialchars($query) ?>"
            </h1>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4">
                    <p><?= $error ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Packages Results -->
        <?php if (count($packages) > 0): ?>
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Packages</h2>
                <div class="space-y-3">
                    <?php foreach ($packages as $package): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border hover:shadow-lg transition">
                            <div class="p-4">
                                <h3 class="text-lg font-bold mb-2"><?= htmlspecialchars($package['PackageName']) ?></h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($package['Description']) ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-blue-600">£<?= number_format($package['Price'], 2) ?>/mo</span>
                                    <a href="package_details.php?id=<?= $package['PackageID'] ?>" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Deals Results -->
        <?php if (count($deals) > 0): ?>
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Deals</h2>
                <div class="space-y-3">
                    <?php foreach ($deals as $deal): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border hover:shadow-lg transition">
                            <div class="p-4">
                                <h3 class="text-lg font-bold mb-2"><?= htmlspecialchars($deal['DealName']) ?></h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    <?= htmlspecialchars($deal['Description']) ?>
                                </p>
                                <p class="text-sm text-gray-500 mb-2">
                                    <span class="font-medium">Discount:</span> <?= htmlspecialchars($deal['DiscountPercentage']) ?>%
                                </p>
                                <p class="text-sm text-gray-500 mb-4">
                                    <span class="font-medium">Valid:</span>
                                    <?= htmlspecialchars($deal['ValidFrom']) ?> → <?= htmlspecialchars($deal['ValidTo']) ?>
                                </p>
                                <div class="flex justify-end">
                                    <a href="deal-details.php?id=<?= $deal['DealID'] ?>" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm">
                                        View Deal
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <!-- No Results -->
        <?php if ($totalResults === 0 && !isset($error)): ?>
            <div class="text-center py-8">
                <i class="fas fa-search text-gray-300 text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">No results found</h2>
                <p class="text-gray-500 mb-6">We couldn't find any matches for "<?= htmlspecialchars($query) ?>"</p>
                <div class="max-w-md mx-auto">
                    <h3 class="font-semibold text-gray-700 mb-2">Suggestions:</h3>
                    <ul class="text-gray-600 text-left list-disc pl-8">
                        <li>Check your spelling</li>
                        <li>Try more general keywords</li>
                        <li>Try different keywords</li>
                        <li>Browse categories instead</li>
                    </ul>
                </div>
                <a href="search.php" class="inline-block mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Back to Search
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="query"]');
        
        // Auto-focus the search input
        searchInput.focus();
        
        // Submit form on Enter key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    });
</script>
