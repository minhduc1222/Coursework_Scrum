<div class="w-full max-w-7xl mx-auto p-2 sm:p-4">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 sm:p-6 rounded-lg mb-4 sm:mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-xl sm:text-2xl font-bold">CSR Customer Management</h1>
            <div class="flex items-center space-x-2">
                <span class="hidden sm:inline-block">CSR: <?= htmlspecialchars($_SESSION['email'] ?? 'Agent') ?></span>
                <a href="../login.php" class="bg-white bg-opacity-20 px-3 py-1 rounded hover:bg-opacity-30 text-sm">
                    Logout
                </a>
            </div>
        </div>
        <p class="mt-2 text-sm sm:text-base">Search, manage customers, and customize packages</p>
    </div>

    <!-- Customer Search Section -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-xl font-semibold mb-3">Customer Search</h2>
        
        <form action="csr_management.php" method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <div class="flex-grow">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by ID, name, or phone number" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    required
                >
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Search
            </button>
        </form>
        
        <?php if (!empty($error)): ?>
        <div class="mt-3 bg-red-100 text-red-700 p-3 rounded-lg">
            <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
        <div class="mt-3 bg-green-100 text-green-700 p-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if ($search_performed && !$customer): ?>
    <!-- No Customer Found - Create New Customer Form -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="bg-yellow-50 text-yellow-700 p-3 rounded-lg mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>No customer found. Please create a new customer profile.
        </div>
        
        <h2 class="text-lg sm:text-xl font-semibold mb-3">Create New Customer</h2>
        
        <form action="csr_management.php" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>
            
            <div class="flex justify-end">
                <input type="hidden" name="create_customer" value="1">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-user-plus mr-2"></i>Create Customer
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?>
    
    <?php if ($customer): ?>
    <!-- Customer Information Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
        <div class="bg-blue-600 text-white p-4">
            <h2 class="text-lg sm:text-xl font-semibold">Customer Information</h2>
            <p class="mt-1 text-sm sm:text-base">ID: <?= htmlspecialchars($customer['CustomerID']) ?></p>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <!-- Customer Avatar -->
                <div class="mb-4 sm:mb-0 sm:mr-6">
                    <?php if (!empty($customer['avt_img'])): ?>
                        <img src="<?= htmlspecialchars($customer['avt_img']) ?>" alt="Customer Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-blue-200">
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-2xl font-bold border-2 border-blue-200">
                            <?= strtoupper(substr($customer['Name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Customer Details -->
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($customer['Name']) ?></h3>
                    
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <div class="text-sm text-gray-500">Email</div>
                            <div class="font-medium"><?= htmlspecialchars($customer['Email']) ?></div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Phone</div>
                            <div class="font-medium"><?= htmlspecialchars($customer['PhoneNumber']) ?></div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Registration Date</div>
                            <div class="font-medium"><?= date('d M Y', strtotime($customer['RegistrationDate'])) ?></div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Customer Type</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($customer['Address'])): ?>
        <div class="mt-3 border-t border-gray-100 px-4 sm:px-6 py-3">
            <div class="text-sm text-gray-500">Address</div>
            <div class="font-medium"><?= htmlspecialchars($customer['Address']) ?></div>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($customer['CreditCardInfo'])): ?>
        <div class="mt-3 border-t border-gray-100 px-4 sm:px-6 py-3">
            <div class="text-sm text-gray-500">Payment Information</div>
            <div class="font-medium">
                <?php 
                $cardLength = strlen($customer['CreditCardInfo']);
                if ($cardLength > 4) {
                    echo '•••• •••• •••• ' . substr($customer['CreditCardInfo'], -4);
                } else {
                    echo 'On file';
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($customer['csv'])): ?>
        <div class="mt-3 border-t border-gray-100 px-4 sm:px-6 py-3">
            <div class="text-sm text-gray-500">CSV Security Code</div>
            <div class="font-medium">•••</div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Tabs for Customer Data -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
        <div class="flex border-b">
            <button class="customer-tab active px-4 py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-tab="subscriptions">
                <i class="fas fa-list-alt mr-2"></i>Current Subscriptions
            </button>
            <button class="customer-tab px-4 py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-tab="orders">
                <i class="fas fa-shopping-cart mr-2"></i>Recent Orders
            </button>
            <button class="customer-tab px-4 py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-tab="usage">
                <i class="fas fa-chart-line mr-2"></i>Usage Data
            </button>
            <button class="customer-tab px-4 py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-tab="recommendations">
                <i class="fas fa-star mr-2"></i>Recommendations
            </button>
        </div>
        
        <!-- Subscriptions Tab -->
        <div id="subscriptions-tab" class="customer-tab-content p-4">
            <?php if (empty($subscription)): ?>
            <div class="text-gray-500 italic">No active subscriptions found for this customer.</div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($subscription as $sub): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($sub['PackageName']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($sub['img'])): ?>
                                    <img src="<?= htmlspecialchars($sub['img']) ?>" alt="<?= htmlspecialchars($sub['PackageName']) ?>" class="w-12 h-12 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-100 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= htmlspecialchars($sub['Type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($sub['StartDate'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= !empty($sub['EndDate']) ? date('d M Y', strtotime($sub['EndDate'])) : 'Ongoing' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                £<?= number_format($sub['Price'], 2) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Orders Tab -->
        <div id="orders-tab" class="customer-tab-content hidden p-4">
            <?php if (empty($orders)): ?>
            <div class="text-gray-500 italic">No recent orders found for this customer.</div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">#<?= htmlspecialchars($order['OrderID']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($order['PackageName']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($order['img'])): ?>
                                    <img src="<?= htmlspecialchars($order['img']) ?>" alt="<?= htmlspecialchars($order['PackageName']) ?>" class="w-12 h-12 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-100 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($order['OrderDate'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                £<?= number_format($order['Price'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php 
                                    switch($order['Status']) {
                                        case 'Completed': echo 'bg-green-100 text-green-800'; break;
                                        case 'Pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'Cancelled': echo 'bg-red-100 text-red-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?= htmlspecialchars($order['Status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Usage Data Tab -->
        <div id="usage-tab" class="customer-tab-content hidden p-4">
            <?php if (empty($usage_data)): ?>
            <div class="text-gray-500 italic">No usage data available for this customer.</div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minutes Used</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SMS Sent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Used (GB)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($usage_data as $usage): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($usage['Month']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($usage['Minutes'] ?? 0) ?></div>
                                <div class="text-xs text-gray-500">minutes</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($usage['SMS'] ?? 0) ?></div>
                                <div class="text-xs text-gray-500">messages</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($usage['DataGB'] ?? 0) ?></div>
                                <div class="text-xs text-gray-500">GB</div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <h3 class="font-medium text-blue-800 mb-2">Usage Summary</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <?php 
                    $avg_minutes = 0;
                    $avg_sms = 0;
                    $avg_data = 0;
                    $count = count($usage_data);
                    
                    foreach ($usage_data as $usage) {
                        $avg_minutes += $usage['Minutes'] ?? 0;
                        $avg_sms += $usage['SMS'] ?? 0;
                        $avg_data += $usage['DataGB'] ?? 0;
                    }
                    
                    if ($count > 0) {
                        $avg_minutes = ceil($avg_minutes / $count);
                        $avg_sms = ceil($avg_sms / $count);
                        $avg_data = ceil($avg_data / $count);
                    }
                    ?>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Average Minutes</div>
                        <div class="text-xl font-semibold text-blue-600"><?= $avg_minutes ?></div>
                        <div class="text-xs text-gray-500">minutes/month</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Average SMS</div>
                        <div class="text-xl font-semibold text-green-600"><?= $avg_sms ?></div>
                        <div class="text-xs text-gray-500">messages/month</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Average Data</div>
                        <div class="text-xl font-semibold text-purple-600"><?= $avg_data ?></div>
                        <div class="text-xs text-gray-500">GB/month</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Recommendations Tab -->
        <div id="recommendations-tab" class="customer-tab-content hidden p-4">
            <?php if (empty($recommended_packages)): ?>
            <div class="text-gray-500 italic">No recommendations available. Insufficient usage data to generate personalized recommendations.</div>
            <?php else: ?>
            <div class="mb-4 bg-yellow-50 p-3 rounded-lg">
                <h3 class="font-medium text-yellow-800 mb-1">Personalized Recommendations</h3>
                <p class="text-sm text-yellow-700">Based on the customer's usage patterns, we recommend the following packages:</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($recommended_packages as $package): ?>
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <?php if (!empty($package['img'])): ?>
                                <img src="<?= htmlspecialchars($package['img']) ?>" alt="<?= htmlspecialchars($package['PackageName']) ?>" class="w-16 h-16 object-cover rounded mb-2">
                            <?php endif; ?>
                            <h3 class="font-medium"><?= htmlspecialchars($package['PackageName']) ?></h3>
                            <div class="mt-2 text-xs">
                                <?php if (!empty($package['FreeMinutes'])): ?>
                                <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-1 mr-1 mb-1">
                                    <i class="fas fa-phone-alt mr-1"></i><?= $package['FreeMinutes'] ?> mins
                                </span>
                                <?php endif; ?>
                                <?php if (!empty($package['FreeSMS'])): ?>
                                <span class="inline-block bg-green-50 text-green-700 rounded px-2 py-1 mr-1 mb-1">
                                    <i class="fas fa-comment mr-1"></i><?= $package['FreeSMS'] ?> SMS
                                </span>
                                <?php endif; ?>
                                <?php if (!empty($package['FreeGB'])): ?>
                                <span class="inline-block bg-purple-50 text-purple-700 rounded px-2 py-1 mb-1">
                                    <i class="fas fa-database mr-1"></i><?= $package['FreeGB'] ?> GB
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">
                                £<?= number_format($package['Price'], 2) ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="button" class="recommend-package text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition" data-id="<?= $package['PackageID'] ?>">
                            <i class="fas fa-plus-circle mr-1"></i>Recommend to Customer
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Customize Package Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
        <div class="bg-blue-600 text-white p-4">
            <h2 class="text-lg sm:text-xl font-semibold">Customize Package</h2>
            <p class="mt-1 text-sm sm:text-base">Select products to build a perfect package for this customer</p>
        </div>
        
        <form id="package-form" method="POST" action="csr_management.php">
            <input type="hidden" name="custom_package" id="custom-package-input" value="">
            <input type="hidden" name="customer_id" value="<?= htmlspecialchars($customer['CustomerID']) ?>">
            
            <!-- Category Tabs -->
            <div class="flex overflow-x-auto border-b">
                <button type="button" class="category-tab active px-3 sm:px-6 py-2 sm:py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-category="mobile">
                    <i class="fas fa-mobile-alt mr-1 sm:mr-2"></i>Mobile
                </button>
                <button type="button" class="category-tab px-3 sm:px-6 py-2 sm:py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-category="broadband">
                    <i class="fas fa-wifi mr-1 sm:mr-2"></i>Broadband
                </button>
                <button type="button" class="category-tab px-3 sm:px-6 py-2 sm:py-3 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" data-category="tablet">
                    <i class="fas fa-tablet-alt mr-1 sm:mr-2"></i>Tablet
                </button>
            </div>
            
            <!-- Products Container -->
            <div class="p-3 sm:p-6">
                <!-- Mobile Products -->
                <div class="category-content" id="mobile-content">
                    <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Mobile Packages</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        <?php foreach ($products['mobile'] as $product): ?>
                        <div class="product-card border rounded-lg p-3 sm:p-4 cursor-pointer hover:shadow-md transition" 
                            data-id="<?= $product['id'] ?>" 
                            data-category="mobile" 
                            data-name="<?= htmlspecialchars($product['name']) ?>" 
                            data-price="<?= $product['price'] ?>">
                            <div class="flex flex-col">
                                <?php if (!empty($product['img'])): ?>
                                    <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-32 object-cover rounded mb-2">
                                <?php endif; ?>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-600 mt-1"><?= htmlspecialchars($product['description']) ?></p>
                                        <div class="mt-2 text-xs">
                                            <?php if (!empty($product['FreeMinutes'])): ?>
                                            <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-1 mr-1 mb-1">
                                                <i class="fas fa-phone-alt mr-1"></i><?= $product['FreeMinutes'] ?> mins
                                            </span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['FreeSMS'])): ?>
                                            <span class="inline-block bg-green-50 text-green-700 rounded px-2 py-1 mr-1 mb-1">
                                                <i class="fas fa-comment mr-1"></i><?= $product['FreeSMS'] ?> SMS
                                            </span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['FreeGB'])): ?>
                                            <span class="inline-block bg-purple-50 text-purple-700 rounded px-2 py-1 mb-1">
                                                <i class="fas fa-database mr-1"></i><?= $product['FreeGB'] ?> GB
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($product['Contract'])): ?>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1"></i><?= $product['Contract'] ?> month contract
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                        <span class="text-xs line-through text-gray-400">£<?= number_format($product['old_price'], 2) ?></span>
                                        <?php endif; ?>
                                        <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">
                                            £<?= number_format($product['price'], 2) ?>
                                        </div>
                                        <?php if (!empty($product['IsPopular'])): ?>
                                        <span class="mt-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Popular</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <?php if (!empty($product['Rating'])): ?>
                                    <div class="text-xs text-yellow-500">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <i class="fas <?= $i < $product['Rating'] ? 'fa-star' : 'fa-star text-gray-300' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="selection-indicator hidden text-green-500">
                                        <i class="fas fa-check-circle"></i> Selected
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Broadband Products -->
                <div class="category-content hidden" id="broadband-content">
                    <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Broadband Packages</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        <?php foreach ($products['broadband'] as $product): ?>
                        <div class="product-card border rounded-lg p-3 sm:p-4 cursor-pointer hover:shadow-md transition" 
                            data-id="<?= $product['id'] ?>" 
                            data-category="broadband" 
                            data-name="<?= htmlspecialchars($product['name']) ?>" 
                            data-price="<?= $product['price'] ?>">
                            <div class="flex flex-col">
                                <?php if (!empty($product['img'])): ?>
                                    <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-32 object-cover rounded mb-2">
                                <?php endif; ?>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-600 mt-1"><?= htmlspecialchars($product['description']) ?></p>
                                        <div class="mt-2 text-xs">
                                            <?php if (!empty($product['DownloadSpeed'])): ?>
                                            <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-1 mr-1 mb-1">
                                                <i class="fas fa-download mr-1"></i><?= $product['DownloadSpeed'] ?> Mbps
                                            </span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['UploadSpeed'])): ?>
                                            <span class="inline-block bg-green-50 text-green-700 rounded px-2 py-1 mb-1">
                                                <i class="fas fa-upload mr-1"></i><?= $product['UploadSpeed'] ?> Mbps
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($product['Contract'])): ?>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1"></i><?= $product['Contract'] ?> month contract
                                        </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['SetupFee'])): ?>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <i class="fas fa-tools mr-1"></i>Setup fee: £<?= number_format($product['SetupFee'], 2) ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                        <span class="text-xs line-through text-gray-400">£<?= number_format($product['old_price'], 2) ?></span>
                                        <?php endif; ?>
                                        <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">
                                            £<?= number_format($product['price'], 2) ?>
                                        </div>
                                        <?php if (!empty($product['IsPopular'])): ?>
                                        <span class="mt-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Popular</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <?php if (!empty($product['Rating'])): ?>
                                    <div class="text-xs text-yellow-500">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <i class="fas <?= $i < $product['Rating'] ? 'fa-star' : 'fa-star text-gray-300' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="selection-indicator hidden text-green-500">
                                        <i class="fas fa-check-circle"></i> Selected
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Tablet Products -->
                <div class="category-content hidden" id="tablet-content">
                    <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Tablet Packages</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        <?php foreach ($products['tablet'] as $product): ?>
                        <div class="product-card border rounded-lg p-3 sm:p-4 cursor-pointer hover:shadow-md transition" 
                            data-id="<?= $product['id'] ?>" 
                            data-category="tablet" 
                            data-name="<?= htmlspecialchars($product['name']) ?>" 
                            data-price="<?= $product['price'] ?>">
                            <div class="flex flex-col">
                                <?php if (!empty($product['img'])): ?>
                                    <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-32 object-cover rounded mb-2">
                                <?php endif; ?>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-600 mt-1"><?= htmlspecialchars($product['description']) ?></p>
                                        <div class="mt-2 text-xs">
                                            <?php if (!empty($product['Brand'])): ?>
                                            <span class="inline-block bg-gray-50 text-gray-700 rounded px-2 py-1 mr-1 mb-1">
                                                <i class="fas fa-tablet-alt mr-1"></i><?= htmlspecialchars($product['Brand']) ?>
                                            </span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['FreeGB'])): ?>
                                            <span class="inline-block bg-purple-50 text-purple-700 rounded px-2 py-1 mb-1">
                                                <i class="fas fa-database mr-1"></i><?= $product['FreeGB'] ?> GB
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($product['Contract'])): ?>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1"></i><?= $product['Contract'] ?> month contract
                                        </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['UpfrontCost'])): ?>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <i class="fas fa-tag mr-1"></i>Upfront cost: £<?= number_format($product['UpfrontCost'], 2) ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                        <span class="text-xs line-through text-gray-400">£<?= number_format($product['old_price'], 2) ?></span>
                                        <?php endif; ?>
                                        <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">
                                            £<?= number_format($product['price'], 2) ?>
                                        </div>
                                        <?php if (!empty($product['IsPopular'])): ?>
                                        <span class="mt-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Popular</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <?php if (!empty($product['Rating'])): ?>
                                    <div class="text-xs text-yellow-500">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <i class="fas <?= $i < $product['Rating'] ? 'fa-star' : 'fa-star text-gray-300' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="selection-indicator hidden text-green-500">
                                        <i class="fas fa-check-circle"></i> Selected
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Package Review Section -->
            <div class="border-t p-4 sm:p-6 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Package Review</h2>
                
                <div id="selected-items-container">
                    <div id="no-items-message" class="text-gray-500 italic text-sm sm:text-base">
                        No items selected yet. Please select products from the categories above.
                    </div>
                    
                    <div id="selected-items" class="space-y-2 sm:space-y-3 hidden">
                        <!-- Selected items will be displayed here via JavaScript -->
                    </div>
                    
                    <div class="mt-4 pt-3 sm:pt-4 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="mb-3 sm:mb-0">
                            <span class="text-base sm:text-lg font-semibold">Total:</span>
                            <span class="text-base sm:text-lg font-bold text-blue-600" id="total-price">£0.00</span>
                        </div>
                        
                        <div class="flex space-x-2 sm:space-x-3 w-full sm:w-auto">
                            <button type="button" id="clear-selections" class="flex-1 sm:flex-none px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm sm:text-base">
                                Clear All
                            </button>
                            <button type="submit" id="add-to-cart" class="flex-1 sm:flex-none px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base" disabled>
                                Add to Customer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Customer tab switching functionality
    const customerTabs = document.querySelectorAll('.customer-tab');
    const customerTabContents = document.querySelectorAll('.customer-tab-content');
    
    customerTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            customerTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            customerTabContents.forEach(content => content.classList.add('hidden'));
            const tabName = this.getAttribute('data-tab');
            document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        });
    });
    
    // Package category tab switching functionality
    const categoryTabs = document.querySelectorAll('.category-tab');
    const categoryContents = document.querySelectorAll('.category-content');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            categoryContents.forEach(content => content.classList.add('hidden'));
            const category = this.getAttribute('data-category');
            document.getElementById(`${category}-content`).classList.remove('hidden');
        });
    });
    
    // Variables to store selected products
    const selectedProducts = {
        mobile: [],
        broadband: [],
        tablet: []
    };
    
    // Product selection functionality
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const category = this.getAttribute('data-category');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));
            
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                this.querySelector('.selection-indicator').classList.add('hidden');
                const index = selectedProducts[category].findIndex(p => p.id === productId);
                if (index !== -1) {
                    selectedProducts[category].splice(index, 1);
                }
            } else {
                this.classList.add('selected');
                this.querySelector('.selection-indicator').classList.remove('hidden');
                selectedProducts[category].push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    category: category
                });
            }
            
            updatePackageReview();
        });
    });
    
    // Update package review
    function updatePackageReview() {
        const selectedItemsContainer = document.getElementById('selected-items');
        const noItemsMessage = document.getElementById('no-items-message');
        const totalPriceElement = document.getElementById('total-price');
        const addToCartButton = document.getElementById('add-to-cart');
        const customPackageInput = document.getElementById('custom-package-input');
        
        selectedItemsContainer.innerHTML = '';
        
        let totalPrice = 0;
        let hasItems = false;
        const selectedProductIds = [];
        
        Object.keys(selectedProducts).forEach(category => {
            if (selectedProducts[category].length > 0) {
                hasItems = true;
                
                const categoryHeader = document.createElement('h3');
                categoryHeader.className = 'font-medium text-gray-700 mt-3 mb-2 text-sm sm:text-base';
                categoryHeader.textContent = getCategoryDisplayName(category);
                selectedItemsContainer.appendChild(categoryHeader);
                
                selectedProducts[category].forEach(product => {
                    totalPrice += product.price;
                    selectedProductIds.push(product.id);
                    
                    const itemElement = document.createElement('div');
                    itemElement.className = 'flex justify-between items-center p-2 sm:p-3 border rounded-lg text-sm';
                    itemElement.innerHTML = `
                        <div>
                            <span class="font-medium">${product.name}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2 sm:mr-3">£${product.price.toFixed(2)}</span>
                            <button type="button" class="text-red-500 hover:text-red-700 remove-item" data-id="${product.id}" data-category="${product.category}">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    `;
                    selectedItemsContainer.appendChild(itemElement);
                });
            }
        });
        
        if (hasItems) {
            selectedItemsContainer.classList.remove('hidden');
            noItemsMessage.classList.add('hidden');
            addToCartButton.disabled = false;
            
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const productId = this.getAttribute('data-id');
                    const category = this.getAttribute('data-category');
                    
                    const index = selectedProducts[category].findIndex(p => p.id === productId);
                    if (index !== -1) {
                        selectedProducts[category].splice(index, 1);
                    }
                    
                    const card = document.querySelector(`.product-card[data-id="${productId}"][data-category="${category}"]`);
                    if (card) {
                        card.classList.remove('selected');
                        card.querySelector('.selection-indicator').classList.add('hidden');
                    }
                    
                    updatePackageReview();
                });
            });
        } else {
            selectedItemsContainer.classList.add('hidden');
            noItemsMessage.classList.remove('hidden');
            addToCartButton.disabled = true;
        }
        
        totalPriceElement.textContent = `£${totalPrice.toFixed(2)}`;
        customPackageInput.value = selectedProductIds.join(',');
    }
    
    // Helper function to get display name for category
    function getCategoryDisplayName(category) {
        switch(category) {
            case 'mobile': return 'Mobile Products';
            case 'broadband': return 'Broadband Products';
            case 'tablet': return 'Tablet Products';
            default: return category.charAt(0).toUpperCase() + category.slice(1);
        }
    }
    
    // Clear selections button
    const clearSelectionsButton = document.getElementById('clear-selections');
    if (clearSelectionsButton) {
        clearSelectionsButton.addEventListener('click', function() {
            Object.keys(selectedProducts).forEach(category => {
                selectedProducts[category] = [];
            });
            
            document.querySelectorAll('.product-card.selected').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('.selection-indicator').classList.add('hidden');
            });
            
            updatePackageReview();
        });
    }
    
    // Recommend package buttons
    const recommendButtons = document.querySelectorAll('.recommend-package');
    recommendButtons.forEach(button => {
        button.addEventListener('click', function() {
            const packageId = this.getAttribute('data-id');
            
            fetch('csr_management.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `recommend_package=${packageId}&customer_id=<?= htmlspecialchars($customer['CustomerID']) ?>`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Package recommendation sent to customer successfully!');
                } else {
                    alert('Error: ' + (data.message || 'Failed to send recommendation'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the recommendation.');
            });
        });
    });
    
    // Form submission validation
    const packageForm = document.getElementById('package-form');
    if (packageForm) {
        packageForm.addEventListener('submit', function(e) {
            const customPackageInput = document.getElementById('custom-package-input');
            
            if (!customPackageInput.value) {
                e.preventDefault();
                alert('Please select at least one product before adding to customer.');
                return false;
            }
            
            return true;
        });
    }
    
    // Initialize the first tab as active
    if (document.querySelector('.customer-tab.active') === null && customerTabs.length > 0) {
        customerTabs[0].click();
    }
});
</script>