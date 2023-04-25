<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    private $guards;

    protected function unauthenticated($request, array $guards)
    {
        $this->guards = $guards;
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $guard = $this->guards[0] === null ?
            config('auth.defaults.guard') :
            array_keys(config('auth.guards'))[array_search($this->guards[0], array_keys(config('auth.guards')))];

        return $request->expectsJson() ? null : route($guard . '.login');
    }
}
