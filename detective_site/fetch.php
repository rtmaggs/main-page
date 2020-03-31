<?php
include __DIR__ . '/model/model_police.php';

$caseDetails = getCasesWithDetails();
echo json_encode($caseDetails);