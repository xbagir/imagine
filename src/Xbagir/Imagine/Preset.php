<?php namespace Xbagir\Imagine;

use Imagine\Image\Box;
use Imagine\Image\Palette\RGB;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Whoops\Example\Exception;

class Preset
{   
    protected $config;
    protected $imagine;
    
    public function __construct($imagine, $config)
    {       
        $this->imagine = $imagine; 
        $this->config  = $config;
    }

    public function makeUrl($id = 0, $preset)
    {
        $config = $this->getPresetConfig($preset);
        
        return route($config['route'], array(
            'preset' => $this->presetEncode($preset), 
            'token'  => $this->makeToken($preset, $id, $config['ext']), 
            'id'     => $id,
            'ext'    => $config['ext']
        ));
    }
   
    public function validUrlSegments($token, $preset, $id, $ext)
    {
        $preset = $this->presetDecode($preset);
                
        if ( $token !== $this->makeToken($preset, $id, $ext) )
        {
            return false;
        }
        
        return true;
    }

    public function getContent($realPath, $preset)
    { 
        $config   = $this->getPresetConfig($this->presetDecode($preset));
        $realPath = is_file($realPath) ? $realPath : $config['dummy'];
                        
        return $this->makeContent($realPath, $config);
    }
    
    protected function makeContent($file, $config)
    {        
        $box        = new Box($config['size'][0], $config['size'][1]);
        $background = $this->imagine->make()->create($box, (new RGB())->color('#ffffff', 100));
        
        $image = $this->imagine->make()->open($file)->thumbnail($box, ImageInterface::THUMBNAIL_OUTBOUND);
        
        $x = abs(round(($box->getWidth() - $image->getSize()->getWidth()) / 2));
        $y = abs(round(($box->getHeight() - $image->getSize()->getHeight()) / 2));
                      
        return $background->paste($image, new Point($x, $y))->get($config['ext'], array('quality' => $config['quality']));
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
        
    protected function getPresetConfig($preset)
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
