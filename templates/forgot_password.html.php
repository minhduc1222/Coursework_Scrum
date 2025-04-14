
<div class="max-w-md mx-auto">
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 text-center relative">
        <a href="login.php" class="absolute left-4 top-6 text-white">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold mt-8 mb-12" id="pageTitle">Forgot Password</h1>
        <!-- Wave shape -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L80,112C160,128,320,160,480,160C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="p-6 pt-0">
        <!-- Step 1: Request Reset -->
        <div id="step-request" class="step-content">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 rounded-full p-3 w-16 h-16 flex items-center justify-center">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Reset Your Password</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Enter your email address or phone number and we'll send you a verification code to reset your password</p>
            
            <!-- Tab Navigation -->
            <div class="flex mb-6 border rounded-md overflow-hidden">
                <button type="button" id="emailTab" class="w-1/2 py-2 px-4 bg-white text-blue-500 font-medium border-b-2 border-blue-500">Email</button>
                <button type="button" id="phoneTab" class="w-1/2 py-2 px-4 bg-gray-100 text-gray-500 font-medium">Phone</button>
            </div>
            
            <!-- Email Input (Default) -->
            <div id="emailInput" class="mb-4 relative">
                <div class="flex items-center px-3 py-3 bg-gray-100 rounded-md">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    <input type="email" name="email" placeholder="Enter your email address" required 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                </div>
            </div>
            
            <!-- Phone Input (Hidden by default) -->
            <div id="phoneInput" class="mb-4 relative hidden">
                <div class="flex items-center px-3 py-3 bg-gray-100 rounded-md">
                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                    <input type="tel" name="phone" placeholder="Enter your phone number" 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                </div>
            </div>
            
            <!-- Send Verification Button -->
            <button type="button" id="sendVerificationBtn" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium flex justify-center items-center">
                <i class="fas fa-paper-plane mr-2"></i>
                Send Verification Code
            </button>
            
            <!-- Back to Login Link -->
            <div class="text-center mt-4">
                <a href="login.php" class="text-gray-600 text-sm">Back to Login</a>
            </div>
        </div>
        
        <!-- Step 2: Verify Code -->
        <div id="step-verify" class="step-content hidden">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 rounded-full p-3 w-16 h-16 flex items-center justify-center">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Enter Verification Code</h2>
            <p class="text-center text-gray-500 text-sm mb-6">We've sent a 6-digit verification code to your email/phone. Enter the code below to continue.</p>
            
            <!-- Verification Code Input -->
            <div class="verification-inputs mb-6 justify-center">
                <input type="text" maxlength="1" class="verification-digit" data-index="1">
                <input type="text" maxlength="1" class="verification-digit" data-index="2">
                <input type="text" maxlength="1" class="verification-digit" data-index="3">
                <input type="text" maxlength="1" class="verification-digit" data-index="4">
                <input type="text" maxlength="1" class="verification-digit" data-index="5">
                <input type="text" maxlength="1" class="verification-digit" data-index="6">
            </div>
            
            <!-- Verify Button -->
            <button type="button" id="verifyCodeBtn" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                Verify Code
            </button>
            
            <!-- Resend Code Link -->
            <div class="text-center mt-4">
                <p class="text-gray-600 text-sm">Didn't receive the code?</p>
                <button type="button" id="resendCodeBtn" class="text-blue-500 font-medium text-sm mt-1">Resend Code</button>
            </div>
        </div>
        
        <!-- Step 3: Create New Password -->
        <div id="step-reset" class="step-content hidden">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 rounded-full p-3 w-16 h-16 flex items-center justify-center">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-xl font-semibold text-blue-500 mb-1">Create New Password</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Your new password must be different from previously used passwords</p>
            
            <!-- New Password Input -->
            <div class="mb-2">
                <label class="block text-gray-700 mb-2">New Password</label>
                <div class="flex items-center px-3 py-3 bg-gray-100 rounded-md">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" id="newPassword" name="new_password" placeholder="Create a password" required 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                    <i class="far fa-eye text-gray-400 cursor-pointer toggle-password"></i>
                </div>
                <div class="password-strength bg-gray-200 w-full">
                    <div id="passwordStrength" class="bg-green-500 h-full" style="width: 0%"></div>
                </div>
                <p class="text-xs text-green-600 mt-1">Password must be at least 8 characters with letters and numbers</p>
            </div>
            
            <!-- Confirm Password Input -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Confirm your password</label>
                <div class="flex items-center px-3 py-3 bg-gray-100 rounded-md">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required 
                        class="w-full bg-gray-100 outline-none text-gray-700">
                </div>
            </div>
            
            <!-- Change Password Button -->
            <button type="button" id="changePasswordBtn" class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-md font-medium">
                Change Password
            </button>
        </div>
        
        <!-- Step 4: Success -->
        <div id="step-success" class="step-content hidden">
            <!-- Success Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-green-100 rounded-full p-3 w-20 h-20 flex items-center justify-center">
                    <i class="fas fa-check text-green-500 text-3xl"></i>
                </div>
            </div>
            
            <!-- Success Message -->
            <h2 class="text-center text-xl font-semibold text-green-500 mb-1">Password Reset Successful!</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Your password has been changed successfully. You will be redirected to the login page.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const emailTab = document.getElementById('emailTab');
        const phoneTab = document.getElementById('phoneTab');
        const emailInput = document.getElementById('emailInput');
        const phoneInput = document.getElementById('phoneInput');
        const sendVerificationBtn = document.getElementById('sendVerificationBtn');
        const verifyCodeBtn = document.getElementById('verifyCodeBtn');
        const resendCodeBtn = document.getElementById('resendCodeBtn');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const pageTitle = document.getElementById('pageTitle');
        
        // Steps
        const stepRequest = document.getElementById('step-request');
        const stepVerify = document.getElementById('step-verify');
        const stepReset = document.getElementById('step-reset');
        const stepSuccess = document.getElementById('step-success');
        
        // Toggle between email and phone inputs
        emailTab.addEventListener('click', function() {
            emailInput.classList.remove('hidden');
            phoneInput.classList.add('hidden');
            
            emailTab.classList.add('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
            emailTab.classList.remove('bg-gray-100', 'text-gray-500');
            phoneTab.classList.add('bg-gray-100', 'text-gray-500');
            phoneTab.classList.remove('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
        });
        
        phoneTab.addEventListener('click', function() {
            phoneInput.classList.remove('hidden');
            emailInput.classList.add('hidden');
            
            phoneTab.classList.add('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
            phoneTab.classList.remove('bg-gray-100', 'text-gray-500');
            emailTab.classList.add('bg-gray-100', 'text-gray-500');
            emailTab.classList.remove('bg-white', 'text-blue-500', 'border-b-2', 'border-blue-500');
        });
        
        // Toggle password visibility
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('input[name="new_password"]');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
        
        // Password strength meter
        const newPassword = document.getElementById('newPassword');
        const passwordStrength = document.getElementById('passwordStrength');
        
        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;
            
            passwordStrength.style.width = strength + '%';
            
            if (strength < 50) {
                passwordStrength.classList.remove('bg-yellow-500', 'bg-green-500');
                passwordStrength.classList.add('bg-red-500');
            } else if (strength < 75) {
                passwordStrength.classList.remove('bg-red-500', 'bg-green-500');
                passwordStrength.classList.add('bg-yellow-500');
            } else {
                passwordStrength.classList.remove('bg-red-500', 'bg-yellow-500');
                passwordStrength.classList.add('bg-green-500');
            }
        });
        
        // Verification code input handling
        const verificationInputs = document.querySelectorAll('.verification-digit');
        
        verificationInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length === 1) {
                    const nextIndex = parseInt(this.dataset.index) + 1;
                    const nextInput = document.querySelector(`.verification-digit[data-index="${nextIndex}"]`);
                    if (nextInput) nextInput.focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0) {
                    const prevIndex = parseInt(this.dataset.index) - 1;
                    const prevInput = document.querySelector(`.verification-digit[data-index="${prevIndex}"]`);
                    if (prevInput) {
                        prevInput.focus();
                        prevInput.value = '';
                    }
                }
            });
        });
        
        // Navigation between steps
        sendVerificationBtn.addEventListener('click', function() {
            // Validate email or phone
            let isValid = false;
            let contactInfo = '';
            
            if (!emailInput.classList.contains('hidden')) {
                const email = emailInput.querySelector('input').value;
                if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = true;
                    contactInfo = email;
                } else {
                    alert('Please enter a valid email address');
                }
            } else {
                const phone = phoneInput.querySelector('input').value;
                if (phone && /^\d{10,}$/.test(phone.replace(/\D/g, ''))) {
                    isValid = true;
                    contactInfo = phone;
                } else {
                    alert('Please enter a valid phone number');
                }
            }
            
            if (isValid) {
                // Send verification code via API
                fetch('../api/forgot_password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: contactInfo })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show verification step
                        stepRequest.classList.add('hidden');
                        stepVerify.classList.remove('hidden');
                        pageTitle.textContent = 'Verify Code';
                        
                        // Focus on first verification input
                        document.querySelector('.verification-digit[data-index="1"]').focus();
                    } else {
                        alert(data.message || 'Failed to send verification code');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while sending verification code');
                });
            }
        });
        
        verifyCodeBtn.addEventListener('click', function() {
            // Collect verification code
            let code = '';
            verificationInputs.forEach(input => {
                code += input.value;
            });
            
            if (code.length === 6) {
                // Verify code via API (mock for now)
                // In a real implementation, you would send this to your backend
                
                // Show reset password step
                stepVerify.classList.add('hidden');
                stepReset.classList.remove('hidden');
                pageTitle.textContent = 'Change Password';
            } else {
                alert('Please enter the complete 6-digit verification code');
            }
        });
        
        resendCodeBtn.addEventListener('click', function() {
            alert('Verification code resent!');
            // In a real implementation, you would call your API again
        });
        
        changePasswordBtn.addEventListener('click', function() {
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            
            if (newPass.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }
            
            if (newPass !== confirmPass) {
                alert('Passwords do not match');
                return;
            }
            
            // Reset password via API (mock for now)
            // In a real implementation, you would send this to your backend
            
            // Show success step
            stepReset.classList.add('hidden');
            stepSuccess.classList.remove('hidden');
            pageTitle.textContent = 'Change Password';
            
            // Redirect to login after 3 seconds
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 3000);
        });
    });
</script>
