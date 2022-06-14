<?php require "asset/db.php"; ?>
<?php
   $username = $_POST["username"];

   if(!$username) {
      echo "아이디를 입력해 주세요!";
   }
   else {
       try {
           $sql = "select * from users where username= :username";
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(":username", $username, PDO::PARAM_STR);
           $stmt->execute();

           if ($stmt->rowCount() == 1){
               $response = array(
                   'msg' => "해당 아이디는 중복되므로 다른 아이디를 사용해 주세요!",
                    'duplicated_id' => true
               );
               echo json_encode($response);
           }

            else{
                $response = array(
                    'msg' => "해당 아이디는 사용 가능합니다.",
                    'duplicated_id' => false
                );
               echo json_encode($response);
            }

       } catch (PDOException $e){
           $response = array(
               'msg' => "오류가 발생하였습니다.",
               'duplicated_id' => null
           );
           echo json_encode($response);
       }
       unset($stmt);
       unset($pdo);
   }
?>

