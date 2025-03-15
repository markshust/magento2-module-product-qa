<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api;

use MarkShust\ProductQA\Api\Data\AnswerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MarkShust\ProductQA\Api\Data\AnswerInterface;

interface AnswerRepositoryInterface
{
    /**
     * Save answer
     *
     * @param AnswerInterface $answer
     * @return AnswerInterface
     * @throws LocalizedException
     */
    public function save(AnswerInterface $answer): AnswerInterface;

    /**
     * Get answer by ID
     *
     * @param int $answerId
     * @return AnswerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $answerId): AnswerInterface;

    /**
     * Get answers by question ID
     *
     * @param int $questionId
     * @param int|null $status
     * @return \MarkShust\ProductQA\Api\Data\AnswerInterface[]
     */
    public function getByQuestionId(int $questionId, int $status = null): array;

    /**
     * Get list of answers
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \MarkShust\ProductQA\Api\Data\AnswerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AnswerSearchResultsInterface;

    /**
     * Delete answer
     *
     * @param AnswerInterface $answer
     * @return bool
     * @throws LocalizedException
     */
    public function delete(AnswerInterface $answer): bool;

    /**
     * Delete answer by ID
     *
     * @param int $answerId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $answerId): bool;
}
