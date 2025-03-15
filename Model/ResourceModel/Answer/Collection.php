<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model\ResourceModel\Answer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MarkShust\ProductQA\Model\Answer;
use MarkShust\ProductQA\Model\ResourceModel\Answer as AnswerResource;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Answer::class, AnswerResource::class);
    }
}
