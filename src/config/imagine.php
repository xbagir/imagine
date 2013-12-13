<?php

return array(
    'driver'  => 'GD',
    'presets' => array(
        'auto' => array(
            'uploaded'    => array(
                'size'    =>  array(178, 112),
                'quality' =>  100,
                'ext'     => 'jpg',
                'route'   => 'presetUploaded'
            ),
            'recommendation'  => array(
                'size'    =>  array(224, 141),
                'quality' =>  100,
                'ext'     => 'jpg',
                'route'   => 'presetStored'
            ),
            'medium' => array(
                'size'    => array(460, 290),
                'quality' => 100,
                'ext'     => 'jpg',
                'route'   => 'presetStored'
            ),
            'large'  => array(
                'size'    => array(600, 600),
                'quality' => 100,
                'ext'     => 'jpg',
                'route'   => 'presetStored'
            )
        )
    )
);