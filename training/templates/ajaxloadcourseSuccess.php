<?php

$arr = Array();


foreach ($courslist as $row) {
    $n = "td_course_name_" . $culture;
    if ($row[$n] == null) {
        $n = "td_course_name_en";
    } else {
        $n = "td_course_name_" . $culture;
    }
    $arr[$row['td_course_id']] = $row[$n];
}


echo json_encode($arr);
?>