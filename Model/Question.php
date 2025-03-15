<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Model;

use Magento\Framework\Model\AbstractModel;
use MarkShust\ProductQA\Api\Data\QuestionInterface;
use MarkShust\ProductQA\Model\ResourceModel\Question as QuestionResourceModel;

class Question extends AbstractModel implements QuestionInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(QuestionResourceModel::class);
    }

    /**
     * Get question ID
     *
     * @return int|null
     */
    public function getQuestionId(): ?int
    {
        return $this->getData(self::QUESTION_ID) ? (int) $this->getData(self::QUESTION_ID) : null;
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
     * Get product ID
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int) $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set product ID
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId(int $productId): static
    {
        return $this->setData(self::PRODUCT_ID, $productId);
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
     * Get question text
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Set question text
     *
     * @param string $question
     * @return $this
     */
    public function setQuestion(string $question): static
    {
        return $this->setData(self::QUESTION, $question);
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
