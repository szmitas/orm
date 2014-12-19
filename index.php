<?php

use Repel\Config;

try {
    require_once 'autoloader.php';

    require_once __DIR__ . '/maciej2.php';
//    $user = DUser::finder()->findOne();
//    print_r($user);
//
//    $admin_rec = DAdmin::finder()->findByPK(1);
//    print_r($admin_rec);
//    $admin_rec = DAdmin::finder()->findByPKs(array(1, 2));
//    print_r($admin_rec);
//    $admin_rec = DAdmin::finder()->findOne("login = :login", array(":login" => "szmitas"));
//    print_r($admin_rec);
//    $admin_rec = DAdmin::finder()->findByLogin(array("szmitas", "radek"));
//    print_r($admin_rec);
        $admin_rec = DAdmin::finder()->findByLogin("adam");
    print_r($admin_rec);
    $admin_rec->email = "zmiana2";
    $admin_rec->save();
        $admin_rec2 = DAdmin::finder()->findByLogin("adam");
        print_r($admin_rec2);
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
	
