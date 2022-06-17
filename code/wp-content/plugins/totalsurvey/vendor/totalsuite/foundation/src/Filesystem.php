<?php

namespace TotalSurveyVendors\TotalSuite\Foundation;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Flysystem\Filesystem as FlySystem;
use TotalSurveyVendors\League\Flysystem\FilesystemInterface;
use TotalSurveyVendors\League\Flysystem\PluginInterface;

/**
 * Class Filesystem
 *
 * @package TotalSuite\Foundation
 */
class Filesystem extends FlySystem
{
    /**
     * @param $path
     *
     * @return FilesystemInterface
     */
    public function withPrefix($path): FilesystemInterface
    {
        $clone = clone $this;
        $clone->getAdapter()->setPathPrefix($path);

        return $clone;
    }

    /**
     * @param PluginInterface $plugin
     *
     * @return Filesystem
     */
    public function withPlugin(PluginInterface $plugin): Filesystem
    {
        $clone = clone $this;
        $clone->addPlugin($plugin);

        return $clone;
    }


    public function __clone()
    {
        /**
         * @var PluginInterface $plugin
         */
        foreach ($this->plugins as $plugin) {
            $plugin->setFilesystem($this);
        }

        $this->adapter = clone $this->adapter;
    }


}