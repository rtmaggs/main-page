<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }

    include '../model/model_police.php';
    include '../model/functions.php';

    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'case_id');
    if (isset($action)) {

        if ($action == "Update") {
            $row = grabCases($id);
            $case_title = $row['case_title'];
            $case_description = $row['case_description'];
            $active = $row['is_active'];
        } else {
            $case_title = "";
            $case_description = "";
            $active = "";
        }
    } 

    if (isPostRequest() && $action == "Add") 
    {
        $new_id = filter_input(INPUT_POST, 'case_id');
        $new_case_title = filter_input(INPUT_POST, 'case_title');
        $new_case_description = filter_input(INPUT_POST, 'case_description');
        $new_active = filter_input(INPUT_POST, 'active');
        $result = addCase($new_case_title, $new_case_description, $new_active);
        header('Location: ../admin_case_details.php');
    } 
    
    if (isPostRequest() && $action == "Update") 
    {
        $new_id = filter_input(INPUT_POST, 'case_id');
        $new_case_title = filter_input(INPUT_POST, 'case_title');
        $new_case_description = filter_input(INPUT_POST, 'case_description');
        $new_active = filter_input(INPUT_POST, 'active');
        $result = updateCase($new_case_title, $new_case_description, $new_active, $new_id);
        echo $new_id;
        echo $new_case_title;
        echo $new_case_description;
        echo $new_active;
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
                        <h1 class="main-heading"><?php echo $action; ?> Case</h1>
                    </div>
                    <div class="box-container">
                        <div class="black-box-announcement">
                            <form class="form-horizontal" action="#" method="POST">
                                <input type="hidden" name="action" value="<?php echo $action; ?>">
                                <input type="hidden" name="case_id" value="<?php echo $id; ?>">

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="case_title">Case Title: </label>
                                    <div class="col-sm-10">
                                        <input style="width:350px;" type="text" class="form-control" id="case_title" placeholder="Enter Case Title Here" name="case_title" value="<?php echo $case_title; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="case_description">Case Description:</label>
                                    <div class="col-sm-10">          
                                        <textarea style="width:550px;" placeholder="Type The Description Here" name="case_description" class="form-control" rows="7" cols="90" style="width:450px;"><?php echo $case_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="active">Case Active:</label>
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="checkbox" id="active" name="active" value="1" <?php if ($active == 0) {
                                                                                                                        echo "";
                                                                                                                    } else {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                                    </div>
                                </div>

                                <div class="form-group">        
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="submit-button btn-primary"><?php echo $action; ?> Case </button>
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
