<div class="max-w-md mx-auto">
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 text-center relative">
        <h1 class="text-2xl font-bold mt-8 mb-12">Login</h1>
        <!-- Wave shape -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L80,112C160,128,320,160,480,160C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="p-6 pt-0">
        <!-- App Name -->
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-blue-500">CheapDeals</h2>
            <p class="text-gray-500 text-sm">Login to access exclusive deals</p>
        </div>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <!-- Email/Phone Input -->
            <div class="mb-4 relative">
                <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    <input type="text" name="email" placeholder="Email or Phone number" required 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-2 relative">
                <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" name="password" placeholder="Password" required 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                </div>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-right mb-6">
                <a href="forgot_password.php" class="text-gray-600 text-sm">Forgot password?</a>
            </div>
            
            <!-- Error Message Display -->
            <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Login Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                Login
            </button>

            <!-- Social Login Divider -->
            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="px-3 text-gray-500 text-sm">or continue with</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="flex justify-between gap-2 mb-6">
                <button type="button" class="flex-1 py-2 border border-gray-300 rounded-md flex justify-center items-center">
                    <i class="fab fa-google text-red-500 text-xl"></i>
                </button>
                <button type="button" class="flex-1 py-2 border border-gray-300 rounded-md flex justify-center items-center">
                    <i class="fab fa-facebook text-blue-600 text-xl"></i>
                </button>
                <button type="button" class="flex-1 py-2 border border-gray-300 rounded-md flex justify-center items-center">
                    <i class="fab fa-apple text-black text-xl"></i>
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600 text-sm">Don't have an account? <a href="register.php" class="text-black font-semibold">Register</a></p>
            </div>
            
            <!-- Hidden redirect field -->
            <?php if (isset($_GET['redirect'])): ?>
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']) ?>">
            <?php endif; ?>
        </form>
    </div>
</div>