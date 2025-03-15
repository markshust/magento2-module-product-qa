<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use MarkShust\ProductQA\Api\Data\QuestionInterface;
use MarkShust\ProductQA\Api\Data\QuestionSearchResultsInterface;
use MarkShust\ProductQA\Api\Data\QuestionSearchResultsInterfaceFactory;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;
use MarkShust\ProductQA\Model\ResourceModel\Question as QuestionResource;
use MarkShust\ProductQA\Model\QuestionFactory;
use MarkShust\ProductQA\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @param QuestionResource $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionCollectionFactory $collectionFactory
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private readonly QuestionResource $resource,
        private readonly QuestionFactory $questionFactory,
        private readonly QuestionCollectionFactory $collectionFactory,
        private readonly QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {}

    /**
     * Save question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        try {
            $this->resource->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $question;
    }

    /**
     * Get question by ID
     *
     * @param int $questionId
     * @return QuestionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $questionId): QuestionInterface
    {
        $question = $this->questionFactory->create();
        $this->resource->load($question, $questionId);

        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
        }

        return $question;
    }

    /**
     * Get questions by product ID
     *
     * @param int $productId
     * @param int|null $status
     * @return \MarkShust\ProductQA\Api\Data\QuestionInterface[]
     */
    public function getByProductId(int $productId, int $status = null): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(QuestionInterface::PRODUCT_ID, $productId);

        if ($status !== null) {
            $collection->addFieldToFilter(QuestionInterface::STATUS, $status);
        }

        return $collection->getItems();
    }

    /**
     * Get list of questions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete question
     *
     * @param QuestionInterface $question
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->resource->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete question by ID
     *
     * @param int $questionId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $questionId): bool
    {
        return $this->delete($this->getById($questionId));
    }
}
