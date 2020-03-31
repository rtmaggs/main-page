<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }

    include '../model/model_police.php';
    include '../model/functions.php';

    if (isset($_GET['action'])) {
        $action = filter_input(INPUT_GET, 'action');
        $id = filter_input(INPUT_GET,'suspect_id');
        if ($action == "Update") {
            $row = grabSuspects($id);
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $address = $row['address'];
            $dob = $row['dob'];
            $eye_color = $row['eye_color'];
            $height = $row['height'];
            $weight = $row['suspect_weight'];
            $wanted_level = $row['wanted_level'];
            $arrest_time = $row['arrest_time'];
            $photo = $row['photo'];
        } 

        else 
        {
            $firstname = "";
            $lastname = "";
            $address = "";
            $dob = "";
            $eye_color = "";
            $height = "";
            $weight = "";
            $wanted_level = "";
            $arrest_time = "";
            $photo = "";
        }
       
        
        
    } 
    elseif (isset($_POST['action'])) {
        $action = filter_input(INPUT_POST, 'action');

    }

    if (isPostRequest() && $action == "Add") 
    {
        $id = filter_input(INPUT_POST, 'suspect_id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $address = filter_input(INPUT_POST, 'address');
        $dob = filter_input(INPUT_POST, 'dob');
        $eye_color = filter_input(INPUT_POST, 'eye_color');
        $weight = filter_input(INPUT_POST, 'weight');
        $height = filter_input(INPUT_POST, 'height');
        $arrest_time = filter_input(INPUT_POST, 'arrest_time');
        $wanted_level = filter_input(INPUT_POST, 'wanted_level');
        $photo = filter_input(INPUT_POST, 'photo');
        $case_id = filter_input(INPUT_GET, 'case_id');
        $result = addSuspect($firstname, $lastname, $address, $dob, $eye_color, $weight, $height, $arrest_time, $wanted_level, $photo, $case_id);
        header('Location: admin_case_details.php');
    } 
    
    elseif (isPostRequest() && $action == "Update")
    {
        $id = filter_input(INPUT_POST, 'suspect_id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $address = filter_input(INPUT_POST, 'address');
        $dob = filter_input(INPUT_POST, 'dob');
        $eye_color = filter_input(INPUT_POST, 'eye_color');
        $weight = filter_input(INPUT_POST, 'weight');
        $height = filter_input(INPUT_POST, 'height');
        $arrest_time = filter_input(INPUT_POST, 'arrest_time');
        $wanted_level = filter_input(INPUT_POST, 'wanted_level');
        $photo = filter_input(INPUT_POST, 'photo');

        $result = updateSuspect($firstname, $lastname, $address, $dob, $eye_color, $height, $weight, $arrest_time, $wanted_level, $photo, $id);
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

            <main>
                <article>
                    <div class="box-container">
                        <h1 class="main-heading"><?php echo $action; ?> Suspect</h1>
                    </div>
                    <div class="box-container">
                        <div class="black-box-announcement">
                        <form class="form-horizontal" action="#" method="POST">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <input type="hidden" name="suspect_id" value="<?php echo $id; ?>">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="firstname">Suspect First Name: </label>
                                <div class="col-sm-10">
                                    <input style="width:350px;" type="text" class="form-control" id="firstname" placeholder="Enter Suspect First Name" name="firstname" value="<?php echo $firstname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="lastname">Suspect Last Name:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="lastname" placeholder="Enter Suspect Last Name" name="lastname" value="<?php echo $lastname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="address">Address:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="address" placeholder="Enter Suspects Address" name="address" value="<?php echo $address; ?>"></div>
                                </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="dob">Date of Birth:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="dob" placeholder="Enter Suspects Date of Birth" name="dob" value="<?php echo $dob; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="eye_color">Eye Color:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="eye_color" placeholder="Enter Suspects Eye Color" name="eye_color" value="<?php echo $eye_color; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="eye_color">Height:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="height" placeholder="Enter Suspects Height" name="height" value="<?php echo $height; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="eye_color">Weight:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="weight" placeholder="Enter Suspects Weight" name="weight" value="<?php echo $weight; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="arrest_time">Arrest Time:</label>
                                <div class="col-sm-10">          
                                    <input style="width:350px;" type="text" class="form-control" id="arrest_time" placeholder="Enter Suspects Arrest Time" name="arrest_time" value="<?php echo $arrest_time; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="wanted_level">Wanted Level:</label>
                                <div class="col-sm-10">          
                                    <select style="width: 100px;" class="form-control" id="wanted_level" name="wanted_level" value="<?php echo $wanted_level; ?>">
                                        <option value="0" <?php if($wanted_level == 0){ echo "selected"; }?>>0</option>
                                        <option value="1" <?php if($wanted_level == 1){ echo "selected"; }?>>1</option>
                                        <option value="2" <?php if($wanted_level == 2){ echo "selected"; }?>>2</option>
                                        <option value="3" <?php if($wanted_level == 3){ echo "selected"; }?>>3</option>
                                        <option value="4" <?php if($wanted_level == 4){ echo "selected"; }?>>4</option>
                                        <option value="5" <?php if($wanted_level == 5){ echo "selected"; }?>>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="photo">Photo:</label>
                                <div class="col-sm-10">          
                                    <input type="file" placeholder="Photo" name="photo" style="width:300px;" value="<?php echo $photo; ?>"></input>
                                </div>
                            </div>
                            <div class="form-group">        
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button class="submit-button btn-primary"><?php echo $action; ?> Suspects</button>
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
