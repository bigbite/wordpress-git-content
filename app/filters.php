<?php

use GitContent\Helper;
use GitContent\Controllers\AdminController;
use GitContent\Services\Github;
use Herbert\Framework\Notifier;
use GitContent\MetaBoxes\ExtendPublish;
use Parsedown;
use ParsedownExtra;

/* @var  \Herbert\Framework\Application $container */

// add_filter( 'wp_insert_post_data', function($post, $postRaw) {

//     if ($postRaw['post_type'] != 'post')
//     {
//         return $post;
//     }

//     $meta = get_post_meta($postRaw['ID'], (new ExtendPublish)->metaKey, true);

//     if($meta)
//     {
//         $file = Helper::storagePath($postRaw['ID']);
//         if (strlen(trim($meta)) > 0 && file_exists($file))
//         {
//              $post['post_content'] = (new ParsedownExtra)->text(file_get_contents($file));
//         }
//     }

//     @unlink($file);

//     return $post;

// }, 99, 2);
