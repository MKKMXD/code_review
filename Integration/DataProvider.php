<?php

namespace TestTask\Integration;

use Exception;

class DataProvider implements DataProviderInterface
{
    /**
     * @var string $host
     */
    private $host;

    /**
     * @var string $user
     */
    private $user;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct(string $host, string $user, string $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        // returns a response from external service
        
        return [];
    }
}