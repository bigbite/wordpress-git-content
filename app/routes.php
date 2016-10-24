<?php namespace GitContent;

/** @var \Herbert\Framework\Router $router */

$router->post([
    'as'   => 'githubHook',
    'uri'  => '/git-content/hook/{route}',
    'uses' => __NAMESPACE__ . '\Controllers\RouteController@githubHook'
]);
