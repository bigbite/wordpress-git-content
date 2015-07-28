<?php

namespace GitContent\MetaBoxes;

/**
 * Class Validator.
 */
class Validator
{
    /**
     * Checks to save if its okay to save/update a metabox.
     *
     * @param $nonce
     * @param $name
     * @param $postID
     *
     * @return bool
     */
    public function validateSave($nonce, $name, $postID)
    {
        $http = herbert('http');

        if (!$http->has($nonce)) {
            return false;
        }

        if (!wp_verify_nonce($http->get($nonce), $name)) {
            return false;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }

        if ($http->get('post_type') == 'page') {
            if (!current_user_can('edit_page', $postID)) {
                return false;
            }
        } else {
            if (!current_user_can('edit_post', $postID)) {
                return false;
            }
        }

        return true;
    }
}
