<div class="sidebar">
    <button class="toggle-btn">☰<span class="tooltip">Expand/Collapse Menu</span></button> <!-- Hamburger icon -->
    <div class="sidebar-content">
            <h3>Library Management</h3>
            <ul>
                <li><a href="view_books.php">View All Books</a></li>
                <li><a href="add_book.php">Add New Book</a></li>
                <li><a href="student_dues.php">View Student Dues & History</a></li>
                <li><a href="student_details.php">Students Details</a></li>
                <li><a href="dues_history.php">Dues & History</a></li>
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


