<!-- Header -->
<header class="bg-purple-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Create Custom Package</h1>
    <div>
        <a href="profile.php" class="text-white">
            <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </a>
    </div>
</header>

<!-- Main Content -->
<main class="p-4">
    <!-- Success/Error Messages -->
    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Custom Package Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-4">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Build Your Package</h2>
        <!-- Error Message Container -->
        <div id="error_message" class="hidden px-4 py-2 bg-red-100 text-red-700 rounded mb-4"></div>
        <form method="POST" action="custom_package.php" class="space-y-4" onsubmit="return validateForm()">
            <!-- Package Name -->
            <div>
                <label for="package_name" class="block text-gray-700 font-medium mb-1">Package Name:</label>
                <input type="text" name="package_name" id="package_name" value="My Custom Package" required class="w-full p-2 border rounded">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description:</label>
                <textarea name="description" id="description" class="w-full p-2 border rounded" rows="4">Custom package created by user</textarea>
            </div>

            <!-- Package Type -->
            <div>
                <label for="type" class="block text-gray-700 font-medium mb-1">Package Type:</label>
                <select name="type" id="type" required class="w-full p-2 border rounded" onchange="updateFormFields()">
                    <option value="">Select Type</option>
                    <option value="Mobile">Mobile</option>
                    <option value="Broadband">Broadband</option>
                    <option value="Tablet">Tablet</option>
                </select>
            </div>

            <!-- Mobile Fields -->
            <div id="mobile_fields" class="hidden space-y-4">
                <div>
                    <label for="free_minutes" class="block text-gray-700 font-medium mb-1">Free Minutes:</label>
                    <select name="free_minutes" id="free_minutes" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 Minutes</option>
                        <option value="100">100 Minutes</option>
                        <option value="500">500 Minutes</option>
                        <option value="1000">1000 Minutes</option>
                    </select>
                </div>
                <div>
                    <label for="free_sms" class="block text-gray-700 font-medium mb-1">Free SMS:</label>
                    <select name="free_sms" id="free_sms" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 SMS</option>
                        <option value="100">100 SMS</option>
                        <option value="500">500 SMS</option>
                        <option value="1000">1000 SMS</option>
                    </select>
                </div>
                <div>
                    <select name="free_gb_mobile" id="free_gb_mobile" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 GB</option>
                        <option value="5">5 GB</option>
                        <option value="10">10 GB</option>
                        <option value="20">20 GB</option>
                    </select>
                </div>
            </div>

            <!-- Broadband Fields -->
            <div id="broadband_fields" class="hidden space-y-4">
                <div>
                    <label for="download_speed" class="block text-gray-700 font-medium mb-1">Download Speed (Mbps):</label>
                    <select name="download_speed" id="download_speed" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 Mbps</option>
                        <option value="50">50 Mbps</option>
                        <option value="100">100 Mbps</option>
                        <option value="500">500 Mbps</option>
                    </select>
                </div>
                <div>
                    <label for="upload_speed" class="block text-gray-700 font-medium mb-1">Upload Speed (Mbps):</label>
                    <select name="upload_speed" id="upload_speed" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 Mbps</option>
                        <option value="10">10 Mbps</option>
                        <option value="40">40 Mbps</option>
                        <option value="100">100 Mbps</option>
                    </select>
                </div>
            </div>

            <!-- Tablet Fields -->
            <div id="tablet_fields" class="hidden space-y-4">
                <div>
                    <select name="free_gb_tablet" id="free_gb_tablet" class="w-full p-2 border rounded" onchange="calculatePrice()">
                        <option value="0">0 GB</option>
                        <option value="5">5 GB</option>
                        <option value="10">10 GB</option>
                        <option value="20">20 GB</option>
                    </select>
                </div>
            </div>

            <!-- Common Fields -->
            <div>
                <label for="contract" class="block text-gray-700 font-medium mb-1">Contract Length (Months):</label>
                <select name="contract" id="contract" class="w-full p-2 border rounded" onchange="calculatePrice()">
                    <option value="1">1 Month</option>
                    <option value="12">12 Months</option>
                    <option value="24">24 Months</option>
                </select>
            </div>

            <!-- Price Display -->
            <div class="text-center">
                <p class="text-lg font-bold">Estimated Price: £<span id="estimated_price">10.00</span>/mo</p>
            </div>

            <button type="submit" name="create_package" class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600">Create Package</button>
        </form>
    </div>

    <!-- Display Customer's Custom Packages -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Your Custom Packages</h2>
        <?php if (empty($custom_packages)): ?>
            <p class="text-gray-600">You haven't created any custom packages yet.</p>
        <?php else: ?>
            <?php foreach ($custom_packages as $package): ?>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <?php
                            $icon_class = '';
                            switch ($package['Type']) {
                                case 'Mobile':
                                    $icon_class = 'fas fa-mobile-alt text-blue-500';
                                    break;
                                case 'Broadband':
                                    $icon_class = 'fas fa-wifi text-green-500';
                                    break;
                                case 'Tablet':
                                    $icon_class = 'fas fa-tablet-alt text-purple-500';
                                    break;
                            }
                            ?>
                            <i class="<?php echo $icon_class; ?> mr-2"></i>
                            <h4 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($package['PackageName']); ?></h4>
                        </div>
                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($package['Type']); ?></span>
                    </div>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($package['Description']); ?></p>
                    <?php if ($package['Type'] === 'Mobile'): ?>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm">Minutes: <?php echo htmlspecialchars($package['FreeMinutes']); ?></p>
                            <p class="text-sm">SMS: <?php echo htmlspecialchars($package['FreeSMS']); ?></p>
                            <p class="text-sm">Data: <?php echo htmlspecialchars($package['FreeGB']); ?> GB</p>
                        </div>
                    <?php elseif ($package['Type'] === 'Broadband'): ?>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm">Download: <?php echo htmlspecialchars($package['DownloadSpeed']); ?> Mbps</p>
                            <p class="text-sm">Upload: <?php echo htmlspecialchars($package['UploadSpeed']); ?> Mbps</p>
                        </div>
                    <?php elseif ($package['Type'] === 'Tablet'): ?>
                        <div class="flex justify-between mt-2">
                            <p class="text-sm">Data: <?php echo htmlspecialchars($package['FreeGB']); ?> GB</p>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-sm">Contract: <?php echo htmlspecialchars($package['Contract']); ?> months</p>
                        <p class="text-lg font-bold text-purple-600">£<?php echo number_format($package['Price'], 2); ?>/mo</p>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <!-- Remove Link -->
                        <form method="POST" action="custom_package.php">
                            <input type="hidden" name="package_id" value="<?php echo $package['PackageID']; ?>">
                            <button type="submit" name="delete_package" class="text-red-500 text-sm underline hover:text-red-700">Remove</button>
                        </form>
                        <div class="flex space-x-2">
                            <?php if (in_array($package['Type'], $cart_types)): ?>
                                <button class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed" disabled>Package Type Already in Cart</button>
                            <?php else: ?>
                                <a href="cart.php?action=add_custom&id=<?php echo $package['PackageID']; ?>&type=<?php echo $package['Type']; ?>" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<!-- JavaScript for Dynamic Form and Price Calculation -->
