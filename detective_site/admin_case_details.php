<?php
session_start();
if(!isset($_SESSION['admin_login'])){
    header('Location: login.php');
}
include __DIR__ . '/model/model_police.php';
include __DIR__ . '/model/functions.php';

$viewColumns = grabColumns();

if(isset($_SESSION['user_id'])){
    $employee_id = $_SESSION['user_id'];
}
if(isset($_GET['case_id'])){
    $case_id = filter_input(INPUT_GET, 'case_id');
}
if(isset($employee_id)){
    $messages = getMessagesForLoggedIn($employee_id);
}

$casesWithDetails = getCasesWithDetails();
$selectedCase = filter_input(INPUT_GET, 'case_id');

$getWitnesses = listWitnesses();
$getSuspects = getSuspects();
$getEvidence = getEvidence();
$getCases = getCases();
$employees = getEmployees();

$assignedOfficers = array();
$caseWitnesses = array();
$caseSuspects = array();
$caseEvidence = array();

if(isset($selectedCase)){
    foreach($casesWithDetails as $row){
        if($row["case_id"] == $selectedCase && isset($row["case_description"])){
            $caseDescription = $row["case_description"];
        } else {
            $caseDescription = "There is currently no description for this case.";
        }

        if($row["case_id"] == $selectedCase && preg_match("/[a-z]/i", $row["employee_first"])){
            $assignedOfficers += [$row["employee_id"] => $row["employee_first"]." ".$row["employee_last"]];
        }

        if($row["case_id"] == $selectedCase && preg_match("/[a-z]/i", $row["witness_first"])){
            $caseWitnesses += [$row["witness_id"] => $row["witness_first"]." ".$row["witness_last"]];
        }

        if($row["case_id"] == $selectedCase && preg_match("/[a-z]/i", $row["suspect_first"])){
           $caseSuspects += [$row["suspect_id"] => $row["suspect_first"]." ".$row["suspect_last"]];
        }

        if($row["case_id"] == $selectedCase && preg_match("/[a-z]/i", $row["evidence_title"])){
            $caseEvidence += [$row["evidence_id"] => $row["evidence_title"]];
         }
    }
} else {
    $caseDescription = "No case selected.";
    $assignedOfficers[0] = "No case selected.";
    $caseWitnesses[0] = "No case selected.";
    $caseSuspects[0] = "No case selected.";
    $caseEvidence[0] = "No case selected.";
}

if(!isset($assignedOfficers) || $assignedOfficers == NULL){
    array_push($assignedOfficers, "No officers currently assigned to this case.");
}

if(!isset($caseWitnesses) || $caseWitnesses == NULL){
    array_push($caseWitnesses, "No witnesses currently assigned to this case.");
}

if(!isset($caseSuspects) || $caseSuspects == NULL){
    array_push($caseSuspects, "No suspects currently assigned to this case.");
}

if(!isset($caseEvidence) || $caseEvidence == NULL){
    array_push($caseEvidence, "No evidence currently assigned to this case.");
}

$action = filter_input(INPUT_GET, 'action');
$column = filter_input(INPUT_GET, 'column');
$search = filter_input(INPUT_GET, 'search');
$sort = filter_input(INPUT_GET, 'sort');

if ($action === 'search')
{
    $casesWithDetails = searchCases($column, $search);
}

