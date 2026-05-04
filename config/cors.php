<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],

    'allowed_origins' => ['http://localhost:5174'],

    'allowed_headers' => ['*'],

];