<script>
function updateFormFields() {
    const type = document.getElementById('type').value;
    document.getElementById('mobile_fields').classList.add('hidden');
    document.getElementById('broadband_fields').classList.add('hidden');
    document.getElementById('tablet_fields').classList.add('hidden');

    if (type === 'Mobile') {
        document.getElementById('mobile_fields').classList.remove('hidden');
    } else if (type === 'Broadband') {
        document.getElementById('broadband_fields').classList.remove('hidden');
    } else if (type === 'Tablet') {
        document.getElementById('tablet_fields').classList.remove('hidden');
    }

    calculatePrice();
}

function calculatePrice() {
    const type = document.getElementById('type').value;
    const contract = parseInt(document.getElementById('contract').value);
    let basePrice = 10.00;
    let price = basePrice;

    if (type === 'Mobile') {
        const minutes = parseInt(document.getElementById('free_minutes').value);
        const sms = parseInt(document.getElementById('free_sms').value);
        const gb = parseInt(document.getElementById('free_gb_mobile').value);
        price += minutes * 0.05;
        price += sms * 0.03;
        price += gb * 2.00;
    } else if (type === 'Broadband') {
        const download = parseInt(document.getElementById('download_speed').value);
        const upload = parseInt(document.getElementById('upload_speed').value);
        price += download * 0.30;
        price += upload * 0.20;
    } else if (type === 'Tablet') {
        const gb = parseInt(document.getElementById('free_gb_tablet').value);
        price += gb * 3.00;
    }

    if (contract === 24) {
        price *= 0.9;
    } else if (contract === 12) {
        price *= 0.95;
    }

    document.getElementById('estimated_price').textContent = price.toFixed(2);
}

function validateForm() {
    const type = document.getElementById('type').value;
    let valid = true;
    let errorMessage = '';
    const errorDiv = document.getElementById('error_message');

    if (type === 'Mobile') {
        const minutes = parseInt(document.getElementById('free_minutes').value);
        const sms = parseInt(document.getElementById('free_sms').value);
        const gb = parseInt(document.getElementById('free_gb_mobile').value);
        if (minutes === 0 || sms === 0 || gb === 0) {
            valid = false;
            errorMessage = 'For Mobile packages, Minutes, SMS, and Data must be non-zero.';
        }
    } else if (type === 'Broadband') {
        const download = parseInt(document.getElementById('download_speed').value);
        const upload = parseInt(document.getElementById('upload_speed').value);
        if (download === 0 || upload === 0) {
            valid = false;
            errorMessage = 'For Broadband packages, Download and Upload speeds must be non-zero.';
        }
    } else if (type === 'Tablet') {
        const gb = parseInt(document.getElementById('free_gb_tablet').value);
        if (gb === 0) {
            valid = false;
            errorMessage = 'For Tablet packages, Data must be non-zero.';
        }
    }

    if (!valid) {
        errorDiv.textContent = errorMessage;
        errorDiv.classList.remove('hidden');
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        errorDiv.textContent = '';
        errorDiv.classList.add('hidden');
    }

    return valid;
}

// Initialize form on page load
updateFormFields();
</script>