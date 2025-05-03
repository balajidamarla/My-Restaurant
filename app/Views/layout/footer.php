</div> <!-- /.container -->

</body>
<!-- Any footer content you have -->




</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function fetchNotifications() {
            fetch("<?= base_url('customer/fetchNotifications') ?>")
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById("notification-list");
                    const count = document.getElementById("notification-count");

                    list.innerHTML = "";
                    if (data.notifications.length === 0) {
                        list.innerHTML = '<li class="dropdown-item text-center">No notifications</li>';
                    } else {
                        data.notifications.forEach(notification => {
                            const li = document.createElement("li");
                            li.className = "dropdown-item";
                            li.textContent = notification.message;
                            li.onclick = () => markAsRead(notification.id);
                            list.appendChild(li);
                        });
                    }

                    if (data.unread > 0) {
                        count.textContent = data.unread;
                        count.style.display = "inline-block";
                    } else {
                        count.style.display = "none";
                    }
                });
        }

        function markAsRead(notificationId) {
            fetch("<?= base_url('customer/markNotificationAsRead') ?>", {
                method: 'POST',
                body: JSON.stringify({
                    id: notificationId
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                fetchNotifications(); // Refresh after marking as read
            });
        }

        // Fetch notifications every 10 seconds
        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    });
</script>


</html>
<footer class="bg-dark text-white text-center py-3 mt-4">
    <p class="mb-0">© <?= date('Y') ?> My Restaurant. All rights reserved.</p>
</footer>