<!DOCTYPE html>
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

    <?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }

    include '../model/model_police.php';
    include '../model/functions.php';

    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'evidence_id');
    if (isset($action)) 
    {
        
        if ($action == "Update") {
            $row = grabEvidence($id);
            $evidence_title = $row['evidence_title'];
            $evidence = $row['evidence'];
            $case_id = $row['case_id'];
            $id = $row['evidence_id'];
        } 
        
        else 
        {
            $evidence_title = "";
            $evidence = "";
        }
        var_dump($evidence);
    } 

    
    elseif (isset($_POST['action'])) 
    {
        $action = filter_input(INPUT_POST, 'action');
        $id = filter_input(INPUT_POST, '$evidence_id');
        $evidence_title = filter_input(INPUT_POST, '$evidence_title');
        $evidence = filter_input(INPUT_POST, '$evidence');
    }

    if (isPostRequest() && $action == "Add") {
        $result = addEvidence($evidence_title, $evidence);
        header('Location: ../admin_case_details.php');
    } 
    
    
    elseif (isPostRequest() && $action == "Update") 
    {
        $new_evidence_title = filter_input(INPUT_POST, 'evidence_title');
        $new_evidence = filter_input(INPUT_POST, 'evidence'); 
        $result = updateEvidence($new_evidence_title, $new_evidence, $id);
        header('Location: ../admin_case_details.php');
    }
    
    ?>

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
                <h1 class="main-heading"><?php echo $action; ?> Evidence</h1>
            </div>
            <div class="box-container">
                <div class="black-box-announcement">
                    <form class="form-horizontal" action="editEvidence.php" method="POST">
                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                        <input type="hidden" name="evidence_id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="evidence_title">Evidence Title: </label>
                            <div class="col-sm-10">
                                <input style="width:450px" type="text" class="form-control" id="evience_title" placeholder="Enter Evidence Title Here" name="evidence_title" value="<?php echo $evidence_title; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="evidence">Evidence:</label>
                            <div class="col-sm-10">          
                                <input type="file" name="evidence" id="evidence" style="width:300px;" value="<?php echo $evidence; ?>"></input>
                            </div>
                        </div>

                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="submit-button btn-primary"><?php echo $action; ?> Evidence</button>
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
