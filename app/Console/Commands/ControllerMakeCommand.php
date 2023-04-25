<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\ControllerMakeCommand as BaseCommand;
use Nwidart\Modules\Support\Stub;

class ControllerMakeCommand extends BaseCommand
{
    protected function getControllerName()
    {
        $controller = Str::studly($this->argument('controller'));
        $controller = str_replace('Controller', '',$controller);
        $controller = Str::singular($controller);
        $controller .=  'Controller';

        return $controller;
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'CONTROLLERNAME'    => $this->getControllerName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => class_basename($this->getControllerName()),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'SINGULAR_NAME'     => $this->getSingularName($module->getStudlyName()),
            'SINGULAR_LOWER_NAME'=> strtolower($this->getSingularName($module->getStudlyName())),
        ]))->render();
    }

    protected function getSingularName($name)
    {
        return Str::singular($name);
    }
}
