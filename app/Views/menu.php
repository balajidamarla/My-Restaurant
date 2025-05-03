<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    /* Pagination container styling */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    /* Pagination link styling */
    .pagination li {
        margin: 0 8px;
        position: relative;
    }

    /* Base pagination link */
    .pagination li a {
        display: block;
        padding: 10px 16px;
        text-decoration: none;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    /* Hover effect for pagination link */
    .pagination li a:hover {
        background-color: #c0392b;
        color: #fff;
        border-color: #c0392b;
        transform: translateY(-3px);
    }

    /* Disabled state for pagination links */
    .pagination li.disabled a {
        color: #ccc;
        background-color: #f1f1f1;
        pointer-events: none;
        border-color: #ddd;
        transform: none;
    }

    /* Active page styling */
    .pagination li.active a {
        background-color: #c0392b;
        color: #fff;
        border-color: #c0392b;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        font-weight: 700;
    }

    /* Arrow styling for "previous" and "next" */
    .pagination li a::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Add arrow icon to "previous" and "next" links */
    .pagination li a.prev::before {
        content: "←";
        font-size: 18px;
        margin-right: 5px;
    }

    .pagination li a.next::before {
        content: "→";
        font-size: 18px;
        margin-left: 5px;
    }

    /* Add rounded corners for the first and last page */
    .pagination li:first-child a {
        border-top-left-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .pagination li:last-child a {
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
    }

    /* Add spacing between pagination items */
    .pagination li {
        margin-left: 10px;
    }
</style>

<div class="container my-5">
    <h2 class="text-center mb-4" style="
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-style: italic;
  letter-spacing: 1px;
  background: linear-gradient(90deg, 
  #ffd700,   /* gold */
  #fcb900,   /* vivid gold */
  #fca311,   /* rich amber */
  #ff9900,   /* orange gold */
  #ff8800,   /* warm orange */
  #ff9f1c,   /* amber orange */
  #ffb347,   /* light orange */
  #f9d423,   /* golden yellow */
  #f6c90e    /* sunbeam yellow */
);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  color: transparent;">
        <b>Our Delicious Menu</b>
    </h2>





    <!-- Search and Filter Form (No Submit Button) -->
    <div class="mb-4">
        <div class="row justify-content-center">
            <!-- Centered Search input -->
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control text-center" placeholder="🔍 Search Menu">
            </div>
        </div>
    </div>

    <!-- Filtered Menu Container -->
    <div id="filteredMenu">
        <?= view('menu_list', ['menuItems' => $menuItems]) ?>
    </div>


    <!-- Pagination (Optional: can be adjusted or hidden if using AJAX full pagination) -->
    <!-- <div class="container mt-4">
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <? //= $pager->links('default') 
                ?>
            </ul>
        </div>
    </div> -->
</div>

<script>
    $(document).ready(function() {
        var csrfName = '<?= csrf_token() ?>'; // CSRF token name (default: 'csrf_token')
        var csrfHash = '<?= csrf_hash() ?>'; // CSRF token hash (default: generated value)

        function filterMenu() {
            const search = $('#searchInput').val(); // Get search term from input field
            const type = $('input[name="foodType"]:checked').val(); // Get food type (veg/non-veg)

            // Update the CSRF token if needed
            csrfHash = window.csrfToken; // Ensure the token is updated after every request

            $.ajax({
                url: "<?= site_url('menu/filter') ?>", // URL for the request
                method: "POST", // POST request
                data: {
                    search: search, // Send search term
                    type: type, // Send food type
                    [csrfName]: csrfHash // Send the CSRF token
                },
                success: function(response) {
                    console.log("AJAX Response:", response);
                    $('#filteredMenu').html(response); // Update the filtered menu
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", error); // Log any errors for debugging
                }
            });
        }

        // Trigger filter function when the user types in the search input
        $('#searchInput').on('keyup', function() {
            const searchValue = $(this).val().trim();

            if (searchValue === "") {
                // Load all items if search is empty
                $.ajax({
                    url: "<?= site_url('menu/loadAll') ?>",
                    method: "GET",
                    success: function(response) {
                        $('#filteredMenu').html(response); // Display all items
                    }
                });
            } else {
                filterMenu(); // Apply the filter
            }
        });

        // Trigger filter when the user selects a food type
        $('input[name="foodType"]').on('change', filterMenu);
    });
</script>





<?= $this->include('layout/footer') ?>
<?= $this->endSection('content') ?>