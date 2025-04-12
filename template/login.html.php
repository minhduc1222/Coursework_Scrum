<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CheapDeals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white font-sans">
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
            <form id="loginForm" action="../api/login.php" method="POST" class="mt-8">
                <!-- Tab Navigation -->
                <div class="flex mb-6 border rounded-md overflow-hidden">
                    <button type="button" id="emailTab" class="w-1/2 py-2 px-4 bg-white text-blue-500 font-medium border-b-2 border-blue-500">Email</button>
                    <button type="button" id="phoneTab" class="w-1/2 py-2 px-4 bg-gray-100 text-gray-500 font-medium">Phone</button>
                </div>

                <!-- Email Input (Default) -->
                <div id="emailInput" class="mb-4 relative">
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        <input type="email" name="email" placeholder="Email address" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>

                <!-- Phone Input (Hidden by default) -->
                <div id="phoneInput" class="mb-4 relative hidden">
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                        <input type="tel" name="phone" placeholder="Phone number" 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-2 relative">
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        <input type="password" name="password" placeholder="Password" required 
                            class="w-full bg-gray-100 outline-none text-gray-700">
                        <i class="far fa-eye text-gray-400 cursor-pointer toggle-password"></i>
                    </div>
                </div>

                <!-- Forgot Password Link -->
                <div class="text-right mb-6">
                    <a href="forgot_password.php" class="text-gray-600 text-sm">Forgot password?</a>
                </div>
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
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[name="password"]');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Toggle between email and phone inputs
            const emailTab = document.getElementById('emailTab');
            const phoneTab = document.getElementById('phoneTab');
            const emailInput = document.getElementById('emailInput');
            const phoneInput = document.getElementById('phoneInput');
            
            emailTab.addEventListener('click', function() {
                // Show email input, hide phone input
                emailInput.classList.remove('hidden');
                phoneInput.classList.add('hidden');
                
                // Update tab styling
                emailTab.classList.add('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
                emailTab.classList.remove('bg-gray-100', 'text-gray-500');
                phoneTab.classList.add('bg-gray-100', 'text-gray-500');
                phoneTab.classList.remove('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
                
                // Update required attributes
                emailInput.querySelector('input').setAttribute('required', '');
                phoneInput.querySelector('input').removeAttribute('required');
            });
            
            phoneTab.addEventListener('click', function() {
                // Show phone input, hide email input
                phoneInput.classList.remove('hidden');
                emailInput.classList.add('hidden');
                
                // Update tab styling
                phoneTab.classList.add('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
                phoneTab.classList.remove('bg-gray-100', 'text-gray-500');
                emailTab.classList.add('bg-gray-100', 'text-gray-500');
                emailTab.classList.remove('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
                
                // Update required attributes
                phoneInput.querySelector('input').setAttribute('required', '');
                emailInput.querySelector('input').removeAttribute('required');
            });

            // Form submission with AJAX
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = {};
                
                // Check which input is active and get its value
                if (!emailInput.classList.contains('hidden')) {
                    formData.email = loginForm.querySelector('input[name="email"]').value;
                } else {
                    formData.phone = loginForm.querySelector('input[name="phone"]').value;
                }
                
                formData.password = loginForm.querySelector('input[name="password"]').value;
                
                fetch('../api/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '../homepages.php';
                    } else {
                        alert(data.message || 'Login failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during login.');
                });
            });
        });
    </script>
</body>
</html>