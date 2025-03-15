<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AnswerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get answers list.
     *
     * @return \MarkShust\ProductQA\Api\Data\AnswerInterface[]
     */
    public function getItems();

    /**
     * Set answers list.
     *
     * @param \MarkShust\ProductQA\Api\Data\AnswerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
