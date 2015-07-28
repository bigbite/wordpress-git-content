<?php

use GitContent\MetaBoxes\ExtendPublish;
use GitContent\Helper;

/* @var  \Herbert\Framework\Application $container */

add_filter( 'the_content', function ($content) {

    global $post;
    if ($post->post_type != 'post')
    {
        return $content;
    }

    $meta = get_post_meta($post->ID, (new ExtendPublish)->metaKey, true);

    if($meta)
    {
        $file = Helper::storagePath($post->ID);
        if (strlen(trim($meta)) > 0 && file_exists($file))
        {
            $content = (new Parsedown)->text(file_get_contents($file));
        }
    }

    return $content;
});
