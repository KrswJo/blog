<!-- Include Head -->
<?php include "asset/head.php"; ?>
<?php

// Check if the admin is already logged in, if yes then redirect him to home page
if (!$loggedin) {
    header("location: index.php");
    exit;
}

// Get all Articles Data
//$stmt = $conn->prepare("SELECT * FROM article, author, category WHERE id_categorie = category_id AND author_id = id_author ORDER BY article_id DESC");
$stmt = $conn->prepare(
        "SELECT * FROM article, users , category, author
               WHERE id_categorie = category_id and id_author = author_id and id_user = id and id = :id
               ORDER BY article_id DESC");
$stmt->bindParam(":id", $_SESSION["id"]);
$stmt->execute();
$data = $stmt->fetchAll();

?>

<!-- Custom CSS -->
<!-- <link href="css/home.css" rel="stylesheet"> -->
<link type="text/css" rel="stylesheet" href="css/style.css" />

<title>Add Article</title>

</head>

<body>

    <!-- Header -->
    <?php include "asset/header.php" ?>
    <!-- </Header> -->

    <!-- Main -->
    <main class="main">

        <div class="jumbotron text-center mb-0">
            <h1 class="display-3 font-weight-normal text-muted">My Articles</h1>
        </div>

        <div class="bg-white p-4">

            <div class="row ">

                <div class="col-lg-12 text-center mb-3">
                    <a class="btn btn-info float-right" href="add_article.php">Add Article</a>
                </div>

            </div>

            <div class="row">
                <table class='table table-striped table-bordered'>

                    <thead class='thead-dark'>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Title</th>
                            <th scope='col'>Image</th>
                            <th scope='col'>Created Time</th>
                            <th scope="col">Views </th>
                            <th scope='col'>Category</th>
                            <th scope='col'>Author</th>
                            <th scope='col' colspan="3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($data as $row) :
                            echo "<tr>";
                            ?>

                            <td><?= $row['article_id'] ?></td>
                            <td><a href="single_article.php?id=<?= $row['article_id'] ?>"><?= $row['article_title'] ?></a></td>
                            <td><img src="img/article/<?= $row['article_image'] ?>" style="width: 100px; height: auto;"></td>
                            <td><?= $row['article_created_time'] ?></td>
                            <td><?= $row['article_views'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td><?= $row['author_fullname'] ?></td>


                            <td>
                                <a class="btn btn-success" href="update_article.php?id=<?= $row['article_id'] ?> ">
                                    <i class="fa fa-pencil " aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="asset/delete.php?type=article&id=<?= $row['article_id'] ?> ">
                                    <i class="fa fa-trash " aria-hidden="true"></i>
                                </a>
                            </td>

                        <?php
                            echo "</tr>";
                        endforeach;
                        ?>
                    </tbody>

                </table>
            </div>
        </div>


    </main>

    <!-- Footer -->
    <!-- <?php include "asset/footer.php" ?> -->
</body>

</html>