<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api\Data;

interface QuestionInterface
{
    /**
     * Constants for keys of data array
     */
    const QUESTION_ID = 'question_id';
    const PRODUCT_ID = 'product_id';
    const CUSTOMER_ID = 'customer_id';
    const AUTHOR_NAME = 'author_name';
    const AUTHOR_EMAIL = 'author_email';
    const QUESTION = 'question';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Status constants
     */
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * Get question ID
     *
     * @return int|null
     */
    public function getQuestionId(): ?int;

    /**
     * Set question ID
     *
     * @param int $questionId
     * @return $this
     */
    public function setQuestionId(int $questionId): static;

    /**
     * Get product ID
     *
     * @return int
     */
    public function getProductId(): int;

    /**
     * Set product ID
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId(int $productId): static;

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer ID
     *
     * @param int|null $customerId
     * @return $this
     */
    public function setCustomerId(?int $customerId): static;

    /**
     * Get author name
     *
     * @return string
     */
    public function getAuthorName(): string;

    /**
     * Set author name
     *
     * @param string $authorName
     * @return $this
     */
    public function setAuthorName(string $authorName): static;

    /**
     * Get author email
     *
     * @return string
     */
    public function getAuthorEmail(): string;

    /**
     * Set author email
     *
     * @param string $authorEmail
     * @return $this
     */
    public function setAuthorEmail(string $authorEmail): static;

    /**
     * Get question text
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Set question text
     *
     * @param string $question
     * @return $this
     */
    public function setQuestion(string $question): static;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): static;

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Set creation time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): static;

    /**
     * Get update time
     *
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * Set update time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): static;
}
