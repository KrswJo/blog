<?php require_once "asset/db.php"; ?>
<?php
    $password = $_POST["pass"];
    $user_id = $_GET["id"];

    try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":id", $user_id);
            $stmt->execute();

    } catch (PDOException $e){
            echo "예외 발생".$e;
    }
?>
<?php require "asset/update.php"; ?>



   
