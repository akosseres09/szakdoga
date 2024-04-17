<?php
$params =  [
    'adminEmail' => 'admin@sportify.com',
    'supportEmail' => 'support@sportify.com',
    'senderEmail' => 'noreply@sportify.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 6,
];

if (YII_ENV_DEV) {
    $params['frontendUrl'] = 'https://sportify.test';
    $params['frontendImagesUrl'] = 'https://sportify.test/storage/images/';
}

return $params;