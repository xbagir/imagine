<?php

namespace Xbagir\Imagine\Controllers;

use Imagine;
use Response;

class PresetController extends \Controller
{
    protected $imageService;
    
    public function __construct(\ImageService $ImageService)
    {
        $this->imageService = $ImageService;    
    }    
    
    public function makeStoredImage($preset, $token, $id, $ext)
    {
        if ( ! $image = \PostImage::find($id) )
        {
            return Response::make('Image not found', 404);
        }    
              
        return Imagine::getPreset()->makeResponse($image, $preset, $token, $ext);
    }

    public function makeUploadedImage($preset, $token, $id, $ext)
    {
        if ( ! $image = $this->imageService->getUploadedImage($id))
        {
            return Response::make('Image not found', 404);    
        }    
                    
        return Imagine::getPreset()->makeResponse($image, $preset, $token, $ext);
    }
    
}
