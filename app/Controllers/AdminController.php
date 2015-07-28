<?php

namespace GitContent\Controllers;

use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use GitContent\Services\Github;

/**
 * Class AdminController.
 */
class AdminController
{
    public $optionName = 'gitcontent_settings';
    protected $options = [ 'token', 'repo', 'branch' ];

    public function index()
    {
        return view('@GitContent/admin/index.twig', [
            'fd' => get_option( $this->optionName )
        ]);
    }

    public function save(Http $http)
    {
        $inputs = $http->only($this->options);

        if ( ! $this->validate($inputs) || ! $this->check($inputs))
        {
            return redirect_response( panel_url('GitContent::settings') )->with('__form_data', $inputs);
        }

        update_option($this->optionName, $inputs);

        Notifier::success('Settings have been saved', true);
        return redirect_response( panel_url('GitContent::settings') );
    }

    protected function validate($inputs)
    {
        foreach ($inputs as $input)
        {
            if (empty($input))
            {
                Notifier::error('Please complete all fields', true);
                return false;
            }
        }
        return true;
    }

    protected function check($inputs)
    {
        $response = (new Github)->checkSettings($inputs);

        if ($response === true)
        {
            return true;
        }

        Notifier::error('Your setting aren\'t working, reason: ' . $response, true);
        return false;
    }
}
