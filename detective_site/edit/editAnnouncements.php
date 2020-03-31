<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }

    include '../model/model_police.php';
    include '../model/functions.php';

    if (isset($_GET['action'])) {
        $action = filter_input(INPUT_GET, 'action');
        $id = filter_input(INPUT_GET, 'announcement_id');
        if ($action == "Update") {
            $row = grabAnnouncements($id);
            $announcement_title = $row['announcement_title'];
            $announcement = $row['announcement'];
        } 
        
        else 
        {
            $announcement_title = "";
            $announcement = "";
        }
    } 
    elseif (isset($_POST['action'])) 
    {
        $action = filter_input(INPUT_POST, 'action');
        $id = filter_input(INPUT_POST, 'announcement_id');
        $announcement_title = filter_input(INPUT_POST, 'announcement_title');
        $announcement = filter_input(INPUT_POST, 'announcement');
        session_start();
        $employee_id = $_SESSION['user_id'];
    }

    if (isPostRequest() && $action == "Add") {

        $result = addAnnouncement($announcement_title, $announcement);
        header('Location: ../admin_announcements.php');
    } 
    
    elseif (isPostRequest() && $action == "Update") 
    {
        $result = updateAnnouncement($announcement_title, $announcement, $id);
        header('Location: ../admin_announcements.php');
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
                    <h1 class="main-heading"><?php echo $action; ?> Announcements</h1>
                </div>
                <div class="box-container">
                    <div class="black-box-announcement">
                        <form class="form-horizontal" action="editAnnouncements.php" method="post">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <input type="hidden" name="announcement_id" value="<?php echo $id; ?>">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="announcement_title">Announcement Title: </label>
                                <div class="col-sm-10">
                                    <input style="width:350px;" type="text" class="form-control" id="announcement_title" placeholder="Enter Announcement Title Here" name="announcement_title" value="<?php echo $announcement_title; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="announcement">Announcement:</label>
                                <div class="col-sm-10">          
                                    <textarea style="width:550px;" placeholder="Type the announcement here" name="announcement" class="form-control" rows="7" cols="90" style="width:450px;"><?php echo $announcement; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">        
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="submit-button btn-primary"><?php echo $action; ?> Announcements</button>
                                </div>
                            </div>
                        </form>
                        <h5><div class="col-sm-offset-2 col-sm-10"><a href="../admin_announcements.php">Go Back</a></div></h5>
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
