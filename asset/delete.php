<?php require "db.php"; ?>
<?php
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($conn) {
        switch ($type) {
            case "article":
                delete($conn, $type, $id, "allArticle.php");
                break;
            case "category":
                delete($conn, $type, $id, "categories.php");
                break;
            case "author":
                delete($conn, $type, $id, "users.php");
                break;
            case "comment" :
                $link = str_replace("http://localhost/blog/","",$_SERVER["HTTP_REFERER"]);
                delete($conn, $type, $id, $link);
            default:
                break;
        }
    } else {
        echo 'Error: ' . $e->getMessage();
    }

    function delete($conn, $table, $id, $goto) {
        $col = $table . "_id";

        try {
            $sql = "DELETE FROM $table WHERE $col = $id";
            $conn->exec($sql);
            echo "$table Deleted Successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        echo json_encode($goto);
        $conn = null;

        header("Location: ../$goto", true, 301);
        exit;
    }
?>