<?php
return [
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'username'   => $_ENV['EMAIL_USER'],
    'password'   => $_ENV['EMAIL_PASS'],
    'from_email' => $_ENV['EMAIL_USER'],
    'from_name'  => $_ENV['FROM_NAME']
];