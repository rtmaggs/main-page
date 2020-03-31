<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }
    include '../model/model_police.php';
    include '../model/functions.php';


    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'witness_id');
    if (isset($action)) {
        
        if ($action == "Update") {
            $row = getWitnesses($id);
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $phone = $row['phone'];
            $witness_statement = $row['witness_statement'];
            $photo = $row['photo'];
        } 
        
        else 
        {
            $firstname = "";
            $lastname = "";
            $phone = "";
            $witness_statement = "";
            $photo = "";
        }
        
    }

    if (isPostRequest() && $action == "Add") 
    {
        $action = filter_input(INPUT_POST, 'action');
        $id = filter_input(INPUT_POST, 'witness_id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $phone = filter_input(INPUT_POST, 'phone');
        $witness_statement = filter_input(INPUT_POST, 'witness_statement');
        $photo = filter_input(INPUT_POST, 'photo');
        $case_id= filter_input(INPUT_GET, 'case_id');
        echo $case_id;
        $result = addWitness($firstname, $lastname, $phone, $witness_statement, $photo, $case_id);
        header('Location: ../admin_case_details.php');
    } 
    
    elseif (isPostRequest() && $action == "Update")
    {
        $action = filter_input(INPUT_POST, 'action');
        $id = filter_input(INPUT_POST, 'witness_id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $phone = filter_input(INPUT_POST, 'phone');
        $witness_statement = filter_input(INPUT_POST, 'witness_statement');
        $photo = filter_input(INPUT_POST, 'photo');

        $result = updateWitness($firstname, $lastname, $phone, $witness_statement, $photo, $id);
        echo $result;
        header('Location: ../admin_case_details.php');
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
                    <h1 class="main-heading"><?php echo $action; ?> Witness</h1>
                </div>
                <div class="box-container">
                    <div class="black-box-announcement">
                        <form class="form-horizontal" action="#" method="POST">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <input type="hidden" name="witness_id" value="<?php echo $id; ?>">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="firstname">Witness First Name: </label>
                                <div class="col-sm-10">
                                    <input style="width:350px;" type="text" class="form-control" id="firstname" placeholder="Enter Witness First Name" name="firstname" value="<?php echo $firstname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="lastname">Witness Last Name:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="lastname" placeholder="Enter Witness Last Name" name="lastname" value="<?php echo $lastname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="phone">Witness Phone Number:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="phone" placeholder="Enter Witness Phone Number" name="phone" value="<?php echo $phone; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="witness_statement">Witness Statement:</label>
                                <div class="col-sm-10">          
                                    <textarea style="width:550px;" placeholder="Enter Witness state" name="witness_statement" class="form-control" rows="7" cols="90" style="width:450px;"><?php echo $witness_statement; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="eye_color">Witness Photo:</label>
                                <div class="col-sm-10">          
                                    <input type="file" placeholder="Photo" name="photo" style="width:300px;" value="<?php echo $photo; ?>"></input></div>
                            </div>

                            <div class="form-group">        
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="submit-button btn-primary"><?php echo $action; ?> Witness</button>
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
