<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MarkShust\ProductQA\Model\Question;
use MarkShust\ProductQA\Model\ResourceModel\Question as QuestionResource;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Question::class, QuestionResource::class);
    }
}
