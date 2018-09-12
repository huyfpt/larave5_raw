<?php

return [
    'secret' => env('NOCAPTCHA_SECRET', '6LcNmm8UAAAAAGQQoRUfuytbckkGs26VRpPYKH__'),
    'sitekey' => env('NOCAPTCHA_SITEKEY', '6LcNmm8UAAAAAOYCh1NgUjLqBzQaPwn6ZE8cEO09'),
    'options' => [
        'timeout' => 30,
    ],
];
