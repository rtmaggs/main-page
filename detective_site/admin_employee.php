<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }
    include __DIR__ . '/model/model_police.php';
    include __DIR__ . '/model/functions.php';
    
    $getEmployees = getEmployees();

        
        
?>
<!DOCTYPE html>
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
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-brand" href="#">RTPD</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">

                    <li class="nav-item"><a class="nav-link" href="admin_announcements.php">Announcements</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="admin_case_details.php">Case Details</a></li>

                    <li class="nav-item"><a class="nav-link" href="admin_messages.php">Messages</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="admin_employee.php">Employees</a></li>
                                        
                </ul>
            </div>
        </nav>
        <h1 class="main-heading">Employees</h1>
    
        <table class="table table-striped table-dark" style="width: 1000px; color: #ffffff;margin-left:auto;margin-right:auto;">
            <thead>
                <tr>
                    <th></th>
                    <th><b><u>First Name:</u></b></th>
                    <th><u>Last Name:</u></th>
                    <th><u>Position:</u></th>
                    <th><u>Email:</u></th>
                    <th><u>Phone:</u></th><br>
                    <th><u><a href="edit/editEmployees.php?action=Add">Add Employee</a></u></th>
                </tr>
            </thead>
            <tbody>
                
            
                
            <?php foreach ($getEmployees as $row): ?>
                <tr>
                    <td>
                        <form action="admin_employee.php" method="post">
                            <input type="hidden" name="policeID" value="<?php echo $row['employee_id']; ?>" />
                        </form>
                    </td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['job_title']; ?></td>   
                    <td><?php echo $row['email']; ?></td>  
                    <td><?php echo $row['phone']; ?></td>
                    <td><a href="edit/editEmployees.php?action=Update&policeID=<?php echo $row['employee_id']; ?>">Edit</a> | <a href="delete.php?id=<?php echo $row['employee_id']; ?>&from=Employees2">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        
        <div style="height:100px;"></div>
    
        <footer class="section-2">
        <img class="emblem-badge" src="images/RTPD-emblem-210.png" alt="R&TPD Emblem">
        <img class="emblem-badge" src="images/RTPD-badge-210.png" alt="R&TPD Badge">
        <div class="address">
            <h3>Location</h3>
            <p>4420 Main Street</p>
            <p>New York, New York</p>
            <br>

            <br>
            <a class="footer-link" href="login.php">Back to Login</a>
        </div>
    </footer>
</body>