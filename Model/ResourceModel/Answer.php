<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use MarkShust\ProductQA\Api\Data\AnswerInterface;

class Answer extends AbstractDb
{
    /**
     * Table name
     */
    const TABLE_NAME = 'markshust_productqa_answer';

    /**
     * Define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, AnswerInterface::ANSWER_ID);
    }
}
