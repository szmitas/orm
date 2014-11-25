<?php

try {
    require_once __DIR__ . '/Config/config.php';
    require_once __DIR__ . '/_scripts/maciej2.php';

//    $admin_rec = DAdminRecord::finder()->findByPK(1);
//    print_r($admin_rec);
//
//    $admin_rec2 = DAdminRecord::finder()->findByAdminId(1);
//    print_r($admin_rec2);

    $admin_rec3 = DAdminRecord::finder()->findByAdminIds(array(1,2));
    print_r($admin_rec3);
} catch (Exception $e) {
    echo $e;
}
	
