<?php
namespace App\Extend\Modules;


use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;

class ModuleGenerator extends \Nwidart\Modules\Generators\ModuleGenerator
{
    protected function getSingularStudlyNameReplacement()
    {
        return Str::singular(
            Str::studly($this->getName())
        );
    }

    protected function getSingularLowerNameReplacement()
    {
        return strtolower(
            Str::singular($this->getName())
        );
    }

    protected function getVendorLowerReplacement()
    {
        return strtolower($this->getVendorReplacement());
    }

    protected function getPriorityReplacement()
    {
        return count(Module::all());
    }

    public function generateResources()
    {
        parent::generateResources();

        if (GenerateConfigReader::read('datatable')->generate() === true) {
            $this->console->call('module:make-datatable', [
                'datatable' => $this->getName(),
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('model')->generate() === true) {
            $this->console->call('module:make-migration', [
                'name' => 'create_'.strtolower($this->getName()).'_table',
                'module' => $this->getName(),
            ]);
            $this->console->call('module:make-model', [
                'model' => Str::singular($this->getName()),
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('request')->generate() === true) {
            $this->console->call('module:make-request', [
                'name' => 'Store'.$this->getName().'Request',
                'module' => $this->getName(),
            ]);

            $this->console->call('module:make-request', [
                'name' => 'Update'.$this->getName().'Request',
                'module' => $this->getName(),
            ]);
        }
    }
}
