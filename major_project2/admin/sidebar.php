<div class="sidebar">
<button class="toggle-btn">☰<span class="tooltip">Expand/Collapse Menu</span></button> <!-- Hamburger icon -->
    <div class="sidebar-content">
        <h3>Admin Dashboard</h3>
        <ul>
            <li><a href="add_student.php">Add Student</a></li>
            <li><a href="view_students.php">View All Students</a></li>
            <li><a href="view_library.php">View Library Data</a></li>
            <li><a href="view_canteen.php">View Canteen Data</a></li>
            <li><a href="manage_dues.php">Manage Dues</a></li>
            <li><a href="manage_transactions.php">Manage Transactions</a></li>
            <!-- Add more options as needed -->
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
