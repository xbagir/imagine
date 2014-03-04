<?php

namespace Xbagir\Imagine\Controllers;

use Imagine;
use Response;

class PresetController extends \Controller
{
    protected $imageService;
    protected $preset;
    
    public function __construct(\ImageService $ImageService)
    {
        $this->imageService = $ImageService;  
        $this->preset       = Imagine::getPreset();
    }    
    
    public function makeStoredImage($preset, $token, $id, $ext)
    {
        $realPath = null;
        
        if ( ! $this->preset->validUrlSegments($token, $preset, $id, $ext))
        {
            return Response::make('Image not valid', 404);
        }
                
        if ( $image = $this->imageService->getById($id) )
        {
            $realPath = $image->realPath;
        }                    
        
        $content = $this->preset->getContent($realPath, $preset);              
               
        return \Response::make($content, 200, array(
            'Content-Type'  => $ext,
            //'Expires'     => \Carbon\Carbon::now()->addDay()->toRFC1123String()
        ));

    }

    public function makeUploadedImage($preset, $token, $id, $ext)
    {
        if ( ! $this->preset->validUrlSegments($token, $preset, $id, $ext))
        {
            return Response::make('Image not valid', 404);
        }

        if ( ! $image = $this->imageService->getUploadedById($id))
        {
            return Response::make('Image not found', 404);    
        }

        $content = $this->preset->getContent($image->realPath, $preset);

        return \Response::make($content, 200, array(
            'Content-Type'  => $ext,
        ));
    }
    
}
