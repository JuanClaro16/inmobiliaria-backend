<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // IMPORTANTE: con credenciales NO puedes usar * (comodín).
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],

    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],

    // Esto hace que el servidor devuelva Access-Control-Allow-Credentials: true
    'supports_credentials' => true,
];
