<?php

namespace AppBundle\Factory;

use Google_Service_Storage;

class GoogleCloudStorageServiceFactory
{
    private $configuration;

    function __construct($cloudStorageConfig)
    {
        $this->configuration = $cloudStorageConfig;
    }

    public function createService() {
        $client = new \Google_Client();

        $client->setAuthConfig($this->configuration['key']);
        $client->setScopes([$this->configuration['scope']]);

        return new Google_Service_Storage($client);
    }
}