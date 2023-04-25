<?php

use HexGad\Permissions\Providers\PermissionsServiceProvider;

if (!function_exists('module_can')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     * @return string
     */
    function module_can($permission)
    {
        if (! app()->providerIsLoaded(PermissionsServiceProvider::class))
            return \Illuminate\Support\Facades\Gate::check($permission);

        return true;
    }
}
