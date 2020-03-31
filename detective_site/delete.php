<?php
include __DIR__ . '/model/model_police.php';

$id = filter_input(INPUT_GET, 'id');
$from = filter_input(INPUT_GET, 'from');

if($from == "Cases"){
    $result = deleteCase($id);
    header('Location: admin_case_details.php');
    echo $result;
}
if($from == "Employees"){
    $result = deleteEmployee($id);
    header('Location: admin_case_details.php');
    echo $result;
}
if($from == "Employees2"){
    $result = deleteEmployee($id);
    header('Location: admin_employee.php');
    echo $result;
}
if($from == "Witnesses"){
    $result = deleteWitness($id);
    header('Location: admin_case_details.php');
    echo $result;
}
if($from == "Suspects"){
    $result = deleteSuspect($id);
    header('Location: admin_case_details.php');
    echo $result;
}
if($from == "Evidence"){
    $result = deleteEvidence($id);
    header('Location: admin_case_details.php');
    echo $result;
}
if($from == "Announcements"){
    $result = deleteAnnouncement($id);
    header('Location: admin_announcements.php');
    echo $result;
}

?>