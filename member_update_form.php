<?php include "asset/head.php"; ?>
<?php
if (!isset($_SESSION["id"]))
    header("Location: /index.php", true, 301);

$stmt = $conn->prepare("SELECT  * From author join users on author.id_user = users.id
where users.id= ".$_SESSION["id"]);
$stmt->execute();
$row = $stmt->fetch();

$username = $row ["username"];
$password = $row["password"];
$fullname = $row["author_fullname"];
$email = $row["author_email"];
$description = $row["author_desc"];
$avatar = $row["author_avatar"];
$github = $row["author_fullname"];
$twitter = $row["author_twitter"];
$linkedIn = $row["author_link"];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> 회원수정 페이지 </title>
<script>
    var checked_id = null;

    function check_input()
   {

      if (!document.member_form.username.value) {
          alert("아이디를 입력하세요!");
          document.member_form.id.focus();
          return false;
      }

      if (!document.member_form.pass.value) {
          alert("비밀번호를 입력하세요!");
          document.member_form.pass.focus();
          return false;
      }

      if (!document.member_form.pass_confirm.value) {
          alert("비밀번호확인을 입력하세요!");
          document.member_form.pass_confirm.focus();
          return false;
      }

      if (!document.member_form.authEmail.value) {
          alert("이메일 주소를 입력하세요!");
          document.member_form.email.focus();
          return false;
      }

      if (document.member_form.pass.value !=
          document.member_form.pass_confirm.value) {
          alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
          document.member_form.pass.focus();
          document.member_form.pass.select();
          return false;
      }

      if (check_email() == false){
          alert("이메일을 올바르게 작성하세요.");
          document.member_form.email.focus();
          return false;
      }
   }

   function reset_form() {
      document.member_form.username.value = "";
      document.member_form.pass.value = "";
      document.member_form.pass_confirm.value = "";
      document.member_form.email.value = "";
      document.member_form.id.focus();
      return;
   }

    function check_email() {
        let exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
        let email = $("#authEmail").val();
        console.log(email);

        if(!exptext.test(email)) {
           return false;
        }
        return true;
    }

</script>
</head>
    <body class="d-flex flex-column min-vh-100">
         <?php include "asset/header.php" ?>
        <main class="main">

            <div class="section jumbotron mb-5 h-100">
                <!-- container -->
                <div class="container d-flex flex-column justify-content-center align-items-center h-100">

                    <div class="wrapper my-0 pt-3 bg-white w-50 text-center">
                        <img src="img/logo/logo.png" alt="dev culture logo" style="width: 100px;height: auto;">
                    </div>

                    <div class="wrapper bg-white rounded px-4 py-4 w-50 align-items-center">
                        <form id="member_form" name="member_form" method="POST" enctype="multipart/form-data"
                              onsubmit="return check_input()"
                              action="member_update.php?type=author&id=<?= $_SESSION["id"]?>&img=<?= $avatar ?>">

                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group w-75">
                                    <input type="text" name="username" class="form-control" value="<?= $username ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group w-75">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control" value="<?= $password ?>">
                                <span class="valid-pass"></span>
                            </div>

                            <div class="form-group w-75">
                                <label>Password Check </label>
                                <input type="password" name="pass_confirm" class="form-control" value="<?= $password ?>">
                                <span class="valid-passRepeat"></span>
                            </div>

                            <div class="form-group w-75">
                                <label for="authName">Full Name</label>
                                <input type="text" class="form-control" name="authName" id="authName" value="<?= $fullname ?>">
                            </div>

                            <div class="form-group w-75">
                                <label for="authDesc">Description</label>
                                <input type="text" class="form-control" name="authDesc" id="authDesc " value="<?= $description ?>">
                            </div>

                            <div class="form-group w-75">
                                <label for="authEmail">Email</label>
                                <input type="email" class="form-control" name="authEmail" id="authEmail" value="<?= $email ?>">
                            </div>

                            <div class="form-group w-75">
                                <label for="authImage">Avatar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="authImage" id="authImage" value="<?= $avatar ?>">
                                    <label class="custom-file-label" for="authImage">Choose file</label>
                                </div>
                            </div>

                            <div class="form-group w-75">
                                <label for="authTwitter">Twitter Username <span class="text-info">(optional)</span></label>
                                <input type="text" class="form-control" name="authTwitter" id="authTwitter" placeholder="Ex: jojoldu" value="<?= $twitter ?>">
                            </div>
                            <div class="form-group w-75">
                                <label for="authGithub">Github Username <span class="text-info">(optional)</span></label>
                                <input type="text" class="form-control" name="authGithub" id="authGithub" placeholder="Ex: jojoldu"value="<?= $github ?>">
                            </div>
                            <div class="form-group w-75">
                                <label for="authLinkedin">Linkedin Username <span class="text-info">(optional)</span></label>
                                <input type="text" class="form-control" name="authLinkedin" id="authLinkedin" placeholder="Ex: jojoldu" value="<?= $linkedIn ?>">
                            </div>
                            <input type="hidden" name="submit" value="complete">

                            <hr>
                            <div class="float-right">
                                <input type="submit" name="update" class="btn btn-success" value="수정하기">
                                <div id="reset_button" class="btn btn-success" onclick="reset_form()"> 초기화하기 </div>
                            </div>
                        </form>
                </div>
            </div>
        </main>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</>
</html>