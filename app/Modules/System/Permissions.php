<?php
return [
    [
        'name' => __('Staff'),
        'description' => __('Staff Permissions'),
        'permissions' => [
            'view-all-staff'    =>['system.staff.index'],
            'view-one-staff'    =>['system.staff.show'],
            'create-staff'      =>['system.staff.create','system.staff.store'],
            'update-staff'      =>['system.staff.edit','system.staff.update']
        ]
    ],

    [
        'name' => __('Permission Group'),
        'description' => __('Permission Group Permissions'),
        'permissions' => [
            'view-all-permission-group'    =>['system.permission-group.index'],
            'view-one-permission-group'    =>['system.permission-group.show'],
            'create-permission-group'      =>['system.permission-group.create','system.permission-group.store'],
            'update-permission-group'      =>['system.permission-group.edit','system.permission-group.update']
        ]
    ],

    [
        'name' => __('Setting'),
        'description' => __('Setting Permissions'),
        'permissions' => [
            'manage-setting'    =>['system.setting.index','system.setting.update']
        ]
    ],


    [
        'name' => __('Activity Log'),
        'description' => __('Activity Log'),
        'permissions' => [
            'view-activity-log'=>['system.activity-log.index'],
            'view-one-activity-log'=>['system.activity-log.show'],
        ]
    ],

    [
        'name' => __('Sensors'),
        'description' => __('Sensors'),
        'permissions' => [
            'view-all-sensors'=>['system.sensor.index','sensor.update-status','sensor.update-location','system.sensorChart','system.sensor.show'],
            'view-create-sensor'=>['system.sensor.create','system.sensor.store'],
            'view-update-sensor'=>['system.sensor.edit','system.sensor.update'],
            'view-delete-sensor'=>['system.sensor.destroy'],
        ]
    ],
    [
        'name' => __('Rules Notifications'),
        'description' => __('Rules Notifications'),
        'permissions' => [
            'view-all-rules-notifications'=>['system.rules-notifications.index'],
            'view-create-rules-notifications'=>['system.rules-notifications.create','system.rules-notifications.store'],
            'view-update-rules-notifications'=>['system.rules-notifications.edit','system.rules-notifications.update'],
            'view-delete-rules-notifications'=>['system.rules-notifications.destroy'],
        ]
    ],
    [
        'name' => __('Automatic Reports'),
        'description' => __('Automatic Reports'),
        'permissions' => [
            'view-all-automatic-reports'=>['system.automatic-reports.index','automatic-reports.update-status','system.rules-notifications.send-report','system.automatic-reports.copy'],
            'view-create-automatic-reports'=>['system.automatic-reports.create','system.automatic-reports.store'],
            'view-update-automatic-reports'=>['system.automatic-reports.edit','system.automatic-reports.update'],
            'view-delete-automatic-reports'=>['system.automatic-reports.destroy'],
        ]
    ],
    [
        'name' => __('Alarms'),
        'description' => __('Alarms'),
        'permissions' => [
            'view-all-alarms'=>['system.alarm.index','sensor.alarm.confirm','system.alarm-list-send','system.alarm.show'],
        ]
    ],
    [
        'name' => __('Map View'),
        'description' => __('Map View'),
        'permissions' => [
            'view-add-and-edit-map-view'=>['system.index','system.addMapView','system.addSensorToMapView','system.updateSensor','system.deleteSensor','system.deleteMapView'],
        ]
    ],
//    [
//        'name' => __('subdomains'),
//        'description' => __('subdomains'),
//        'permissions' => [
//            'view-all-subdomains'=>['system.subdomains.index','system.create-subdomain','system.store-subdomain','system.destroy-subdomain'],
//        ]
//    ],

//    [
//        'name' => __('Cars'),
//        'description' => __('Cars'),
//        'permissions' => [
//            'view-and-create-cars'=>['system.car.index','system.car.create','system.car.store','system.car.edit','system.car.update','system.car.destroy'],
//        ]
//    ],[
//        'name' => __('Drivers'),
//        'description' => __('Drivers'),
//        'permissions' => [
//            'view-and-create-drivers'=>['system.driver.index','system.driver.create','system.driver.store','system.driver.edit','system.driver.update','system.driver.destroy'],
//        ]
//    ],
//
//    [
//        'name' => __('Apps'),
//        'description' => __('Apps'),
//        'permissions' => [
//            'view-and-create-apps'=>['system.app.index','system.app.create','system.app.store','system.app.edit','system.app.update','system.app.destroy'],
//        ]
//    ],

];
