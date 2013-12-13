<?php namespace Xbagir\Imagine;

class Factory
{
    protected $class;
    
    public function __construct($config)
    {
        $this->class   = '\\Imagine\\'.ucfirst(strtolower($config['driver'])).'\\Imagine';
        $this->preset  = new Preset($this, $config['presets']);
    }

    public function make()
    {
        return new $this->class;
    }

    public function getPreset()
    {
        return $this->preset;
    }
}