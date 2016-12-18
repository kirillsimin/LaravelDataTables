<?php
/**
 * Navigation Helpers
 *
 * Provides useful helper functions related to navigation.
 ****************************************************************************************/
/**
 * Detect if current route name matches specific route name and output
 * a class name to indicate menu item is active. This matches on part before first
 * period so that it applies to a group.
 *
 * @param string    Name of route to compare to
 * @param string    Name of class (or text) to return if matching route
 */
function detectActiveNavigation($matchRouteName, $activeClass = 'active')
{
    if(Route::getCurrentRoute()) {
        $route = Route::getCurrentRoute()->getName();
        $expression = '/\b'.preg_quote($matchRouteName).'\b/i';
        if (preg_match($expression, $route)) {
            return 'active';
        }
    }
}
/**
 * Similar to detectActiveNavigation, but for individual views.
 *
 * @param string    Name of route to compare to
 * @param string    Name of class (or text) to return if matching route
 */
function detectActiveNavigationSolo($matchRouteName, $activeClass = 'active')
{
    if(!Route::getCurrentRoute()) {
        $route = Route::getCurrentRoute()->getName();
        if ($route == $matchRouteName) {
            return 'active';
        }
    }
}