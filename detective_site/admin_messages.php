<?php
session_start();
if(!isset($_SESSION['admin_login'])){
    header('Location: login.php');
}

include __DIR__ . '/model/model_police.php';

$_SESSION["user_id"] = 14;
if(isset($_SESSION["user_id"])){
    $sender = $_SESSION["user_id"];
    $messages = getMessagesForLoggedIn($sender);
}

$employees = getEmployees();
$search = filter_input(INPUT_POST, 'message_content');

if(isset($_GET['recipient_id'])){
    $recipient = filter_input(INPUT_GET, 'recipient_id');
} else {
    $recipient[0] = "No recipient selected.";
}
if(isset($_POST['message_content'])){
    $messageContent = filter_input(INPUT_POST, 'message_content');

    $result = addMessage($recipient, $sender, $messageContent);
}

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
    <script src="https://cdn.tiny.cloud/1/3ppu9v2fjvfwfm9z8bpggpwi7t9pfghz0sbuckviij5ihwp7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                <div class="tab"><h2><span class="triangle">&#9660;</span>Write Message</h2></div>
                <div class="black-box-wide-2">
                    <form action="#" method="POST" style="display:flex;flex-grow:1;flex-wrap:wrap;">
                        <p>Recipient: <span class="display_recipient">
                            <?php if(isset($_GET["recipient_id"])): ?>
                                <?php foreach($employees as $employee): ?>
                                    <?php if($employee["employee_id"] == $_GET["recipient_id"]): ?>
                                        <?php echo $employee["firstname"]." ".$employee["lastname"]; ?>
                                    <?php endif; ?>
                                    
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span>No recipient selected</span>
                            <?php endif; ?>
                        </span></p>
                        <input type="hidden" id="recipient" name="recipient" value="">
                        <textarea id="message_content" name="message_content" style="display:flex;flex-grow:1;resize:none;"></textarea>
                        <button class="submit-button btn-primary" id="smessage">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="box-container">
                <div class="tab"><h2><span class="triangle">&#9660;</span>Messages</h2></div>
                <div class="black-box-wide-2">
                    <div class="black-box-messages">
                    <table class="table table-dark col table-style">
                        <tbody>
                            <?php if(isset($_GET["recipient_id"])): ?>
                            <?php foreach($messages as $row): ?>
                                <?php if($row["employee_id"] == $recipient): ?>
                                    <tr>
                                        <td><a href="admin_messages.php?message_id=<?php echo $row["message_id"] ?><?php if(isset($_GET["recipient_id"])){ echo "&"."recipient_id=".$_GET["recipient_id"]; } ?>"><?php echo substr($row["content"],0,30);?></a></td>
                                        <td><?php echo $row["time_sent"]; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td><?php echo "No recipient selected."; ?><td><tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box-container">
                <div class="tab"><h2><span class="triangle">&#9660;</span>Message Content</h2></div>
                <div class="black-box-wide-2" style="justify-content:left;padding:35px;">
                <p>
                <?php if(isset($_GET["message_id"])): ?>
                    <?php foreach($messages as $row) :?>
                        <?php if($row["message_id"] == $_GET["message_id"]): ?>
                            <?php echo $row["content"]; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo "No message selected."; ?>
                <?php endif; ?>
                </p>
                <p><span style="visibility:hidden;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at lorem non risus rhoncus ullamcorper. Vivamus suscipit, elit ac porta faucibus, metus lectus hendrerit est, at consequat magna quam ut nisl. Cras luctus dolor eget dui fermentum, eget feugiat lectus laoreet. Vestibulum efficitur dictum turpis ac lobortis. Vivamus a tincidunt sapien. Pellentesque ultricies sem eget quam placerat, ut iaculis nisl ornare. Ut quis erat fermentum, dapibus elit et, condimentum ante. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam tincidunt ipsum vitae nibh semper, eget pellentesque ipsum pulvinar.</span></p>

                </div>
            </div>

            </article>

            <div class="black-box">
                <h2>Employees</h2>
                <div class="black-box-employees">
                <table class="table table-dark table-style">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php foreach($employees as $employee): ?>
                                <tr>
                                    <td><a href="admin_messages.php?recipient_id=<?php echo $employee["employee_id"]; ?><?php if(isset($_GET["message_id"])){ echo "&"."message_id=".$_GET["message_id"]; } ?>"><?php echo $employee["firstname"]." ".$employee["lastname"]; ?></a></td>
                                    <td><?php echo "offline"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        window.autoHeight = {};

        $('.tab').click(function(e){
            $(this).css('pointer-events', 'none');
            setTimeout(function(){
                $('.tab').css('pointer-events', 'auto');
            }, 1000);
            var thisHeight = $(this).parent().height();
            var thisIndex = $(this).parent().index().toString();
            if(thisHeight > 38){
                window.autoHeight[thisIndex] = thisHeight;
                $(this).parent().animate({height:"38px"});
                $(this).find('span').html('&#9654;');
            }
            else if(thisHeight == 38){
                $(this).find('span').html('&#9660;');
                for(var k in window.autoHeight){
                    console.log('going back to original height of' + ' ' + window.autoHeight[k] + 'px.');
                    if(thisIndex == k){
                        $(this).parent().animate({height:window.autoHeight[k]});
                    }
                }
            }
        });
    </script>

    <script>
        tinymce.init({selector:'textarea', resize: 'false', skin:'oxide-dark', width:'100%', height:200});
    </script>

</body>



</html>
