<?php
namespace TestTask\Decorator;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use TestTask\Integration\DataProviderInterface;

interface DecoratorManagerInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;

    /**
     * @param LoggerInterface $logger
     * 
     * @return void
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * @return CacheItemPoolInterface
     */
    public function getCache(): CacheItemPoolInterface;

    /**
     * @param CacheItemPoolInterface $cache
     * 
     * @return void
     */
    public function setCache(CacheItemPoolInterface $cache);

    /**
     * @param array{
     *  source: string, // The URL-encoded request definition.
     * } $request
     *
     * @return array
     */
    public function getResponse(array $request): array;
    
    /**
     * @param DataProviderInterface $dataProvider
     * @return void
     */
    public function setDataProvider(DataProviderInterface $dataProvider);
    
    /**
     * @param DataProviderInterface $dataProvider
     * 
     * @return DataProviderInterface
     */
    public function getDataProvider(DataProviderInterface $dataProvider): DataProviderInterface;
}