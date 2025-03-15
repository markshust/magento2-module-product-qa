<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model\Question;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use MarkShust\ProductQA\Model\ResourceModel\Question\CollectionFactory;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;

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
     * @param QuestionRepositoryInterface $questionRepository
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
        private readonly QuestionRepositoryInterface $questionRepository,
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

        if ($questionId = (int) $this->request->getParam('id')) {
            try {
                $question = $this->questionRepository->getById($questionId);
                $this->loadedData[$questionId] = $question->getData();
            } catch (NoSuchEntityException $e) {
                // Question does not exist
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
