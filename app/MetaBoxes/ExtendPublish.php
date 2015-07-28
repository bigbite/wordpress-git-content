<?php

namespace GitContent\MetaBoxes;

use GitContent\Helper;
use GitContent\Controllers\AdminController;
use GitContent\Services\Github;
use Herbert\Framework\Notifier;
/**
 * Class ExtendPublish.
 */
class ExtendPublish
{
    /**
     * @var \Twig_Environment
     */
    protected $view;

    /**
     * Metabox name.
     *
     * @var string
     */
    protected $name;

    /**
     * Metabox nonce.
     *
     * @var string
     */
    protected $nonce;

    /**
     * Metabox key (name in database).
     *
     * @var string
     */
    public $metaKey;

    /**
     *  Constructs the metabox.
     */
    public function __construct()
    {
        $this->view = herbert('twig');
        $this->name = 'gitcontent_file';
        $this->nonce = 'gitcontent_file_nonce';
        $this->metaKey = '_gitcontent_file';

        add_action('post_submitbox_misc_actions', [$this, 'add']);
        add_action('save_post', [$this, 'save']);
    }

    /**
     * Gets post and fetches template.
     */
    public function add()
    {
        $post = $this->getPost();

        if ($post->post_type !== 'post') {
            return;
        }

        $this->template($post);
    }

    /**
     * Prints out the metabox template.
     *
     * @param $post
     */
    public function template($post)
    {
        $value = get_post_meta($post->ID, $this->metaKey, true);

        wp_nonce_field($this->name, $this->nonce);

        echo $this->view->render('@GitContent/metaboxes/extendPublish.twig', [
            'logo' => Helper::assetUrl('/images/git-dark.svg'),
            'file' => $value,
        ]);
    }

    /**
     * Handles the save of metabox values.
     *
     * @param $postID
     *
     * @return mixed
     */
    public function save($postID)
    {
        $validator = new Validator();
        $github = new Github();
        $http = herbert('http');

        if (!$validator->validateSave($this->nonce, $this->name, $postID)) {
            return $postID;
        }

        $file = trim($http->get('gitcontent_file'));
        if (strlen($file) == 0)
        {
            Notifier::success('Git Content: Disabled', true);
            update_post_meta($postID, $this->metaKey, '');
            return;
        }

        $inputs = get_option( (new AdminController)->optionName );
        $response = $github->checkFile($inputs, $file);

        if($response === false)
        {
            Notifier::error('Git Content: Something went wrong, check the name of your file.', true);
            return;
        }

        if($github->downloadFile($inputs, $response, Helper::storagePath($postID)) === false)
        {
            Notifier::error('Git Content: Something went wrong, couldn\'t download file', true);
            return;
        }

        Notifier::success('Git Content: Success using ' . $file, true);
        update_post_meta($postID, $this->metaKey, $file);
    }

    /**
     * Returns the current post.
     *
     * @return mixed
     */
    public function getPost()
    {
        global $post;

        return $post;
    }
}
