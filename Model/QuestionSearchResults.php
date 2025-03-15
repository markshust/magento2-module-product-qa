<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Api\SearchResults;
use MarkShust\ProductQA\Api\Data\QuestionSearchResultsInterface;

class QuestionSearchResults extends SearchResults implements QuestionSearchResultsInterface
{
}
