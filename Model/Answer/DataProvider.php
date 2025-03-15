<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model\Answer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use MarkShust\ProductQA\Model\ResourceModel\Answer\CollectionFactory;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param AnswerRepositoryInterface $answerRepository
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly AnswerRepositoryInterface $answerRepository,
        private readonly RequestInterface $request,
        array $meta = [],
        array $data = [],
        private readonly ?PoolInterface $pool = null,
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        if ($answerId = (int) $this->request->getParam('id')) {
            try {
                $answer = $this->answerRepository->getById($answerId);
                $this->loadedData[$answerId] = $answer->getData();
            } catch (NoSuchEntityException $e) {
                // Answer does not exist
            }
        }

        if ($this->pool) {
            foreach ($this->pool->getModifiersInstances() as $modifier) {
                $this->loadedData = $modifier->modifyData($this->loadedData);
            }
        }

        return $this->loadedData;
    }

    /**
     * Get meta information
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMeta(): array
    {
        $meta = parent::getMeta();

        if ($this->pool) {
            foreach ($this->pool->getModifiersInstances() as $modifier) {
                $meta = $modifier->modifyMeta($meta);
            }
        }

        return $meta;
    }
}
