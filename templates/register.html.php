<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Create Account</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form action="../includes/register.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    <input type="text" name="name" placeholder="Full Name" required class="w-full outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    <input type="email" name="email" placeholder="Email address" required class="w-full outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                    <input type="tel" name="phone" placeholder="Phone number" required class="w-full outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Address</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                    <input type="text" name="address" placeholder="Address" required class="w-full outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" name="password" placeholder="Password" required class="w-full outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <div class="flex items-center border rounded-md p-2">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full outline-none">
                </div>
            </div>
            
            <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Account
            </button>
        </form>
        
        <p class="text-center mt-4 text-sm">
            Already have an account? 
            <a href="login.html.php" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>