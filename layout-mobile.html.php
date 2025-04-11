<!-- layout-mobile.php -->
<!DOCTYPE html>
<html lang="en">
<head>
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
                <a href="homepages.php" class="flex flex-col items-center p-2 text-gray-500">
                    <i class="fas fa-home"></i>
                    <span class="text-xs">Home</span>
                </a>
                <a href="packages.php" class="flex flex-col items-center p-2 text-blue-500">
                    <i class="fas fa-box"></i>
                    <span class="text-xs">Package</span>
                </a>
                <a href="search.php" class="flex flex-col items-center p-2 text-gray-500">
                    <i class="fas fa-search"></i>
                    <span class="text-xs">Search</span>
                </a>
                <a href="bill.php" class="flex flex-col items-center p-2 text-gray-500">
                    <i class="fas fa-file-invoice"></i>
                    <span class="text-xs">Bill</span>
                </a>
                <a href="support.php" class="flex flex-col items-center p-2 text-gray-500">
                    <i class="fas fa-headset"></i>
                    <span class="text-xs">Support</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>