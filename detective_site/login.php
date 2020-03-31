<?php
session_start();
include __DIR__ .'/model/model_police.php';
include __DIR__ .'/model/functions.php';

    if(isPostRequest()){
        $email = filter_input(INPUT_POST,'email');
        $pwd = sha1(filter_input(INPUT_POST,'pwd'));
        $userCredentials = getLogin($email, $pwd);

        if($userCredentials[0]["job_title"] == "Admin")
        {
            if($userCredentials[0]['email'] == $email && $userCredentials[0]['pwd'] == $pwd)
            {
                $_SESSION['admin_login'] = "TRUE";
                $_SESSION['user_id'] = $userCredentials[0]['employee_id'];
                header('location: admin_announcements.php');
            }
        }

        else if($userCredentials[0]["job_title"] == "Detective")
        {
            if($userCredentials[0]['email'] == $email && $userCredentials[0]['pwd'] == $pwd)
            {
                $_SESSION['user_login'] = "TRUE";
                $_SESSION['user_id'] = $userCredentials[0]['employee_id'];
                header('location: user_announcements.php');
            }
        }

    }
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <title>R&T Police Department</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> <!-- bootsrap -->
    <link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>
    <div class="wrapper">
        <main>
            <article>
                <div class="box-container">
                    
                </div>
                <div class="box-container">
                    <div class="black-box-announcement">
                        <div class="login-box">
                            <h1 class="main-heading">LOGIN</h1>
                            <form action="#" method="POST">
                                <input type="email" class="form-control" name="email" placeholder="Enter Email"><br>
                                <br>
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password"><br>
                                <input type="checkbox" onclick="myFunction()"> Show Password
                                <br><br>
                                <input class="submit-button btn-primary" type="submit" name="login" value="Login">
                                <script>
                                    function myFunction() {
                                    var pwd = document.getElementById("pwd");
                                    if (pwd.type === "password") {
                                        pwd.type = "text";
                                    } else {
                                        pwd.type = "password";
                                    }
                                    }
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </main>
    </div>
</body>
