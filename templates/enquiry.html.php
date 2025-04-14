
<div class="max-w-md mx-auto">
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 text-center relative">
        <a href="index.php" class="absolute left-4 top-4 text-white">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold mt-8 mb-12">Customer Support</h1>
        <!-- Wave shape -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L80,112C160,128,320,160,480,160C640,160,800,128,960,122.7C1120,117,1280,139,1360,149.3L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="p-6 pt-0">
        <!-- Support Options -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">How can we help you?</h2>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <a href="#faq" class="bg-blue-50 p-4 rounded-lg text-center hover:bg-blue-100 transition">
                    <i class="fas fa-question-circle text-blue-500 text-2xl mb-2"></i>
                    <h3 class="font-semibold">FAQs</h3>
                </a>
                <a href="#contact" class="bg-purple-50 p-4 rounded-lg text-center hover:bg-purple-100 transition">
                    <i class="fas fa-phone-alt text-purple-500 text-2xl mb-2"></i>
                    <h3 class="font-semibold">Contact Us</h3>
                </a>
            </div>
        </div>
        
        <!-- FAQs Section -->
        <div id="faq" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <div class="border rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full p-4 text-left font-semibold hover:bg-gray-50 focus:outline-none">
                        <span>How do I change my plan?</span>
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </button>
                    <div class="p-4 border-t bg-gray-50">
                        <p class="text-gray-600">You can change your plan by logging into your account, navigating to "My Plans" and selecting "Change Plan" option. Follow the on-screen instructions to complete the process.</p>
                    </div>
                </div>
                
                <div class="border rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full p-4 text-left font-semibold hover:bg-gray-50 focus:outline-none">
                        <span>When will my order be delivered?</span>
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </button>
                    <div class="p-4 border-t bg-gray-50">
                        <p class="text-gray-600">Standard delivery takes 3-5 business days. You can check your order status in your account under "My Orders" section.</p>
                    </div>
                </div>
                
                <div class="border rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full p-4 text-left font-semibold hover:bg-gray-50 focus:outline-none">
                        <span>How do I cancel my subscription?</span>
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </button>
                    <div class="p-4 border-t bg-gray-50">
                        <p class="text-gray-600">To cancel your subscription, please contact our customer support team at least 7 days before your next billing cycle.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Section -->
        <div id="contact" class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact Information</h2>
            
            <div class="space-y-4">
                <div class="flex items-center p-4 border rounded-lg">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <i class="fas fa-phone text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Phone Support</h3>
                        <p class="text-gray-600">0800 123 4567</p>
                        <p class="text-sm text-gray-500">Mon-Fri: 8am-8pm, Sat: 9am-5pm</p>
                    </div>
                </div>
                
                <div class="flex items-center p-4 border rounded-lg">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <i class="fas fa-envelope text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Email Support</h3>
                        <p class="text-gray-600">support@cheapdeals.com</p>
                        <p class="text-sm text-gray-500">We'll respond within 24 hours</p>
                    </div>
                </div>
                
                <div class="flex items-center p-4 border rounded-lg">
                    <div class="bg-purple-100 rounded-full p-3 mr-4">
                        <i class="fas fa-map-marker-alt text-purple-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Visit Us</h3>
                        <p class="text-gray-600">123 High Street, London, UK</p>
                        <p class="text-sm text-gray-500">Mon-Fri: 9am-6pm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Button -->
<a href="support.php" id="chatButton" class="chat-button bg-blue-600 hover:bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg transition-all">
    <i class="fas fa-comments text-2xl"></i>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chatButton');
        const chatWindow = document.getElementById('chatWindow');
        const closeChat = document.getElementById('closeChat');
        const messageTextarea = document.getElementById('messageTextarea');
        
        // Toggle chat window
        chatButton.addEventListener('click', function() {
            chatWindow.style.display = 'block';
            chatButton.classList.add('scale-90');
            setTimeout(() => chatButton.classList.remove('scale-90'), 200);
        });
        
        // Close chat window
        closeChat.addEventListener('click', function() {
            chatWindow.style.display = 'none';
        });
        
        // Auto-expand textarea
        messageTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Limit max height
            if (this.scrollHeight > 150) {
                this.style.overflowY = 'auto';
            } else {
                this.style.overflowY = 'hidden';
            }
        });
        
        // FAQ accordion functionality
        const accordionButtons = document.querySelectorAll('.border.rounded-lg button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                // Toggle content visibility
                if (content.style.display === 'none' || !content.style.display) {
                    content.style.display = 'block';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    content.style.display = 'none';
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
        
        <?php if ($success || $error): ?>
        chatWindow.style.display = 'block';
        <?php endif; ?>
    });
</script>
