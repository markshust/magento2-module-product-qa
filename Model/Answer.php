<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Model\AbstractModel;
use MarkShust\ProductQA\Api\Data\AnswerInterface;
use MarkShust\ProductQA\Model\ResourceModel\Answer as AnswerResourceModel;

class Answer extends AbstractModel implements AnswerInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(AnswerResourceModel::class);
    }

    /**
     * Get answer ID
     *
     * @return int|null
     */
    public function getAnswerId(): ?int
    {
        return $this->getData(self::ANSWER_ID) ? (int) $this->getData(self::ANSWER_ID) : null;
    }

    /**
     * Set answer ID
     *
     * @param int $answerId
     * @return $this
     */
    public function setAnswerId(int $answerId): static
    {
        return $this->setData(self::ANSWER_ID, $answerId);
    }

    /**
     * Get question ID
     *
     * @return int
     */
    public function getQuestionId(): int
    {
        return (int) $this->getData(self::QUESTION_ID);
    }

    /**
     * Set question ID
     *
     * @param int $questionId
     * @return $this
     */
    public function setQuestionId(int $questionId): static
    {
        return $this->setData(self::QUESTION_ID, $questionId);
    }

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID) ? (int) $this->getData(self::CUSTOMER_ID) : null;
    }

    /**
     * Set customer ID
     *
     * @param int|null $customerId
     * @return $this
     */
    public function setCustomerId(?int $customerId): static
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get author name
     *
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->getData(self::AUTHOR_NAME);
    }

    /**
     * Set author name
     *
     * @param string $authorName
     * @return $this
     */
    public function setAuthorName(string $authorName): static
    {
        return $this->setData(self::AUTHOR_NAME, $authorName);
    }

    /**
     * Get author email
     *
     * @return string
     */
    public function getAuthorEmail(): string
    {
        return $this->getData(self::AUTHOR_EMAIL);
    }

    /**
     * Set author email
     *
     * @param string $authorEmail
     * @return $this
     */
    public function setAuthorEmail(string $authorEmail): static
    {
        return $this->setData(self::AUTHOR_EMAIL, $authorEmail);
    }

    /**
     * Get answer text
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Set answer text
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer(string $answer): static
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): static
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set creation time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): static
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get update time
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set update time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): static
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
