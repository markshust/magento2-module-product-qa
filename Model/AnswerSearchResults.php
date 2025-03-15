<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Api\SearchResults;
use MarkShust\ProductQA\Api\Data\AnswerSearchResultsInterface;

class AnswerSearchResults extends SearchResults implements AnswerSearchResultsInterface
{
}
