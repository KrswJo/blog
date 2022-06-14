<!-- Include Head -->
<?php include "asset/head.php"; ?>
<?php

// Check if the admin is already logged in, if yes then redirect him to home page
if (!$loggedin) {
    header("location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM author inner Join users on users.id = author.id_user");
$stmt->execute();
$authors = $stmt->fetchAll();
?>

<title>All Author</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />

<style>
    .fa-twitter,
    .fa-github,
    .fa-linkedin-square {
        font-size: 2.3rem;
    }
</style>
</head>

<body>

    <?php include "asset/header.php" ?>

    <main role="main" class="main">
        <div class="jumbotron text-center mb-0">
            <h1 class="display-3 font-weight-normal text-muted">All Users</h1>
        </div>

        <div class="bg-white py-3 px-5">
            <div class="row">
                <table class='table table-striped table-bordered'>

                    <thead class='thead-dark'>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>NickName</th>
                            <th scope='col'>Description</th>
                            <th scope='col'>Profile</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Twitter</th>
                            <th scope='col'>Github</th>
                            <th scope='col'>Linkedin</th>
                            <th scope='col' colspan="2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($authors as $author) :
                            echo "<tr>";
                            ?>

                            <td><?= $author['author_id'] ?></td>
                            <td><?= $author['author_fullname'] ?></td>
                            <td><?= $author['author_desc'] ?></td>
                            <td>
                                <img src="img/avatar/<?= $author['author_avatar'] ?>" style="width: 100px; height: auto;border-radius: 100%;">
                            </td>
                            <td><?= $author['author_email'] ?></td>
                            <td class="text-center">
                                <a href="https://twitter.com/<?= $author['author_twitter'] ?>" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="https://github.com/<?= $author['author_github'] ?>" target="_blank">
                                    <i class="fa fa-github"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="https://www.linkedin.com/in/<?= $author['author_link'] ?>" target="_blank">
                                    <i class="fa fa-linkedin-square"></i>
                                </a>
                            </td>

                            <td>
                                <?php if ($author['grade'] == "CREATOR") { ?>
                                <a class="btn btn-success"
                                   href="./member_grant.php?author_id=<?=$author['author_id']?>">
                                    <i class="fa fa-user-o " aria-hidden="true"></i>
                                </a>
                                <?php } else { ?>
                                    <a class="btn btn-danger"
                                       href="./member_grant.php?author_id=<?=$author['author_id']?>">
                                        <i class="fa fa-user-o " aria-hidden="true"></i>
                                    </a>
                                <?php } ?>
                            </td>

                            <td>
                                <a class="btn btn-danger" href="asset/delete.php?type=author&id=<?= $author['author_id'] ?>">
                                    <i class="fa fa-trash " aria-hidden="true"></i>
                                </a>
                            </td>

                        <?php
                            echo "</tr>"; endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main><!-- </Main> -->
</body>
</html>