<?php

try {
    require_once __DIR__ . '/Config/config.php';
    require_once __DIR__ . '/_scripts/maciej2.php';

    $admin_rec = DAdminRecord::finder()->findByAdminId(1);
    print_r($admin_rec);
} catch (Exception $e) {
    echo $e;
}
	
