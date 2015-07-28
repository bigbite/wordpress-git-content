<?php namespace GitContent;

/** @var \Herbert\Framework\Panel $panel */

$panel->add([
    'type'  => 'panel',
    'as'    => 'settings',
    'title' => 'Git Content',
    'slug'  => 'gitcontent-index',
    'icon'  => Helper::assetUrl('/images/git.svg'),
    'uses'  => __NAMESPACE__.'\Controllers\AdminController@index',
    'post'  => __NAMESPACE__.'\Controllers\AdminController@save',
]);
