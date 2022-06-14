<header class="blog-header border-bottom shadow-sm bg-white">
    <div class="container-fluid" style="padding-left: 3rem; padding-right:3rem">

        <div class="d-flex flex-column flex-md-row align-items-center py-2">
            <a href="index.php" class="my-0 mr-md-auto" style="width: 6rem;">
                <img src="https://image.rocketpunch.com/company/118/woowahan_logo_1595824139.png?s=400x400&t=inside" alt="dev culture logo" style="width: 100%;height:80%">
            </a>

            <?php if ($loggedin) : ?>

                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted<" href="index.php">Home</a>
                    <a class="p-2 px-5 text-muted" href="articleOfCategory.php">Articles</a>
                    <a class="p-2 px-5 text-muted" href="article.php"> My Article</a>

                    <?php if ($grade == "ADMIN" ){ ?>
                        <a class="p-2 px-5 text-muted" href="categories.php"> Category</a>
                        <a class="p-2 px-5 text-muted" href="allArticle.php"> All Article </a>
                        <a class="p-2 px-5 text-muted" href="users.php"> Users </a>
                    <?php } ?>

                </nav>

            <?php else : ?>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted" href="articleOfCategory.php">Articles</a>
                </nav>

            <?php endif;  ?>

            <li style="list-style-type: none">
                <a href="../blog/member_update_form.php"><?= ($loggedin) ? $username." 님" : ''; ?></a>
                <?= ($loggedin) ? " [ ".$grade."  ] " : ''; ?>
            </li>
            <li style="list-style-type: none; margin: 0 10px 0 10px">  | </li>
            <li style="list-style-type: none">
                <a href="<?= ($loggedin) ? 'Logout.php' : 'login.php'; ?>">
                    <?= ($loggedin) ? ' Logout ' : ' Login '; ?>
                </a>
            </li>
            <li style="list-style-type: none; margin: 0 10px 0 10px"">  | </li>
            <li style="list-style-type: none"> <a href="member_form.php"> Sign Up </a> </li>

        </div>
    </div>
</header>