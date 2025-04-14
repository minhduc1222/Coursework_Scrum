
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
                    <input type="text" name="query" placeholder="Search packages, devices, features..." 
                        class="w-full outline-none bg-transparent">
                    <button type="button" class="text-gray-400 mr-2">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Searches -->
    <div class="p-4">
        <div class="flex justify-between items-center mb-3">
            <div class="flex items-center">
                <i class="far fa-clock text-gray-500 mr-2"></i>
                <h2 class="text-lg font-semibold">Recent Searches</h2>
            </div>
            <button class="text-blue-500 text-sm">Clear All</button>
        </div>
        
        <div class="flex flex-wrap gap-2 mb-6">
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <i class="far fa-clock text-gray-500 mr-2"></i>
                <span>unlimited data</span>
            </div>
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <i class="far fa-clock text-gray-500 mr-2"></i>
                <span>fiber broadband</span>
            </div>
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <i class="far fa-clock text-gray-500 mr-2"></i>
                <span>ipad</span>
            </div>
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <i class="far fa-clock text-gray-500 mr-2"></i>
                <span>5G</span>
            </div>
        </div>
        
        <!-- Popular Searches -->
        <div class="mb-6">
            <div class="flex items-center mb-3">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                <h2 class="text-lg font-semibold">Popular Searches</h2>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>unlimited data</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>fiber broadband</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>5G</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>tablet deals</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>samsung</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>apple</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>budget friendly</span>
                </div>
                <div class="flex items-center bg-blue-50 rounded-full px-4 py-2">
                    <i class="fas fa-bolt text-blue-500 mr-2"></i>
                    <span>family plans</span>
                </div>
            </div>
        </div>
        
        <!-- Browse Categories -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Browse Categories</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <!-- Mobile Category -->
                <a href="mobile.php" class="border rounded-lg p-4 flex items-center bg-blue-50">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-mobile-alt text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Mobile</h3>
                        <p class="text-sm text-gray-600">Plans & devices</p>
                    </div>
                </a>
                
                <!-- Broadband Category -->
                <a href="broadband.php" class="border rounded-lg p-4 flex items-center bg-green-50">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-wifi text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Broadband</h3>
                        <p class="text-sm text-gray-600">Internet packages</p>
                    </div>
                </a>
                
                <!-- Tablet Category -->
                <a href="tablet.php" class="border rounded-lg p-4 flex items-center bg-purple-50">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-tablet-alt text-purple-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Tablet</h3>
                        <p class="text-sm text-gray-600">Devices & data</p>
                    </div>
                </a>
                
                <!-- Bundles Category -->
                <a href="packages.php" class="border rounded-lg p-4 flex items-center bg-orange-50">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-box text-orange-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Bundles</h3>
                        <p class="text-sm text-gray-600">Combined packages</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Add functionality for the search tags
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="query"]');
        const searchTags = document.querySelectorAll('.bg-gray-100, .bg-blue-50');
        
        searchTags.forEach(tag => {
            tag.addEventListener('click', function() {
                const searchText = this.querySelector('span').textContent;
                searchInput.value = searchText;
                // Optional: auto-submit the form
                // this.closest('form').submit();
            });
        });
        
        // Clear all recent searches
        const clearButton = document.querySelector('button.text-blue-500');
        clearButton.addEventListener('click', function() {
            const recentSearches = document.querySelectorAll('.bg-gray-100');
            recentSearches.forEach(search => {
                search.style.display = 'none';
            });
        });
    });
</script>
