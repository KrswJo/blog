<?php include "asset/head.php"; ?>
<?php

$category_id = $_GET["id"];

// Get category Data to display
$stmt = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

?>

<title>Update Category</title>
</head>

<body>

    <?php include "asset/header.php" ?>

    <main role="main" class="main">

        <div class="jumbotron text-center ">
            <h1 class="display-3 font-weight-normal text-muted">Update a Category</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Form -->
                    <form action="asset/update.php?type=category&id=<?= $category_id ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="catName">Category Name</label>
                            <input type="text" class="form-control" name="catName" id="catName" value="<?= $category["category_name"] ?>">
                        </div>

                        <div class="form-group">
                            <label for="catColor">Category Color</label>
                            <input type="color" id="catColor" name="catColor" value="<?= $category["category_color"] ?>">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-success btn-lg w-25">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>