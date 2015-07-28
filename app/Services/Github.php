<?php

namespace GitContent\Services;

use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Github
 */
class Github
{
    protected $client;

    public function __construct ()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com'
        ]);
    }

    protected function get($url, $token = false, $save = false) {

        $settings = [
            'headers' => [
                'Accept' => 'application/vnd.github.moondragon+json',
                'Authorization' => 'token '. $token
            ]
        ];

        if ($save)
        {
            $settings['save_to'] = $save;
        }

        try {
            $response = $this->client->get($url, $settings);

            if ($save)
            {
                return true;
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();

            if ($save)
            {
                return false;

            }
        }
        return $response;
    }



    public function checkSettings($inputs)
    {
        $response = $this->get("/repos/{$inputs['repo']}/branches/{$inputs['branch']}", $inputs['token']);

        if ($response->getStatusCode() != 200)
        {
            return (string) $response->getReasonPhrase();
        }
        return true;
    }

    public function checkFile($inputs, $file)
    {
        $response = $this->get("/repos/{$inputs['repo']}/contents/{$file}?ref={$inputs['branch']}", $inputs['token']);

        if ($response->getStatusCode() != 200)
        {
            return false;
        }

        $download = json_decode($response->getBody()->getContents());
        return $download->download_url;
    }

    public function downloadFile($inputs, $url, $save)
    {
        return $this->get($url, $inputs['token'], $save);
    }
}
