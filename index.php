<?php

try {
    require_once __DIR__ . '/Config/config.php';
    require_once __DIR__ . '/_scripts/maciej2.php';
    echo "<html>";
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    $user = DUser::finder()->findOne();
    print_r($user);
//
//    $admin_rec = DAdminRecord::finder()->findByPK(1);
//    print_r($admin_rec);
//
//    $admin_rec2 = DAdminRecord::finder()->findByAdminId(1);
//    print_r($admin_rec2);
//
//    $admin_rec3 = DAdminRecord::finder()->findByAdminIds(array(1,2));
//    print_r($admin_rec3);
//    
//      $admin_rec4 = DAdminRecord::finder()->findOneByAdminId(1);
//      $events = $admin_rec4->getEvents();
//      print_r(count($events));
//
//    $participant = DParticipantRecord::finder()->findByPK(11);
////    print_r($participant);
//    $participant_classifications = $participant->getClassifications();
////    print_r($participant_classifications);
//    foreach($participant_classifications as $pc) {
//        print_r($pc);
////        print_r($pc->getRelationship());
//    }
} catch (Exception $e) {
    echo $e;
}
	
