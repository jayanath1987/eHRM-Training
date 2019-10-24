<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$arr = Array();

foreach ($empidList as $list) {
    $arr[] = $list['emp_number'];
}


echo json_encode($arr);
?>
