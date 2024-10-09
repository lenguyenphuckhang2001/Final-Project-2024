<?php

/** Active Routes */

if (!function_exists('setActiveRoute')) {
    function setActiveRoute(array $routes): ?string
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return null;
    }
}
