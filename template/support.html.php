<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Chat - CheapDeals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .chat-container {
            max-height: 70vh;
            overflow-y: auto;
        }
        
        @media (max-width: 640px) {
            .chat-container {
                max-height: 60vh;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-md mx-auto p-4">
        <!-- Chat Window -->
        <div class="chat-window bg-white rounded-lg overflow-hidden shadow-md">
        <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="enquiry.php" class="text-white hover:text-gray-200 mr-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="font-semibold">Live Chat Support</h3>
                </div>
                <a href="enquiry.php" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            
            <div class="bg-gray-50 p-4 h-80 overflow-y-auto" id="chatMessages">
                <div class="bg-blue-100 rounded-lg p-3 mb-4 max-w-xs ml-auto">
                    <p class="text-sm">Hello! How can we help you today?</p>
                    <span class="text-xs text-gray-500 block mt-1">Support Team, just now</span>
                </div>
                
                <?php if (!empty($_POST['message'])): ?>
                <div class="bg-green-100 rounded-lg p-3 mb-4 max-w-xs mr-auto">
                    <p class="text-sm"><?= htmlspecialchars($_POST['message']) ?></p>
                    <span class="text-xs text-gray-500 block mt-1">You, just now</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Message Form -->
            <div class="p-4 border-t">
                <form method="POST" action="support.php" class="flex items-end gap-2">
                    <div class="flex-grow">
                        <textarea id="message" name="message" rows="2" 
                            placeholder="Type your message here..."
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium p-3 rounded-lg transition flex-shrink-0">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-resize textarea
            const messageTextarea = document.getElementById('message');
            
            messageTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>
</body>
</html>