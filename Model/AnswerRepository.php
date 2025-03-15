<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;
use MarkShust\ProductQA\Api\Data\AnswerInterface;
use MarkShust\ProductQA\Api\Data\AnswerSearchResultsInterface;
use MarkShust\ProductQA\Api\Data\AnswerSearchResultsInterfaceFactory;
use MarkShust\ProductQA\Model\ResourceModel\Answer as AnswerResource;
use MarkShust\ProductQA\Model\AnswerFactory;
use MarkShust\ProductQA\Model\ResourceModel\Answer\CollectionFactory as AnswerCollectionFactory;

class AnswerRepository implements AnswerRepositoryInterface
{
    /**
     * @param AnswerResource $resource
     * @param AnswerFactory $answerFactory
     * @param AnswerCollectionFactory $collectionFactory
     * @param AnswerSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private readonly AnswerResource $resource,
        private readonly AnswerFactory $answerFactory,
        private readonly AnswerCollectionFactory $collectionFactory,
        private readonly AnswerSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {}

    /**
     * Save answer
     *
     * @param AnswerInterface $answer
     * @return AnswerInterface
     * @throws CouldNotSaveException
     */
    public function save(AnswerInterface $answer): AnswerInterface
    {
        try {
            $this->resource->save($answer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $answer;
    }

    /**
     * Get answer by ID
     *
     * @param int $answerId
     * @return AnswerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $answerId): AnswerInterface
    {
        $answer = $this->answerFactory->create();
        $this->resource->load($answer, $answerId);
        if (!$answer->getId()) {
            throw new NoSuchEntityException(__('Answer with id "%1" does not exist.', $answerId));
        }
        return $answer;
    }

    /**
     * Get answers by question ID
     *
     * @param int $questionId
     * @param int|null $status
     * @return \MarkShust\ProductQA\Api\Data\AnswerInterface[]
     */
    public function getByQuestionId(
        int $questionId,
        int $status = null,
    ): array {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(AnswerInterface::QUESTION_ID, $questionId);

        if ($status !== null) {
            $collection->addFieldToFilter(AnswerInterface::STATUS, $status);
        }

        return $collection->getItems();
    }

    /**
     * Get list of answers
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AnswerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AnswerSearchResultsInterface
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
     * Delete answer
     *
     * @param AnswerInterface $answer
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AnswerInterface $answer): bool
    {
        try {
            $this->resource->delete($answer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete answer by ID
     *
     * @param int $answerId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $answerId): bool
    {
        return $this->delete($this->getById($answerId));
    }
}
