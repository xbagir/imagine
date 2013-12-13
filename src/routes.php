<?php

//PresetController
Route::get('preset-stored/{preset}/{token}/{id}.{ext}', array(
    'as'   => 'presetStored',
    'uses' => 'Xbagir\Imagine\Controllers\PresetController@makeStoredImage'
))
->where('id', '[0-9]+');

Route::get('preset-uploaded/{preset}/{token}/{id}.{ext}', array(
    'as'   => 'presetUploaded',
    'uses' => 'Xbagir\Imagine\Controllers\PresetController@makeUploadedImage'
))
->where('id', '[0-9]+');

Route::get('preset/{id}.{ext}', array(
    'as'   => 'presetTest',
    'uses' => 'Xbagir\Imagine\Controllers\PresetController@makeTestImage'
));