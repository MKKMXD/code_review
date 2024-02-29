<?php

namespace TestTask\Integration;

use Exception;

interface DataProviderInterface
{
    /**
     * @param array $request
     *
     * @return array
     * 
     * @throws Exception
     */
    public function get(array $request): array;
}