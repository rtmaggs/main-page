<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }

    include '../model/model_police.php';
    include '../model/functions.php';
    
    if (isset($_POST['upload']))
    {
        echo $_FILES['file'];
    }

    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'policeID');
    if (isset($action)) {
        
        if ($action == "Update") {
            $row = grabEmployees($id);
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $job_title = $row['job_title'];
            $email = $row['email'];
            $password = $row['pwd'];
            $phone = $row['phone'];
            $photo = $row['photo'];
        } else 
        {
            $firstname = "";
            $lastname = "";
            $job_title = "";
            $email = "";
            $password = "";
            $phone = "";
            $photo = "";
        }
    }

    if (isPostRequest() && $action == "Add") 
    {
        if(isset($_GET['case_id']))
        {
            $case_id = filter_input(INPUT_GET, 'case_id');
        } else {
            $case_id = "";
        }
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $job_title = filter_input(INPUT_POST, 'job_title');
        $email = filter_input(INPUT_POST, 'email');
        $password = sha1(filter_input(INPUT_POST, 'pwd'));
        $phone = filter_input(INPUT_POST, 'phone');
        $photo = filter_input(INPUT_POST, 'photo');

        $result = addEmployee($firstname, $lastname, $job_title, $email, $password, $phone, $photo, $case_id);

        header('Location: ../admin_employee.php');
    } 
    
    elseif (isPostRequest() && $action == "Update")
    {
        $id = filter_input(INPUT_POST, 'employee_id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $job_title = filter_input(INPUT_POST, 'job_title');
        $email = filter_input(INPUT_POST, 'email');
        if($_POST['pwd'] != ""){
            $password = filter_input(INPUT_POST, 'pwd');
        }
        $phone = filter_input(INPUT_POST, 'phone');
        $photo = filter_input(INPUT_POST, 'photo');

        if(isset($password)){
            $result = updateEmployee($firstname, $lastname, $job_title, $email, $password, $phone, $photo, $id);
        } else {
            $result = updateEmployeeWithoutPassword($firstname, $lastname, $job_title, $email, $phone, $photo, $id);
        }
        echo $result;
        header('Location: ../admin_employee.php');
    }
?>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="../css/normalize.css" />
        <title>R&T Police Department</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> <!-- bootsrap -->
        <link rel="stylesheet" type="text/css" href="../css/style.css" />

    </head>

    <body>

    <div class="wrapper">
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <a class="navbar-brand" href="#">RTPD</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">

                        <li class="nav-item"><a class="nav-link" href="../admin_announcements.php">Announcements</a></li>
                        
                        <li class="nav-item"><a class="nav-link" href="../admin_case_details.php">Case Details</a></li>

                        <li class="nav-item"><a class="nav-link" href="../admin_messages.php">Messages</a></li>
                        
                        <li class="nav-item"><a class="nav-link" href="../admin_employee.php">Employees</a></li>

                    </ul>
                </div>
            </nav>
            <br>

            <main>
                <article>
                <div class="box-container">
                    <h1 class="main-heading"><?php echo $action; ?> Employee</h1>
                </div>
                <div class="box-container">
                    <div class="black-box-announcement">

                    <form class="form-horizontal" action="#" method="POST">
                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                        <input type="hidden" name="employee_id" value="<?php echo $id; ?>">
                    
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="firstname">First Name:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="text" class="form-control" id="firstname" placeholder="Enter Employee First Name" name="firstname" value="<?php echo $firstname; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lastname">Last Name:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="text" class="form-control" id="lastname" placeholder="Enter Employee Last Name" name="lastname" value="<?php echo $lastname; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="job_title">Job Title:</label>
                            <div class="col-sm-10">          
                            <select style="width: 100px;" class="form-control" id="job_title" name="job_title" value="<?php echo $job_title; ?>">
                                <option value="Admin" <?php if($job_title == "Admin"){ echo "selected"; }?>>Admin</option>
                                <option value="Detective" <?php if($job_title == "Detective"){ echo "selected"; }?>>Detective</option>
                            </select>                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">E-Mail:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="text" class="form-control" id="email" placeholder="Enter Employee E-Mail" name="email" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Password:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pwd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone">Phone:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="text" class="form-control" id="phone" placeholder="Enter Employee Phone Number" name="phone" value="<?php echo $phone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="photo">Photo:</label>
                            <div class="col-sm-10">          
                                <input style="width:350px;" type="file" placeholder="Photo" name="photo" style="width:300px;" value="<?php echo $photo; ?>"></input>
                            </div>
                        </div>
                        
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="submit-button btn-primary"><?php echo $action; ?> Employee</button>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
                </article>
            </main>

        </div>
            
            
            
            <footer class="section-2">
                <img class="emblem-badge" src="../images/RTPD-emblem.svg" alt="R&TPD Emblem">
                <img class="emblem-badge" src="../images/RTPD-badge.png" alt="R&TPD Badge">
                <div class="address">
                    <h3>Location</h3>
                    <p>4420 Main Street</p>
                    <p>New York, New York</p>
                    <br>

                    <br>
                    <a class="footer-link" href="../login.php">Back to Login</a>
                </div>
            </footer>
    </body>

</html>
