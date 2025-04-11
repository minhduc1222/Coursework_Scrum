<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - CheapDeals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white font-sans">
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
            <!-- Step Indicator -->
            <div class="flex items-center mb-4">
                <div class="text-sm text-gray-600">Step <span id="currentStep">1</span> of 3</div>
                <div class="ml-auto text-sm text-gray-600" id="stepTitle">Personal Info</div>
            </div>
            
            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-6">
                <div class="bg-purple-600 h-1.5 rounded-full" id="progressBar" style="width: 33%"></div>
            </div>

            <!-- Registration Form -->
            <form id="registerForm">
                <!-- Step 1: Personal Information -->
                <div id="step-1" class="step-content">
                    <!-- Icon -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-500 rounded-full p-3 w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Personal Information</h2>
                    <p class="text-center text-gray-500 text-sm mb-6">Tell us about yourself</p>
                    
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
                    
                    <!-- Date of Birth Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Date of Birth</label>
                        <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                            <input type="date" name="dob" required 
                                class="w-full bg-gray-100 outline-none text-gray-700">
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Contact Details -->
                <div id="step-2" class="step-content hidden">
                    <!-- Icon -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-500 rounded-full p-3 w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Contact Details</h2>
                    <p class="text-center text-gray-500 text-sm mb-6">How can we reach you?</p>
                    
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
                </div>
                
                <!-- Step 3: Create Password -->
                <div id="step-3" class="step-content hidden">
                    <!-- Icon -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-500 rounded-full p-3 w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Create Password</h2>
                    <p class="text-center text-gray-500 text-sm mb-6">Secure your account</p>
                    
                    <!-- Password Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Password</label>
                        <div class="flex items-center px-3 py-2 bg-gray-100 rounded-md">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>
                            <input type="password" name="password" placeholder="Create a password" required 
                                class="w-full bg-gray-100 outline-none text-gray-700">
                            <i class="far fa-eye text-gray-400 cursor-pointer toggle-password"></i>
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
                
                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-6">
                    <button type="button" id="prevBtn" class="text-gray-600 hidden">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </button>
                    <button type="button" id="nextBtn" class="ml-auto py-3 px-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                        Continue
                    </button>
                    <button type="submit" id="submitBtn" class="hidden py-3 px-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                        Create Account
                    </button>
                </div>
            </form>
            
            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600 text-sm">Already have an account? <a href="login.php" class="text-blue-500 font-medium">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 3;
            const stepTitles = ['Personal Info', 'Contact Details', 'Create Password'];
            
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressBar = document.getElementById('progressBar');
            const currentStepEl = document.getElementById('currentStep');
            const stepTitleEl = document.getElementById('stepTitle');
            
            // Toggle password visibility
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[name="password"]');
            
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
            
            // Show step function
            function showStep(step) {
                // Hide all steps
                document.querySelectorAll('.step-content').forEach(el => {
                    el.classList.add('hidden');
                });
                
                // Show current step
                document.getElementById(`step-${step}`).classList.remove('hidden');
                
                // Update progress bar
                progressBar.style.width = `${(step / totalSteps) * 100}%`;
                
                // Update step indicator
                currentStepEl.textContent = step;
                stepTitleEl.textContent = stepTitles[step - 1];
                
                // Update buttons
                prevBtn.classList.toggle('hidden', step === 1);
                nextBtn.classList.toggle('hidden', step === totalSteps);
                submitBtn.classList.toggle('hidden', step !== totalSteps);
            }
            
            // Next button click
            nextBtn.addEventListener('click', function() {
                // Validate current step
                const currentStepEl = document.getElementById(`step-${currentStep}`);
                const inputs = currentStepEl.querySelectorAll('input[required]');
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!input.value) {
                        isValid = false;
                        input.classList.add('border', 'border-red-500');
                    } else {
                        input.classList.remove('border', 'border-red-500');
                    }
                });
                
                if (isValid && currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
            
            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
            
            // Form submission with AJAX
            const registerForm = document.getElementById('registerForm');
            // Form submission with AJAX
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Only validate if you're on step 3
                if (currentStep !== 3) return;

                const passwordInput = registerForm.querySelector('input[name="password"]');
                const confirmInput = registerForm.querySelector('input[name="confirm_password"]');
                
                const password = passwordInput.value.trim();
                const confirmPassword = confirmInput.value.trim();

                if (!password || !confirmPassword) {
                    alert('Please enter and confirm your password.');
                    return;
                }

                if (password !== confirmPassword) {
                    alert('Passwords do not match!');
                    passwordInput.classList.add('border', 'border-red-500');
                    confirmInput.classList.add('border', 'border-red-500');
                    return;
                }

                // Collect form data
                const formData = {
                    name: registerForm.querySelector('input[name="name"]').value,
                    email: registerForm.querySelector('input[name="email"]').value,
                    password: password,
                    dob: registerForm.querySelector('input[name="dob"]').value,
                    phone: registerForm.querySelector('input[name="phone"]').value,
                    address: registerForm.querySelector('input[name="address"]').value
                };

                // Send data to API
                fetch('../api/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'login.php';
                    } else {
                        alert(data.message || 'Registration failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during registration.');
                });
            });
            // Initialize
            showStep(currentStep);
        });
    </script>
</body>
</html>