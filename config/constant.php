<?php

return[

    'default' => [
        'favicon'   => 'default/favicon.png',
        'no_image'  => 'default/no-image.jpg',
        'user_icon' => 'default/user-icon.svg',
    ],

    'roles' =>[
        'admin'   => 1,
        'staff'   => 2,
        'customer' => 3,
    ],

    'profile_max_size' => 2048,
    'profile_max_size_in_mb' => '2MB',
];
?>