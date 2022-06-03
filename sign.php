<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        header('Content-type: application/json');
        $resp = ['err' => 0];

        if (isset($_POST['username']) && isset($_POST['hash'])) {
            
            $username = $_POST['username'];
            $hash = $_POST['hash'];

            if (strlen($hash) != 40) {
                die(json_encode(['err' => 1]));
            }
            
            if (strlen($username) < 3 || strlen($username) > 16 || !preg_match('/^[_a-zA-Z0-9]*$/', $username)) {
                die(json_encode(['err' => 1]));
            }

            $connect = mysqli_connect('localhost', 'admin', '0jm2Ne1fWNEY', 'app');
            

            if ($result == false) {
                die(json_encode(['err' => 1]));
            }
            die(json_encode(['err' => 0]));

        } else {
            die(json_encode(['err' => 1]));
        }

        die(json_encode(['err' => 0]));
    }
?>

<?php
    include("auth.php")
?>
<link rel="stylesheet" type="text/css" href="css/sign.css">
<body>
	<h1 style="text-align: center;">Вход</h1>
	<hr style="max-width: 400px; min-width: 196px;">
	<form>
		<div class="inp">
			<h2 class = "type">Имя</h2>
			<input type="text" name="username" id="username" placeholder="Введите ник">
            <div class="msg hidden" id="msg-username">Nickname</div>
			<h2 class = "type">Пароль</h2>
			<input type="password" name="password" id="password" placeholder="Введите пароль">
            <div class="msg hidden" id="msg-password">Password</div>
			<br>
            <br>
			<a href="#" class="forgot">Не помню имя или пароль</a>
		</div>
		<hr style="max-width: 400px; min-width: 196px; margin-top: 2em;">
	</form>
	<div class="reg">
		<button class = "registr" onclick="check()">Войти</button>
	</div>
	<div style="text-align: center;">
		<h3 style="text-align: center;">Или</h3>
	</div>
	<div style = "text-align: center;">
		<h2><a href="reg.php">Зарегистрироваться</a><h2>
	</div>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script src="/js/sha1.min.js"></script>
    <script>
            function check(){
                var username = $("#username").val();
                var password = $("#password").val();
                var name_check = /^[A_Za-z0-9_-]*$/;


                $("#msg-username").addClass("hidden");
                $("#msg-password").addClass("hidden");
                $('.inp').children('input').each(function() {
                    $(this).removeClass("no");
                });

                if ((name_check.test(username) == false) || (username.length < 3 || username.length > 16)) {
                    $("#msg-username").removeClass("hidden");
                    $("#username").addClass("no");
                    
                }
                if (password.length < 5) {
                    $("#msg-password").removeClass("hidden");
                    $("#password").addClass("no");
                    return;
                }

                
                $.post("/sign.php", {"username": username, "hash": sha1(password)}).done(function(data) {
                    if (data['err'] == 0) {
                        window.location.href = "/fact.php";
                    } else {
                        alert("Неизвестная ошибка!");
                    }
                });
            }
    </script>
</body>
</html>
