<div class="sidebar">
    <button class="toggle-btn">☰<span class="tooltip">Expand/Collapse Menu</span></button> <!-- Hamburger icon -->
    <div class="sidebar-content">
            <h3>Canteen Management</h3>
            <ul>
                <li><a href="menu_management.php">Menu</a></li>
                <li><a href="place_order.php">Place Order</a></li>
                <li><a href="order_tracking.php">Track Orders</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="payment_processing.php">Payment</a></li>
                <li><a href="update_payment.php">Update Payment</a></li>
            </ul>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.toggle-btn');
        const sidebar = document.querySelector('.sidebar');
        const sidebarContent = document.querySelector('.sidebar-content');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            sidebarContent.classList.toggle('hidden');
        });
    });
</script>


