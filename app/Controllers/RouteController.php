<?php

namespace GitContent\Controllers;

use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use GitContent\Helper;
use GitContent\Services\Github;
use Parsedown;
use ParsedownExtra;

/**
 * Class RouteController.
 */
class RouteController {

    public function githubHook($route) {

        $github = new Github();
        $http = herbert('http');
        $fd = get_option( 'gitcontent_settings' );

        if ( $route != $fd['route'] ) {
            return;
        }

        $args = [
           'meta_query' => [[
               'key' => '_gitcontent_file',
               'value' => '',
               'compare' => '!=',
           ]]
        ];
        $posts = get_posts($args);

        foreach( $posts as $post ) {

            $file = get_post_meta( $post->ID, '_gitcontent_file', true );
            $inputs = get_option( 'gitcontent_settings' );
            $response = $github->checkFile($inputs, $file);
            $markdownFile = Helper::storagePath($post->ID);

            if ($response === false)
            {
                return;
            }

            if ($github->downloadFile($inputs, $response, $markdownFile) === false)
            {
                return;
            }

            wp_update_post([
                'ID' => $post->ID,
                'post_content' => (new ParsedownExtra)->text(file_get_contents($markdownFile))
            ], false);

        }

        echo 'Done';
    }

}
