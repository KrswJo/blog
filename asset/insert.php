<?php require "db.php"; ?>
<?php

// Get type from header
$type = $_GET['type'];

if ($conn) {

    if (isset($_POST["submit"])) {
        switch ($type) {
            case "category":
                $data = array(
                    "category_name"  => test_input($_POST["catName"]),
                    "category_color" => test_input($_POST["catColor"]),
                );
                insertToDB($conn, $type, $data);
                header("Location: ../categories.php", true, 301);
                exit;
                break;
            case "author":
                uploadImage("authImage", "../img/avatar/");

                // PREPARE DATA TdO INSERT INTO DB
                $data = array(
                    "author_fullname" => test_input($_POST["authName"]),
                    "author_desc" => test_input($_POST["authDesc"]),
                    "author_email" =>  test_input($_POST["authEmail"]),
                    "author_twitter" =>  test_input($_POST["authTwitter"]),
                    "author_github" => test_input($_POST["authGithub"]),
                    "author_link" => test_input($_POST["authLinkedin"]),
                    "author_avatar" => test_input($_FILES["authImage"]["name"]),
                    "id_user" => test_input($_POST["id_user"])
                );

                $tableName = 'author';

                // Call insert function
                insertToDB($conn, $tableName, $data);
                // Go to show.php
                header("Location: ".$_SERVER["HTTP_HOST"], true, 301);
                exit;
                break;
            case "article":
                // Upload Image
                uploadImage("arImage", "../img/article/");

                // PREPARE DATA TO INSERT INTO DB
                $data = array(
                    "article_title" => test_input($_POST["arTitle"]),
                    "article_content" => $_POST["arContent"],
                    "article_image" => test_input($_FILES["arImage"]["name"]),
                    "article_created_time" => date('Y-m-d H:i:s'),
                    "id_categorie" => test_input($_POST["arCategory"]),
                    "id_author" => test_input($_POST["arAuthor"]),
                    "article_views" => 0
                );

                // $tableName = 'article';

                // Call insert function
                insertToDB($conn, $type, $data);


                // Go to show.php
                header("Location: ../index.php", true, 301);
                exit;
                break;
            case "comment":
                $id = test_input($_POST["id_article"]);

                $stmt = $pdo->prepare("Select password From users JOIN author ON id_user = id where author_fullname = :username");
                $stmt->bindParam(":username", $_POST["username"]);
                $stmt->execute();
                $row = $stmt->fetch();

                $password = ($_POST["isLoggined"]) == 1 ? $row["password"] : $_POST["replyPassword"];
                // PREPARE DATA TO INSERT INTO DB


                $data = array(
                    "comment_username" => test_input($_POST["username"]),
                    "comment_password" => $password,
                    "comment_avatar" => test_input($_POST["avatar_img"]),
                    "comment_content" => test_input($_POST["comment"]),
                    "comment_date" => date('Y-m-d H:i:s'),
                    "id_article" =>  test_input($_POST["id_article"])
                );

                $tableName = 'comment';

                // Call insert function
                insertToDB($conn, $tableName, $data);

                // Go to show.php
                header("Location: ../single_article.php?id=$id", true, 301);
                exit;
                break;

            case "users":
                $role_creator = "CREATOR";

                $data = array(
                    "email" => test_input($_POST["email"]),
                    "username" => test_input($_POST["username"]),
                    "password"=>test_input($_POST["pass"]),
                    "created_at" => date('Y-m-d H:i:s'),
                    "role" =>  $role_creator
                );

                $tableName = 'users';
                insertToDB($conn, $tableName, $data);
                header("Location: ../index.php", true, 301);
                exit;
                break;

            default:
                echo "ERROR";
                break;
        }
    }
} else {
    echo 'Error: ' . $e->getMessage();
}

function insertToDB($conn, $table, $data)
{

    // Get keys string from data array
    $columns = implodeArray(array_keys($data));

    // Get values string from data array with prefix (:) added
    $prefixed_array = preg_filter('/^/', ':', array_keys($data));
    $values = implodeArray($prefixed_array);

    try {
        // prepare sql and bind parameters
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $conn->prepare($sql);

        // insert row
        $stmt->execute($data);

        echo "New records created successfully";
    } catch (PDOException $error) {
        echo $error;
    }
}

function implodeArray($array)
{
    return implode(", ", $array);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function uploadImage($name, $dest)
{

    $target_dir = $dest;
    $target_file = $target_dir . basename($_FILES[$name]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$name]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES[$name]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES[$name]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>