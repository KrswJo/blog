<!-- Include Head -->
<?php include "asset/head.php"; ?>
<title>Add Category</title>
</head>
<body>
    <!-- Header -->
    <?php include "asset/header.php" ?>

    <!-- Main -->
    <main role="main" class="main">
        <div class="jumbotron text-center">
            <h1 class="display-3 font-weight-normal text-muted">Submit a Category</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Form -->
                    <form action="asset/insert.php?type=category" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="catName">Category Name</label>
                            <input type="text" class="form-control" name="catName" id="catName">
                        </div>

                        <div class="form-group">
                            <label for="catColor">Category Color</label>
                            <input type="color" id="catColor" name="catColor" value="#0f88e1">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success btn-lg w-25">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <!-- Footer -->
    <!-- <?php include "asset/footer.php" ?> -->
</body>
</html>