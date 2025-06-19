<?php
// Database connection
$host = "localhost";
$user = "root"; // Change if different
$password = ""; // Change if different
$dbname = "ecommerce"; // Your database name
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle search input
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Pagination settings
$limit = 5; // Products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

// Get filtered products
$query = "SELECT * FROM products WHERE title LIKE '%$search%' OR description LIKE '%$search%' LIMIT $start_from, $limit";
$result = mysqli_query($conn, $query);

// Get total product count for pagination
$count_query = "SELECT COUNT(*) FROM products WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
$count_result = mysqli_fetch_row(mysqli_query($conn, $count_query));
$total_records = $count_result[0];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP E-Commerce - Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">Product List</h2>

    <!-- Search Form -->
    <form class="d-flex mb-4" method="GET" action="">
        <input class="form-control me-2" type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <!-- Products Grid -->
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Pagination Links -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

</body>
</html>
