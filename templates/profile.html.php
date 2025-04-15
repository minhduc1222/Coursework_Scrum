<?php
// templates/profile.html.php

// Check if edit mode is enabled
$edit_mode = isset($_GET['edit']) && $_GET['edit'] === 'true';
$password_mode = isset($_GET['password']) && $_GET['password'] === 'true';
?>

<!-- Main Content -->
<main class="p-4">
    <?php if (isset($success)): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Profile View -->
    <?php if (!$edit_mode && !$password_mode): ?>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex flex-col items-center mb-4">
                <img src="<?php echo htmlspecialchars($customer->avt_img ?: '../image/default-avatar.png'); ?>" alt="Profile Picture" class="w-24 h-24 rounded-full mb-2">
                <p class="text-gray-600 font-semibold">Balance: <?php echo $customer->Balance?></p>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Full Name:</label>
                    <input type="text" id="name" value="<?php echo htmlspecialchars($customer->Name); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email:</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($customer->Email); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number:</label>
                    <input type="text" id="phone" value="<?php echo htmlspecialchars($customer->PhoneNumber); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-medium mb-1">Address:</label>
                    <input type="text" id="address" value="<?php echo htmlspecialchars($customer->Address); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="credit_card" class="block text-gray-700 font-medium mb-1">Credit Card Number:</label>
                    <input type="text" id="credit_card" value="<?php echo htmlspecialchars(str_repeat('*', strlen($customer->CreditCardInfo) - 4) . substr($customer->CreditCardInfo, -4)); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="csv" class="block text-gray-700 font-medium mb-1">CSV:</label>
                    <input type="text" id="csv" value="<?php echo htmlspecialchars(str_repeat('*', strlen($customer->csv))); ?>" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password:</label>
                    <input type="text" id="password" value="********" disabled class="w-full p-2 border rounded bg-gray-100">
                </div>
            </div>
            <div class="mt-4">
                <a href="profile.php?edit=true" class="w-full bg-gray-500 text-white py-2 rounded-lg text-center block hover:bg-gray-600">Edit Profile</a>
            </div>
            <div class="mt-4">
                <a href="profile.php?password=true" class="w-full bg-blue-500 text-white py-2 rounded-lg text-center block hover:bg-blue-600">Change Password</a>
            </div>
            <div class="mt-4">
                <a href="custom_package.php" class="w-full bg-purple-500 text-white py-2 rounded-lg text-center block hover:bg-purple-600">Create Custom Package</a>
            </div>
        </div>
    <?php elseif ($password_mode): ?>
        <!-- Change Password Form -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Change Password</h2>
            <form method="POST" action="profile.php" class="space-y-4">
                <div>
                    <label for="new_password" class="block text-gray-700 font-medium mb-1">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" name="change_password" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Change Password</button>
                <a href="profile.php" class="w-full bg-gray-500 text-white py-2 rounded-lg text-center block mt-2 hover:bg-gray-600">Cancel</a>
            </form>
        </div>
    <?php else: ?>
        <!-- Edit Profile Form -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Edit Profile</h2>
            <form method="POST" action="profile.php" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Full Name:</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($customer->Name); ?>" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($customer->Email); ?>" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number:</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($customer->PhoneNumber); ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-medium mb-1">Address:</label>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($customer->Address); ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="credit_card" class="block text-gray-700 font-medium mb-1">Credit Card Number:</label>
                    <input type="text" name="credit_card" id="credit_card" value="<?php echo htmlspecialchars(str_repeat('*', strlen($customer->CreditCardInfo) - 4) . substr($customer->CreditCardInfo, -4)); ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="csv" class="block text-gray-700 font-medium mb-1">CSV:</label>
                    <input type="text" name="csv" id="csv" value="<?php echo htmlspecialchars(str_repeat('*', strlen($customer->csv))); ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="avt_img" class="block text-gray-700 font-medium mb-1">Profile Picture:</label>
                    <div class="flex items-center space-x-4">
                        <img src="<?php echo htmlspecialchars($customer->avt_img ?: '../image/default-avatar.png'); ?>" alt="Profile Picture" class="w-16 h-16 rounded-full">
                        <input type="file" name="avt_img" id="avt_img" accept="image/*" class="w-full p-2 border rounded">
                    </div>
                </div>
                <button type="submit" name="update_profile" class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600">Save Changes</button>
                <a href="profile.php" class="w-full bg-gray-500 text-white py-2 rounded-lg text-center block mt-2 hover:bg-gray-600">Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="logout.php" class="w-full bg-red-500 text-white py-2 rounded-lg text-center block hover:bg-gray-600">Logout</a>
    </div>
</main>