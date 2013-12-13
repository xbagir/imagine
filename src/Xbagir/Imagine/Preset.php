<?php namespace Xbagir\Imagine;

use Imagine\Image\Box;
use Imagine\Image\Palette\RGB;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class Preset
{   
    protected $config;
    protected $imagine;
    
    public function __construct($imagine, $config)
    {       
        $this->imagine = $imagine; 
        $this->config  = $config;
    }

    public function makeUrl($id, $preset)
    {
        $config = $this->presetConfig($preset);
        $token  = $this->makeToken($id, $preset, $config['ext']);
        
        return route($config['route'], array(
            'preset' => $this->presetEncode($preset), 
            'token'  => $token, 
            'id'     => $id,
            'ext'    => $config['ext']
        ));
    }
   
    public function makeResponse($image, $preset, $token, $ext)
    {
        $preset = $this->presetDecode($preset);
        $config = $this->presetConfig($preset);
                         
        if ( $token !== $this->makeToken($image->id, $preset, $ext) )
        {
            throw new \InvalidArgumentException("Invalid token: $token");    
        }
        
        return \Response::make($this->makeContent($image->realPath, $config), 200, array(
            'Content-Type' => 'image/'.$config['ext'],
            'Expires'      => \Carbon\Carbon::now()->addDay()->toRFC1123String()
        ));      
    }

    protected function makeContent($file, $config)
    {        
        $box   = new Box($config['size'][0], $config['size'][1]);
        $image = $this->imagine->make()->open($file)->thumbnail($box, ImageInterface::THUMBNAIL_OUTBOUND);
        
        return  $image->get($config['ext'], array('quality' => $config['quality']));
    }
    
    /*protected function makeContent($file, $config)
    {        
        $box        = new Box($config['size'][0], $config['size'][1]);
        $background = $this->imagine->make()->create($box, (new RGB())->color('#ffffff', 100));

        $image      = $this->imagine->make()->open($file)->thumbnail($box, ImageInterface::THUMBNAIL_INSET);

        $width      = round(($box->getWidth() - $image->getSize()->getWidth()) / 2);
        $height     = round(($box->getHeight() - $image->getSize()->getHeight()) / 2);

        $content    = $background->paste($image, new Point($width, $height))->get($config['ext'], array('quality' => $config['quality']));      
        
        return  $content;
    }*/
        
    protected function presetConfig($preset)
    {
        if ( ! $config = array_get($this->config, $preset) )
        {
            throw new \InvalidArgumentException(strtr('Preset :preset is not defined in the config', array(
                ':preset' => $preset
            )));
        }
        
        return $config;
    }
    
    protected function makeToken($preset, $id, $ext)
    {
        return sprintf("%u", crc32(app()['config']['app.key'].$preset.$id.$ext));    
    }
    
    protected function presetEncode($preset)
    {
        return str_replace('.', '-', $preset);    
    }

    protected function presetDecode($preset)
    {
        return str_replace('-', '.', $preset);
    }
}
