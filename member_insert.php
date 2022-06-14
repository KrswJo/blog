<?php require_once "asset/db.php"; ?>
<?php
    $username   = $_POST["username"];
    $password = $_POST["pass"];
    $created_at = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
    $grade = "CREATOR";

    try {
            $sql = "insert into users (username, password,  created_at, grade) values (:username, :password , :created_at, :grade)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":created_at", $created_at, PDO::PARAM_STR);
            $stmt->bindParam(":grade", $grade, PDO::PARAM_STR);
            $stmt->execute();

            $id_user = $pdo->lastInsertId();
            $_POST["id_user"] = $id_user;

    } catch (PDOException $e){
            echo "예외 발생".$e;
    }
?>

<?php require "asset/insert.php"; ?>