if ($action === 'sort')
{
    $casesWithDetails = sortCases($column, $sort);

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
</head>
<body>

    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
            <div class="black-box-2">
                <form class="search-form" method="GET" action="#">
                    <input type="hidden" name="action" value="search" >
                    <div class="form-group">
                        <label for="select" class="control-label">Search By:</label>
                        <select style="width:30%;min-width:120px;" class="form-control" id="select" name="column">
                            <?php foreach ($viewColumns as $row):?>
                                <option value="<?php echo $row;?>"><?php echo $row;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="search" class="control-label">Match:</label>
                        <input style="width:70%;" class="form-control" type="text" id="search" name="search" placeholder="Enter text to search for..." >
                    </div>
                    <button class="submit-button btn-primary" type="submit">Search</button>
                </form>

                <form class="search-form" method="GET" action="#">
                    <input type="hidden" name="action" value="sort">
                    <div class="form-group">
                    <label class="control-label">Sort By:</label>
                        <select style="width:30%;min-width:120px;" class="form-control" name="column">
                            <?php foreach ($viewColumns as $row):?>
                                <option value="<?php echo $row;?>"><?php echo $row;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <input class="custon-control-label" type="radio" name="sort" value="ASC" /> ASC
                    <input class="custon-control-label" type="radio" name="sort" value="DESC" /> DESC
                    <br>
                    <button class="submit-button btn-primary" type="submit">Sort</button>
                </form>
            </div>

            <article>

                <div class="box-container">
                    <div class="tab"><h2><span class="triangle">&#9660;</span>Table</Table></h2></div>
                    <div class="black-box-messages">
                        <table class="table table-dark col table-style cases-table">  
                            <thead>
                                <tr>
                                    <th scope="col">Case ID</th>
                                    <th scope="col">Case Title</th>
                                    <th scope="col"><a href="edit/editCases.php?action=Add">Add A Case</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($casesWithDetails as $row) : ?>
                                <tr>
                                    <td><?php echo $row["case_id"]; ?></td>
                                    <td><a href="admin_case_details.php?case_id=<?php echo $row["case_id"]; if(isset($_GET["message_id"])){ echo "&message_id=".$_GET["message_id"]; } ?>"; ?><?php echo $row["case_title"]; ?></a></td>
                                    <td><a href="edit/editCases.php?action=Update&case_id=<?php echo $row['case_id']; ?>">Edit</a> | <a href="delete.php?id=<?php echo $row['case_id']; ?>&from=Cases">Delete</a></td>
                                </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-container">
                    <div class="tab"><h2><span class="triangle">&#9660;</span>Description</h2></div>
                    <div class="black-box-wide-2">

                        <p><?php echo $caseDescription ?></p>
                    </div>
                </div>

                <div class="box-container">
                    <div class="tab"><h2><span class="triangle">&#9660;</span>Details</h2></div>
                    <div class="black-box-wide-2 module">
                        <div class="black-box-slim">
                        <h4>Officers

                            <?php if(isset($selectedCase)) : ?>
                                <?php echo "<a class=\"add-button\" href=\"edit/editEmployeesFromCases.php?action=Add&case_id=".filter_input(INPUT_GET, 'case_id')."\"><img src=\"images/plus.svg\" alt=\"\" style=\"display:inline;float:right;width:1em;height:1em;margin-top:7px;\"></a>"; ?>
                            <?php endif; ?>

                        </h4>
                            <?php foreach($assignedOfficers as $id => $officer) : ?>
                                <?php if($officer != "No officers currently assigned to this case." && $officer != "No case selected.") : ?>
                                    <?php echo "<span class=\"inactive-link"."\""." data-id=\""."employee-".$id."\">".$officer."</span><br>"; ?>
                                <?php else : ?>

                                    <?php echo $officer ?>

                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                        <div class="black-box-slim">
                        
                        <h4>Witnesses   
                            <?php if(isset($selectedCase)) : ?>
                                <?php echo "<a class=\"add-button\" href=\"edit/editWitnesses.php?action=Add&case_id=".filter_input(INPUT_GET, 'case_id')."\"><img src=\"images/plus.svg\" alt=\"\" style=\"display:inline;float:right;width:1em;height:1em;margin-top:7px;margin-left:1px;\"></a>"; ?>
                            <?php endif; ?>
                        </h4>
                        <?php foreach ($getWitnesses as $row): ?>
                            <form action="#" method="post"> </form>
                        <?php endforeach; ?>                    
                        <?php foreach($caseWitnesses as $id => $witness) : ?>
                            <?php if($witness != "No witnesses currently assigned to this case." && $witness != "No case selected.") : ?>
                                <?php echo "<span class=\"inactive-link"."\""." data-id=\""."witness-".$id."\">".$witness."</span>"; ?>
                            
                            <?php else : ?>

                                <?php echo $witness ?>

                            <?php endif; ?>
                        <?php endforeach; ?><br>                       
                        </div>
                        <div class="black-box-slim">
                        
                        <h4>Suspects 
                            <?php if(isset($selectedCase)) : ?>
                                <?php echo "<a class=\"add-button\" href=\"edit/editSuspects.php?action=Add&case_id=".filter_input(INPUT_GET, 'case_id')."\"><img src=\"images/plus.svg\" alt=\"\" style=\"display:inline;float:right;width:1em;height:1em;margin-top:7px;\"></a>"; ?>
                            <?php endif; ?>
                        </h4>
                        <?php foreach ($getSuspects as $row): ?>
                            <form action="#" method="post"> </form>
                        <?php endforeach; ?>  
                        <?php foreach($caseSuspects as $id => $suspect) : ?>
                            <?php if($suspect != "No suspects currently assigned to this case." && $witness != "No case selected.") : ?>
                                <?php echo "<span class=\"inactive-link"."\""." data-id=\""."suspect-".$id."\">".$suspect."</span>"; ?>
                            
                            <?php else : ?>

                                <?php echo $suspect ?>

                            <?php endif; ?>
                        <?php endforeach; ?><br>  
                        </div>
                        <div class="black-box-slim">
                        
                        <h4>Evidence 
                            <?php if(isset($selectedCase)) : ?>
                                <?php echo "<a class=\"add-button\" href=\"edit/editEvidence.php?action=Add&case_id=".filter_input(INPUT_GET, 'case_id')."\"><img src=\"images/plus.svg\" alt=\"\" style=\"display:inline;float:right;width:1em;height:1em;margin-top:7px;\"></a>"; ?>
							<?php endif; ?>
                        </h4>
                        <?php foreach ($getEvidence as $row): ?>
                            <form action="#" method="post"> </form>
                        <?php endforeach; ?>  
                        <?php foreach($caseEvidence as $id => $evidence) : ?>
                            <?php if($evidence != "No evidence currently assigned to this case." && $evidence != "No case selected.") : ?>
                                <?php echo "<span class=\"inactive-link"."\""." data-id=\""."evidence-".$id."\">".$evidence."</span>"; ?>
                            
                            <?php else : ?>

                                <?php echo $evidence ?>

                            <?php endif; ?>
                        <?php endforeach; ?><br>    
                        </div>
                    </div>
                </div>

                <div class="box-container">
                    <div class="tab"><h2><span class="triangle">&#9660;</span>Message</h2></div>
                    <div class="black-box-wide-2" style="justify-content:left;padding:35px;">
                    <p>
                    <?php if(isset($_GET["message_id"])): ?>
                        <?php foreach($messages as $message): ?>
                            <?php if($message["message_id"] == $_GET["message_id"]): ?>
                                <?php echo $message["content"]; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php echo "No messages selected."; ?>
                    <?php endif; ?>
                    <span style="visibility:hidden;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris condimentum, dolor a venenatis facilisis, est libero viverra velit, ut luctus massa sem nec mauris. Sed mauris lectus, dapibus non enim eu, congue convallis turpis. Proin sit amet sem lacus. Ut interdum sem libero, a aliquet lectus porttitor nec. Nam ante elit, interdum eu nibh lobortis, feugiat molestie erat. Suspendisse placerat aliquet eros, et imperdiet justo. Nulla id felis pretium, eleifend nulla commodo, dictum turpis. Sed pellentesque tortor ut malesuada semper. Curabitur nec tellus eu eros fermentum rutrum.</span>
                    </p>

                    </div>
                </div>

            </article>

            <div class="black-box">
                <h2>Messages</h2>
                <div class="black-box-employees">
                
                        
                    <?php if(isset($employee_id)): ?>
                        <table class="table table-dark table-style">
                            <thead>
                                <tr>
                                    <th scope="col">Sender</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($messages as $message): ?>
                                    <tr>
                                <td><a href="admin_case_details.php?<?php if(isset($case_id)){echo "case_id=".$case_id."&";} ?>message_id=<?php echo $message["message_id"]; ?>"><?php foreach($employees as $employee): ?><?php if($employee["employee_id"] == $message["sender"]): ?><?php echo $employee["firstname"]." ".$employee["lastname"]; ?><?php endif; ?><?php endforeach; ?></a></td>
                                        <td><?php echo $message["time_sent"]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <?php echo "Log in to view your messages..."; ?>
                    <?php endif; ?>
                        
                </div>
            </div>

            <div class="pop-up"><div class="close-button"></div><div class="content"></div></div>

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
        $('.pop-up').hide();
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

        $('.close-button').click(function(e){
            $(this).parent().hide(500);
        });


        $('.inactive-link').click(async function makeRequest() {
            const url = 'fetch.php';
            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                console.log(response);
                var allCaseDetails = await response.json();
                console.log(allCaseDetails);

            } catch (error) {
				console.error(error);
			}
            $('.pop-up').show(500);

            var str = "";
            for(var i in allCaseDetails){       
                
                if("employee-" + allCaseDetails[i]["employee_id"] == $(this).attr('data-id')){
                    str += "<p><h2>";
                    str += allCaseDetails[i]["employee_first"];
                    str += " ";
                    str += allCaseDetails[i]["employee_last"];
                    str += "</h2></p>";
                    str += "<p>";
                    str += "Job Title: ";
                    str += allCaseDetails[i]["job_title"];
                    str += "</p>";
                    str += "<p>";
                    str += "Email: ";
                    str += allCaseDetails[i]["email"];
                    str += "</p>";
                    str += "<p>";
                    str += "Phone: ";
                    str += allCaseDetails[i]["employee_phone"];
                    str += "</p>";
                    str += "<a href=\"edit/editEmployeesFromCases.php?action=Update&employee_id=" + allCaseDetails[i]["employee_id"] + "\">Edit</a>"
                    str += "<span> | </span>";
                    str += "<a href=\"delete.php?id=" + allCaseDetails[i]["employee_id"] + "&from=Employees\">Delete</a>";
                }

                if("witness-" + allCaseDetails[i]["witness_id"] == $(this).attr('data-id')){
                    str += "<h2>";
                    str += allCaseDetails[i]["witness_first"];
                    str += " ";
                    str += allCaseDetails[i]["witness_last"];
                    str += "</h2>";
                    str += "<p>";
                    str += "Phone: ";
                    str += allCaseDetails[i]["witness_phone"];
                    str += "</p>";
                    str += "<p>";
                    str += "<h3>Statement</h3>";
                    str += "<p>"
                    str += allCaseDetails[i]["witness_statement"];
                    str += "</p>";
                    str += "<a href=\"edit/editWitnesses.php?action=Update&witness_id=" + allCaseDetails[i]["witness_id"] + "\">Edit</a>";
                    str += "<span> | </span>";
                    str += "<a href=\"delete.php?id=" + allCaseDetails[i]["witness_id"] + "&from=Witnesses\">Delete</a>";
                }

                if("suspect-" + allCaseDetails[i]["suspect_id"] == $(this).attr('data-id')){
                    str += "<h2>";
                    str += allCaseDetails[i]["suspect_first"];
                    str += " ";
                    str += allCaseDetails[i]["suspect_last"];
                    str += "</h2>";
                    str += "<p>";
                    str += "Address: ";
                    str += allCaseDetails[i]["suspect_address"];
                    str += "</p>";
                    str += "<p>";
                    str += "Date of Birth: ";
                    str += allCaseDetails[i]["suspect_dob"];
                    str += "</p>";
                    str += "<p>";
                    str += "Eye Color: ";
                    str += allCaseDetails[i]["eye_color"];
                    str += "</p>";
                    str += "Height: ";
                    str += allCaseDetails[i]["height"];
                    str += "</p>";
                    str += "Weight: ";
                    str += allCaseDetails[i]["weight"];
                    str += "</p>";
                    str += "</p>";
                    str += "Wanted Level: ";
                    str += allCaseDetails[i]["wanted_level"];
                    str += "</p>";
                    str += "</p>";
                    str += "Arrest Time: ";
                    if(allCaseDetails[i]["arrest_time"] == undefined){
                        str += "No arrests made.";
                    } else {
                        str += allCaseDetails[i]["arrest_time"];
                    }
                    str += "</p>";
                    str += "<a href=\"edit/editSuspects.php?action=Update&suspect_id=" + allCaseDetails[i]["suspect_id"] + "\">Edit</a>";
                    str += "<span> | </span>";
                    str += "<a href=\"delete.php?id=" + allCaseDetails[i]["suspect_id"] + "&from=Witnesses\">Delete</a>";
                }
 
                if("evidence-" + allCaseDetails[i]["evidence_id"] == $(this).attr('data-id')){
                    str += "<h2>";
                    str += allCaseDetails[i]["evidence_title"];
                    str += "</h2>";
                    str += allCaseDetails[i]["evidence"];
                    str += "<a href=\"edit/editEvidence.php?action=Update&evidence_id=" + allCaseDetails[i]["evidence_id"] + "\">Edit</a>"
                    str += "<span> | </span>"
                    str += "<a href=\"delete.php?id=" + allCaseDetails[i]["evidence_id"] + "&from=Evidence\">Delete</a>";
                    str += "<a href=\"delete.php?id=" + allCaseDetails[i]["suspect_id"] + "&from=Witnesses\">Delete</a>";
                }

            }
            console.log(str);
            $('.content').html(str);
        });


        
    </script>

</body>



</html>
