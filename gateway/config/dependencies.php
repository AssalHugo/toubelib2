<?php

return [

    //On définit la dépendance guzzle
    'guzzle' => function() {
        return new \GuzzleHttp\Client(
            [
                'base_uri' => 'http://localhost:6080',
            ]
        );
    },
];