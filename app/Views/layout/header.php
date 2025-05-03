<!DOCTYPE html>
<html>

<head>
    <title>My Restaurant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="<?= base_url('public/uploads/logo.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">

    <style>
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Optional: Add delay for a smoother transition */
        .nav-item.dropdown .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
        }

        /* Optional: Add transition effect for smoother dropdown */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            transition: all 0.3s ease-in-out;
        }



        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            /* Transparent white */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease;
            backdrop-filter: blur(3px);
            /* Optional: adds a nice blur effect */
        }

        #loading.hide {
            opacity: 0;
            pointer-events: none;
        }


        .loading-gif {
            width: 250px;
            /* adjust size if needed */
            height: auto;
        }
    </style>
</head>

<body>
    <!-- <div id="loading">
        <div class="spinner"></div>
    </div> -->

    <div id="loading">
    <a href="https://imgbb.com/"><img src="https://i.ibb.co/pvxYpV55/output-onlinegiftools.gif" alt="output-onlinegiftools" border="0"></a>

    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand">My Restaurant 🍽️</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <?php if (session()->get('isLoggedIn')): ?>

                        <!-- 👨‍💼 Admin is logged in -->
                        <?php if (session()->get('isAdmin')): ?>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/homePage') ?>">🏠 Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu/index') ?>">🍔 Menu</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu/adminIndex') ?>">📋 Edit/Delete Item</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu/create') ?>">➕ Add Item</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/orders') ?>">📦 View Orders</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/logout') ?>">🚪 Logout</a></li>

                            <!-- 👤 Customer is logged in -->
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/customer/customer_dashboard') ?>">🏠 Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu/index') ?>">🍔 Menu</a></li>

                            <!-- Category Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Category
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('/menu/category/veg') ?>">🌱 Veg</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('/menu/category/non-veg') ?>">🍖 Non-Veg</a></li>
                                </ul>
                            </li>

                            <!-- 🛒 View Cart Link with Item Count -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('cart/index') ?>">
                                    🛒 View Cart
                                    <?php
                                    $cart = session()->get('cart');
                                    $itemCount = 0;
                                    if (!empty($cart)) {
                                        foreach ($cart as $item) {
                                            $itemCount += $item['quantity'];
                                        }
                                    }
                                    ?>
                                    <?php if ($itemCount > 0): ?>
                                        <span class="badge bg-warning text-dark"><?= esc($itemCount) ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="<?= base_url('customer/orders') ?>">📦 My Orders</a></li>

                            <!-- 🔔 Notifications Bell -->
                            <?php
                            $session = session();
                            $notificationModel = new \App\Models\NotificationModel();
                            $unreadCount = $notificationModel
                                ->where('customer_id', $session->get('customer_id'))
                                ->where('is_read', 0)
                                ->countAllResults();
                            ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    🔔 Notifications
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="notification-count">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" id="notification-list" style="max-height: 300px; overflow-y: auto;">
                                    <li class="dropdown-item text-center">Loading...</li>
                                </ul>
                            </li>



                            <!-- 🚪 Logout -->
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('/logout') ?>">🚪 Logout</a></li>
                        <?php endif; ?>


                    <?php else: ?>
                        <!-- 🌐 General user (not logged in) -->
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/homePage') ?>">🏠 Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu/index') ?>">🍔 Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/about') ?>">🧑‍🍳 About</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/contactR') ?>">📞 Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/login') ?>">🔐 Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <div class="container">

        <?= $this->renderSection('content') ?>
        <!-- kjsdfhlksdjlfjl -->


</body>
<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loading');

        // Show loader for a minimum time (e.g., 2 seconds)
        const delay = 1000; // 2000 ms = 2s

        setTimeout(() => {
            loader.classList.add('hide');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500); // Fade out time matches CSS
        }, delay);
    });

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
                })
                .catch(error => console.error('Notification fetch error:', error));
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
            }).then(() => fetchNotifications());
        }

        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    });
</script>


</html>