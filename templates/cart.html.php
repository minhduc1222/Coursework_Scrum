<?php
// templates/cart.html.php
?>

<div class="bg-white">
    <!-- Header -->
    <div class="gradient-blue text-white text-center py-4">
        <h1 class="text-2xl font-bold">Shopping Cart</h1>
    </div>

    <!-- Status Message -->
    <?php
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    if ($status == 'added') {
        echo '<div class="px-4 py-2 bg-green-100 text-green-700">Item added to cart!</div>';
    } elseif ($status == 'updated') {
        echo '<div class="px-4 py-2 bg-blue-100 text-blue-700">Cart updated!</div>';
    } elseif ($status == 'removed') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700">Item removed from cart!</div>';
    } elseif ($status == 'cleared') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700">Cart cleared!</div>';
    } elseif ($status == 'error') {
        echo '<div class="px-4 py-2 bg-red-100 text-red-700">Error adding item to cart!</div>';
    }
    ?>

    <!-- Cart Contents -->
    <div class="px-4 py-4">
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="text-gray-600">Your cart is empty. <a href="../includes/packages.php" class="text-blue-500">Browse packages</a>.</p>
        <?php else: ?>
            <!-- Cart Items -->
            <div class="space-y-4">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $package_id => $item):
                    $subtotal = $item['quantity'] * $item['package']['Price'];
                    $total += $subtotal;
                ?>
                    <div class="flex items-center bg-white border border-gray-200 rounded-lg p-4">
                        <!-- Package Image -->
                        <img src="<?php echo htmlspecialchars($item['package']['ImageURL']); ?>" alt="<?php echo htmlspecialchars($item['package']['PackageName']); ?>" class="w-16 h-16 object-cover rounded-lg mr-4">
                        <!-- Package Details -->
                        <div class="flex-1">
                            <h4 class="text-base font-semibold"><?php echo htmlspecialchars($item['package']['PackageName']); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($item['package']['Type']); ?></p>
                            <p class="text-sm font-bold">£<?php echo number_format($item['package']['Price'], 2); ?> /mo</p>
                            <!-- Quantity Update -->
                            <form action="../includes/cart.php" method="GET" class="flex items-center mt-2">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?php echo $package_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" class="w-16 border border-gray-300 rounded-lg px-2 py-1 mr-2">
                                <button type="submit" class="text-blue-500 text-sm">Update</button>
                            </form>
                        </div>
                        <!-- Subtotal and Remove -->
                        <div class="text-right">
                            <p class="text-sm font-bold">Subtotal: £<?php echo number_format($subtotal, 2); ?> /mo</p>
                            <a href="../includes/cart.php?action=remove&id=<?php echo $package_id; ?>" class="text-red-500 text-sm">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary -->
            <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Total</h3>
                    <p class="text-lg font-bold">£<?php echo number_format($total, 2); ?> /mo</p>
                </div>
                <div class="mt-4 flex justify-between">
                    <a href="../includes/cart.php?action=clear" class="text-red-500 font-medium">Clear Cart</a>
                    <a href="../includes/checkout.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>