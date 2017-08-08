<?php

namespace System\Libraries\View;

class View extends File
{

    /** @var string */
    protected $dir = '.';

    /** @var string */
    protected $fileExt = '.php';

    public function __construct()
    {
        $this->file = 'php://temp';
        $this->data = [];
    }

    private function getViewPath($file)
    {
        return preg_replace('#[\\\/]#', DIRECTORY_SEPARATOR, "{$this->dir}/{$file}{$this->fileExt}");
    }

    /**
     * 
     * @param string $directory
     * @return $this
     */
    public function setTemplateDir($directory)
    {
        $this->dir = $directory;
        return $this;
    }

    /**
     * 
     * @param string $extension
     * @return $this
     */
    public function setFileExtension($extension)
    {
        $this->fileExt = $extension;
        return $this;
    }

    /**
     * 
     * @param string $file
     * @param array $data
     * @return self
     */
    public function template($file, $data = [])
    {
        $view = clone $this;
        $view->set($file);
        $view->data = $data;
        return $view;
    }

    /**
     * 
     * @param string $file
     * @param array $data
     * @return $this
     */
    public function set($file)
    {
        $this->file = $this->getViewPath($file);
        return $this;
    }

    /** @return string */
    public function getContent()
    {
        return $this->render();
    }

}
