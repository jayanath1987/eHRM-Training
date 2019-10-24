<?php
    $address=$sf_data->getRaw('off_address');
    echo json_encode(array("fullName"=>$fullName,"workstaion"=>$workstaion,"nic"=>$nic,"job_tit"=>$jobTitle,"address"=>$address,"offphone"=>$off_phone,"mobile"=>$mobile,"resphone"=>$resphone,"fax"=>$fax));

    

?>