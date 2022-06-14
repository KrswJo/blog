<?php include "asset/head.php"; ?>

<?php
$article_id = $_GET['id'];

// Get Article Info
$stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN `author` ON `article`.id_author = `author`.author_id  WHERE `article_id` = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

// Get Category of article
$stmt = $conn->prepare("SELECT * FROM `category` WHERE `category_id` = ?");
$stmt->execute([$article["id_categorie"]]);
$category = $stmt->fetch();

// Get Author's articles
$stmt = $conn->prepare("SELECT article_title, article_id FROM `article` WHERE id_author = ? LIMIT 4");
$stmt->execute([$article["id_author"]]);
$articles = $stmt->fetchAll();

// Get Comments
$stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN `comment` WHERE `article`.`article_id`= `comment`.`id_article` AND `article`.`article_id` = ? ORDER BY comment_id DESC");
$stmt->execute([$article_id]);
$comments = $stmt->fetchAll();

// Views Count++
$stmt = $conn->prepare("UPDATE article SET article.article_views = article.article_views + 1 WHERE article.article_id = :articleId");
$stmt->bindParam(":articleId", $article_id);
$stmt->execute();

$loggined_authImg = null;
$loggined_authorName = null;
$grade = null;
$username = null;

if (isset($_SESSION["id"])){
    $stmt = $conn->prepare("SELECT distinct * FROM `author` JOIN `users` WHERE author.id_user = :userId");
    $stmt->bindParam(":userId", $_SESSION["id"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $loggined_authorName = $row['author_fullname'];
    $loggined_authImg = $row['author_avatar'];
    $grade = $_SESSION["grade"];
}

?>

<!-- Custom CSS -->
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/single_article.css">

<title>Single Article</title>

</head>

<body>
    <!-- Header -->
    <?php include "asset/header.php" ?>
    <!-- /Header -->
    <!-- Main -->
    <main role="main" class="bg-l py-4">
        <div class="container">
            <div class="row">
                <!-- Article -->
                <div class="content bg-white col-lg-9 p-0 border border-muted">
                    <!-- Post Image -->
                    <div class="post__img" style="background-image: url('img/article/<?= $article["article_image"] ?>');"></div>
                    <!-- Post Content -->
                    <div class="post__content w-75 mx-auto">
                        <div class="post-head text-center my-5">
                            <h1 class="post__title">
                                <?= $article["article_title"] ?>
                            </h1>
                            <div class="post-meta ">
                                <span class="post__date">
                                    <?= date_format(date_create($article["article_created_time"]), "F d, Y ") ?>
                                </span>
                                <a class="post-category" href="articleOfCategory.php?catID=<?= $category['category_id'] ?>" style="background-color:<?= $category['category_color'] ?>">
                                    <?= $category['category_name'] ?>
                                </a>
                            </div>
                        </div>
                        <div class="post-body text-break">
                            <?= $article["article_content"] ?>
                        </div>
                        <!-- author Info -->
                        <div class="post-footer d-flex my-5">
                            <img class="profile-thumbnail rounded-circle pr-2" src="img/avatar/<?= $article['author_avatar'] ?>" alt="test avatar image" style="width: 120px;height: 120px;">
                            <div class="d-flex flex-column justify-content-around">
                                <h3 class="font-italic mb-1"><?= $article['author_fullname'] ?></h3>
                                <p class="text-muted mb-1"><?= $article['author_desc'] ?></p>
                                <div class="social_media">
                                    <a href="" class="mr-3"><i class="fa fa-twitter"></i><span class="px-1"><?= $article['author_twitter'] ?></span></a>
                                    <a href="" class="mr-3"><i class="fa fa-github"></i><span class="px-1"><?= $article['author_github'] ?></span></a>
                                    <a href="" class="mr-3"><i class="fa fa-linkedin-square"></i><span class="px-1"><?= $article['author_link'] ?></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /Article -->

                <!-- Aside -->
                <div class="aside col-3">
                    <!-- Author Info -->
                    <div class="p-3 bg-white border  border-muted">
                        <div class="d-flex align-items-center">
                            <img class="profile-thumbnail rounded-circle" src="img/avatar/<?= $article['author_avatar'] ?>" alt="test avatar image" style="width: 60px;height: 60px;">
                            <h5 class="font-italic m-0"><?= $article['author_fullname'] ?></h5>
                        </div>
                        <p class="author_desc p-1"><?= $article['author_desc'] ?></p>
                        <div class="d-flex flex-column justify-content-between">
                            <div class="author_links">
                                <a href="https://twitter.com/<?= $article['author_twitter'] ?>" class="mr-3"><i class="fa fa-lg fa-twitter"></i></a>
                                <a href="https://github.com/<?= $article['author_github'] ?>" class="mr-3"><i class="fa fa-lg fa-github"></i></a>
                                <a href="https://linkedin.com/<?= $article['author_link'] ?>" class="mr-3"><i class="fa fa-lg fa-linkedin-square"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-light my-3">
                        <div class="card-header"><strong> More from <?= $article['author_fullname'] ?></strong></div>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($articles as $article) : ?>
                                <li class="list-group-item"><a href="single_article.php?id=<?= $article['article_id'] ?>"><?= $article['article_title'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- /Other articles  -->
                </div><!-- /Aside -->
            </div>

            <!-- Comments -->
            <div id="comment" class="row">
                <div class="col-lg-9 border p-4 mt-3 bg-white">
                    <div class="comments">
                        <h2 class="text-center text-muted py-3">Comments</h2>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 pr-0 text-center">
                                            <img src="img/avatar/<?= $comment['comment_avatar'] ?>" class="img img-rounded img-fluid w-50" />
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                <a class="float-left" href="#"><strong><?= $comment['comment_username'] ?></strong></a>
                                                <span class="float-right px-2 text-muted"><?= date_format(date_create($comment['comment_date']), "d F Y h:i") ?></span>
                                            </p>
                                            <div class="clearfix"></div>
                                            <p class="text-secondary mt-2"><?= $comment['comment_content'] ?></p>
                                            <span class="float-right">
                                                <?php if ($grade == "ADMIN"  || $comment["comment_username"] == $loggined_authorName) {?>
                                                    <a href="asset/delete.php?type=comment&id=<?= $comment['comment_id'] ?>"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                    <div class="post-comments">
                        <form action="asset/insert.php?type=comment&id=<?= $article_id ?>#comment" method="POST">
                            <div class="form-group mt-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group">
                                        <div class="form-inline mb-2">
                                            <label for="replyId"><i class="fa fa-user-circle-o fa-2x"></i></label>
                                            <?php if (isset($loggined_authorName)) : {?>
                                                <input type="text" name="username" value="<?= $loggined_authorName ?>" readonly="readonly">
                                                <input type="hidden" name="avatar_img" value="<?= $loggined_authImg ?>">
                                            <?php } ?>
                                            <?php else: { ?>
                                                <input type="text" name="username" value="<?= "User-".rand() ?>" readonly="readonly">
                                                <input type="hidden" name="avatar_img" value="<?= "def_face.jpg" ?>">
                                            <?php } ?>
                                            <?php endif; ?>

                                            <label for="replyPassword" class="ml-4"><i class="fa fa-unlock-alt fa-2x"></i></label>

                                            <?php if (isset($loggined_authorName)) : {?>
                                                <input type="password" class="form-control ml-2" placeholder="Enter password" name="replyPassword" value="123456789" readonly>
                                            <?php } ?>
                                            <?php else: { ?>
                                                <input type="password" class="form-control ml-2" placeholder="Enter password" name="replyPassword" required>
                                            <?php } ?>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                </ul>
                                <input type="hidden" name="id_article" value="<?= $article_id ?>">
                                <input type="hidden" name="isLoggined" value="<?= isset($_SESSION["id"]) ?>">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Add your comment..."></textarea>
                                <button name="submit" type="submit" class="btn btn-success float-right mt-1">Add Comment</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>
    </main>

    <?php include "asset/footer.php" ?>
</body>
</html>