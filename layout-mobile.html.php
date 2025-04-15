<!-- layout-mobile.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- a -->
    <meta charset="UTF-8">
    <title>CheapDeals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #2ecc71 0%, #1abc9c 100%);
        }

        .gradient-purple {
            background: linear-gradient(90deg, #8e44ad 0%, #9b59b6 100%);
        }

        .gradient-red-purple {
            background: linear-gradient(135deg, #9b59b6 0%, #e74c3c 100%);
        }
        .gradient-blue {
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
        }

        .gradient-header {
            background: linear-gradient(to right, #7B3FE4, #FF4D4D);
        }

        /* Ensure full viewport height */
        html, body {
            height: 100%;
            margin: 0;
        }
        .main-container {
            min-height: 100vh; /* Full viewport height */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .content {
            flex: 1; /* Allow content to grow and fill space */
            padding-bottom: 60px; /* Space for fixed nav bar */
        }
        /* Fix bottom nav to fit mobile width */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 400px; /* Match mobile container width */
            background: white;
            border-top: 1px solid #e5e7eb;
        }
        .verification-inputs {
            display: flex;
            gap: 8px;
        }
        .verification-inputs input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 4px;
        }

        .category-tab.active {
            border-bottom: 3px solid #3b82f6;
            color: #1e40af;
        }
        .product-card.selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        @media (max-width: 640px) {
            .category-tab {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
            .product-card {
                padding: 0.75rem;
            }
        }

        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgb(37, 99, 235);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, background-color 0.2s;
            overflow: hidden;
        }
        
        .chat-button::before {
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            z-index: -1;
        }
        
        .chat-button i {
            position: relative;
            z-index: 2;
        }
        
        .chat-button:hover {
            background-color: rgb(29, 78, 216);
            transform: scale(1.05);
        }
        
        .chat-button:active {
            transform: scale(0.95);
        }
        
        @media (max-width: 640px) {
            .chat-button {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
            
            .chat-button::before {
                width: 34px;
                height: 34px;
            }
            
            .chat-button i {
                font-size: 1.25rem;
            }
        }
        
        @media (max-width: 480px) {
            .chat-button {
                bottom: 15px;
                right: 15px;
                width: 45px;
                height: 45px;
            }
            
            .chat-button::before {
                width: 30px;
                height: 30px;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Main container for mobile width -->
    <div class="main-container max-w-sm mx-auto bg-white">
        <!-- Content -->
        <div class="content">
            <?= $page_content ?>
        </div>
        <!-- Bottom Navigation -->
        <nav class="bottom-nav">
            <div class="flex justify-around">
            <a href="homepages.php" class="flex flex-col items-center p-2 text-gray-500" onclick="highlightNav(this)">
                <i class="fas fa-home"></i>
                <span class="text-xs">Home</span>
            </a>
            <a href="packages.php" class="flex flex-col items-center p-2 text-gray-500" onclick="highlightNav(this)">
                <i class="fas fa-box"></i>
                <span class="text-xs">Package</span>
            </a>
            <a href="search.php" class="flex flex-col items-center p-2 text-gray-500" onclick="highlightNav(this)">
                <i class="fas fa-search"></i>
                <span class="text-xs">Search</span>
            </a>
            <a href="bill.php" class="flex flex-col items-center p-2 text-gray-500" onclick="highlightNav(this)">
                <i class="fas fa-file-invoice"></i>
                <span class="text-xs">Bill</span>
            </a>
            <a href="enquiry.php" class="flex flex-col items-center p-2 text-gray-500" onclick="highlightNav(this)">
                <i class="fas fa-headset"></i>
                <span class="text-xs">Support</span>
            </a>
            <script>
                function highlightNav(clickedElement) {
                    // Reset all links to gray
                    document.querySelectorAll('.bottom-nav a').forEach(link => {
                        link.classList.remove('text-blue-500');
                        link.classList.add('text-gray-500');
                    });
                    // Highlight the clicked link
                    clickedElement.classList.remove('text-gray-500');
                    clickedElement.classList.add('text-blue-500');
                }

                // Automatically highlight the current page on load
                document.addEventListener('DOMContentLoaded', () => {
                    const currentPage = location.pathname.split('/').pop();
                    document.querySelectorAll('.bottom-nav a').forEach(link => {
                        if (link.getAttribute('href') === currentPage) {
                            link.classList.remove('text-gray-500');
                            link.classList.add('text-blue-500');
                        }
                    });
                });
            </script>
            </div>
        </nav>
    </div>
</body>
</html>