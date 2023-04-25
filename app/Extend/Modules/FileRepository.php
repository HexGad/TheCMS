<?php

namespace App\Extend\Modules;

use Nwidart\Modules\Json;

class FileRepository extends \Nwidart\Modules\Laravel\LaravelFileRepository
{

    public function scan()
    {
        $paths = $this->getScanPaths();

        $modules = [];
        $foundManifests = [];

        foreach ($paths as $key => $path) {
            $manifests = $this->getFiles()->glob("{$path}/module.json");

            is_array($manifests) || $manifests = [];

            foreach ($manifests as $manifest) {
                $foundManifests[] =
                    array_merge(['dir_name'=> dirname($manifest)],Json::make($manifest)->getAttributes());

            }
        }
        usort($foundManifests, fn ($a, $b) => $a['priority'] > $b['priority']);
        foreach($foundManifests as $manifest)
            $modules[] = $this->createModule($this->app, $manifest['name'], $manifest['dir_name']);
        return $modules;
    }
}
