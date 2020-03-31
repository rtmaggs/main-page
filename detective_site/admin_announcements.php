<?php
    session_start();
    if(!isset($_SESSION['admin_login'])){
        header('Location: login.php');
    }
    include __DIR__ .'/model/model_police.php';
    include __DIR__ .'/model/functions.php';
    
    $listAnnouncements = listAnnouncements();
    $employees = getEmployees();

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

        <main>
            <article>
            <div class="box-container">
                <h1 class="main-heading">Announcements</h1>
            </div>
            <div class="box-container">
                <div class="black-box-announcement">
                    <?php foreach ($listAnnouncements as $row): ?>
                        <form action="admin_announcements.php" method="post">
                            <input type="hidden" name="announcement_id" value="<?php echo $row['announcement_id']; ?>" />
                                <div class="announcements container">
                                    <h2 class="row col"><?php echo $row['announcement_title']; ?></h2>
                                    <p class="row col"><?php echo $row['announcement']; ?></p>
                                    <span class="row col">Posted By: &lt;<?php foreach($employees as $employee): ?><?php if($row['employee_id'] == $employee['employee_id']): ?><?php echo $row['employee_id']; ?><?php endif; ?><?php endforeach; ?>&gt; on &lt;<?php echo $row['post_time']; ?>&gt;</span><br>
                                    <a href="edit/editAnnouncements.php?action=Update&announcement_id=<?php echo $row['announcement_id']; ?>">Update Announcement</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete.php?id=<?php echo $row['announcement_id']; ?>&from=Announcements">Delete Announcement</a>
                                </div>
                            <br><br>
                        </form>
                    <?php endforeach; ?>
                </div>
                <h3><a href="edit/editAnnouncements.php?action=Add"> Add Announcement</a></h3>
            </div>
            </article>
        </main>

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

</html>