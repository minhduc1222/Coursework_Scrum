
<div class="max-w-md mx-auto">
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 text-center relative">
        <h1 class="text-2xl font-bold mt-8 mb-12">Create Account</h1>
        <!-- Wave shape -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L80,112C160,128,320,160,480,160C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="p-6 pt-0">
        <!-- Registration Form -->
    <form action="../authentication/register.php" method="POST" id="registerForm">
        <!-- Personal Information -->
        <div class="mb-6">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 rounded-full p-3 w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Create Your Account</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Fill in all the details below</p>
                
                <!-- Name Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Name</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-user text-gray-400 mr-2"></i>
                        <input type="text" name="name" placeholder="Full Name" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Email Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        <input type="email" name="email" placeholder="Email address" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Credit Card Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Credit Card Info</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-credit-card text-gray-400 mr-2"></i>
                        <input type="text" name="credit_card" placeholder="Card number" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Phone Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Phone Number</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                        <input type="tel" name="phone" placeholder="Enter your phone number" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Address Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Address</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                        <input type="text" name="address" placeholder="Enter your address" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        <input type="password" name="password" placeholder="Create a password" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                    <p class="text-xs text-green-600 mt-1">Password must be at least 8 characters with letters and numbers</p>
                </div>
                
                <!-- Confirm Password Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Confirm Password</label>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        <input type="password" name="confirm_password" placeholder="Confirm your password" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>
                
                <!-- Terms Checkbox -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="terms" required class="mr-2">
                        <span class="text-sm text-gray-600">I agree to the <a href="#" class="text-blue-500">Terms of Service</a> and <a href="#" class="text-blue-500">Privacy Policy</a></span>
                    </label>
                </div>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                Create Account
            </button>
        </form>
        
        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">Already have an account? <a href="login.php" class="text-blue-500 font-medium">Login</a></p>
        </div>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-2 text-center rounded mb-4">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
