<?php require "asset/db.php" ?>
<?php
$authorId = $_GET["id"];

$query = "SELECT distinct users.id
                          FROM `users` JOIN `author` on users.id = author.id_user 
                          WHERE author.author_id = :authorId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":authorId", $authorId, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch();
$userId = $row["id"];

$query = "delete from author where author_id = :authorId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":authorId", $authorId, PDO::PARAM_INT);
$stmt->execute();

$query = "delete from users where id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":id", $userId, PDO::PARAM_INT);
$stmt->execute();
echo "Complete";

header("Location: ./users.php", true, 301);