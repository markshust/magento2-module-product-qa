<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Api\Data;

interface AnswerInterface
{
    /**
     * Constants for keys of data array
     */
    const ANSWER_ID = 'answer_id';
    const QUESTION_ID = 'question_id';
    const CUSTOMER_ID = 'customer_id';
    const AUTHOR_NAME = 'author_name';
    const AUTHOR_EMAIL = 'author_email';
    const ANSWER = 'answer';
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
     * Get answer ID
     *
     * @return int|null
     */
    public function getAnswerId(): ?int;

    /**
     * Set answer ID
     *
     * @param int $answerId
     * @return $this
     */
    public function setAnswerId(int $answerId): static;

    /**
     * Get question ID
     *
     * @return int
     */
    public function getQuestionId(): int;

    /**
     * Set question ID
     *
     * @param int $questionId
     * @return $this
     */
    public function setQuestionId(int $questionId): static;

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
     * Get answer text
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Set answer text
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer(string $answer): static;

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
