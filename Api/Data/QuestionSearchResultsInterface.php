<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \MarkShust\ProductQA\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param \MarkShust\ProductQA\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
