<?php require "asset/db.php" ?>
<?php

$authorId = $_GET["author_id"];

$query = "SELECT distinct users.id, users.grade
                          FROM `users` JOIN `author` on users.id = author.id_user 
                          WHERE author.author_id = :authorId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":authorId", $authorId, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch();
$userId = $row["id"];
$grade = $row["grade"];

if ($grade == "CREATOR")
    $sql = "update users set grade = 'ADMIN' where id = :userId";
else
    $sql = "update users set grade = 'CREATOR' where id = :userId";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$stmt->execute();
echo "complete";

echo "<script>alert('Permission Set was successfully');document.location = './users.php';</script>";
// header("Location: ./users.php", true, 301);