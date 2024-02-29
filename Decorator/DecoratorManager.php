<?php 

namespace TestTask\Decorator;

use DateTime;
use DateTimeInterface;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use TestTask\Integration\DataProviderInterface;

class DecoratorManager implements DecoratorManagerInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    protected  CacheItemPoolInterface $cache;

    /**
     * @var LoggerInterface
     */
    protected  LoggerInterface $logger;

    /**
     * @var DataProviderInterface
     */
    protected DataProviderInterface $dataProvider;

    public const CACHE_DATE_MODIFIER = "+1 day";

    /**
     * @param DataProviderInterface $dataProvider
     * @param LoggerInterface $logger
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache = null, LoggerInterface $logger = null)
    {
        $this->setDataProvider($dataProvider);
        $this->setLogger($logger);
        $this->setCache($cache);
    }

    /**
     * {@inheritdoc}
     */
    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDataProvider(DataProviderInterface $dataProvider): DataProviderInterface
    {
        return $this->dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = new NullLogger();
        if (!is_null($logger)) {
            $this->logger = $logger;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getCache(): CacheItemPoolInterface
    {
        return $this->cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $request): array
    {
        try {
            if (isset($this->cache)) {
                $cacheKey = $this->getCacheKey($request);
                $cacheItem = $this->cache->getItem($cacheKey);
                if ($cacheItem->isHit()) {
                    return $cacheItem->get();
                }
            }

            $result = $this->dataProvider->get($request);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    $this->getExpireTime()
                );

            return $result;
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        return [];
    }

    /**
     * @param array $input
     * 
     * @return string
     */
    protected function getCacheKey(array $request): string
    {
        return json_encode($request);
    }

    /**
     * @return DateTimeInterface
     */
    protected function getExpireTime(): DateTimeInterface
    {
        return (new DateTime())->modify(self::CACHE_DATE_MODIFIER);
    }
}