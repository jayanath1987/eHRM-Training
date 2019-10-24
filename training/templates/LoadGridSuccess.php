<?php

$arr = Array();

$secDao = new securityDao();

foreach ($emplist as $row) {


    if ($culture == "en") {
        $abc = "emp_display_name";
    } else {
        $abc = "emp_display_name_" . $culture;

        if ($row[$abc] == "") {

            $abc = 'emp_display_name';
        } else {
            $abc = "emp_display_name_" . $culture;
        }
    }
    if ($culture == "en") {
        $title = "title";
    } else {

        $title = "title_" . $culture;
    }
    $comStruture = $secDao->getCompnayStructure($row['work_station']);
    if ($culture == "en") {
        $title = "getTitle";
    } else {
        $title = "getTitle_" . $culture;
    }
    if ($comStruture) {
        $comTitle = $comStruture->$title();
    }
    $arr[$row['employeeId']] = $row['employeeId'] . "|" . $row[$abc] . "|" . $comTitle . "|" . $row['empNumber'];
}



echo json_encode($arr);
?>