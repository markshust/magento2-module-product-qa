<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api;

use MarkShust\ProductQA\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MarkShust\ProductQA\Api\Data\QuestionInterface;

interface QuestionRepositoryInterface
{
    /**
     * Save question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function save(QuestionInterface $question): QuestionInterface;

    /**
     * Get question by ID
     *
     * @param int $questionId
     * @return QuestionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $questionId): QuestionInterface;

    /**
     * Get questions by product ID
     *
     * @param int $productId
     * @param int|null $status
     * @return \MarkShust\ProductQA\Api\Data\QuestionInterface[]
     */
    public function getByProductId(int $productId, int $status = null): array;

    /**
     * Get list of questions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \MarkShust\ProductQA\Api\Data\QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface;

    /**
     * Delete question
     *
     * @param QuestionInterface $question
     * @return bool
     * @throws LocalizedException
     */
    public function delete(QuestionInterface $question): bool;

    /**
     * Delete question by ID
     *
     * @param int $questionId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $questionId): bool;
}
