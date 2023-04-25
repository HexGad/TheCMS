<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\ControllerMakeCommand as BaseCommand;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class DataTableMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'datatable';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-datatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DataTable for the specified module.';

    protected function getDataTableName(): string
    {
        $datatable = Str::studly($this->argument($this->argumentName));

        if (Str::contains(strtolower($datatable), 'DataTable') === false) {
            $datatable .= 'DataTable';
        }

        return $datatable;
    }

    private function getDataTableNameWithoutNamespace()
    {
        return class_basename($this->getDataTableName());
    }

    private function getModelName()
    {
        return Str::studly(
            Str::singular($this->getModuleName())
        );
    }
    private function getModelNameSpace($module)
    {
        $extra = str_replace($this->getClass(), '', $this->getModelName());

        $extra = str_replace('/', '\\', $extra);

        $namespace = $this->laravel['modules']->config('namespace');

        $namespace .= '\\' . $module->getStudlyName();

        $namespace .= '\\' . $this->getDefaultNamespace();

        $namespace .= '\\' . $extra;

        $namespace = str_replace('/', '\\', $namespace);

        return trim($namespace, '\\');
    }

    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/datatable.stub', [
            'MODULENAME'        => $module->getStudlyName(),
            'DATATABLENAME'    => $this->getDataTableName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getDataTableNameWithoutNamespace(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'MODEL'             => $this->getModelName(),
            'MODEL_NAMESPACE'   => $this->getModelNameSpace($module),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('datatable');

        return $path . $controllerPath->getPath() . '/' . $this->getDataTableName() . '.php';
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['datatable', InputArgument::REQUIRED, 'The name of the Datatable class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

}
