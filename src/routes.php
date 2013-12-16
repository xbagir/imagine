<?php

//PresetController
Route::get('preset-stored/{preset}/{token}/{id}.{ext}', array(
    'as'   => 'presetStored',
    'uses' => 'Xbagir\Imagine\Controllers\PresetController@makeStoredImage'
));

Route::get('preset-uploaded/{preset}/{token}/{id}.{ext}', array(
    'as'   => 'presetUploaded',
    'uses' => 'Xbagir\Imagine\Controllers\PresetController@makeUploadedImage'
));