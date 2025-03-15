<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MarkShust\ProductQA\Api\Data\AnswerInterface;
use MarkShust\ProductQA\Api\Data\QuestionInterface;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;

class Questions extends Template
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param Session $customerSession
     * @param QuestionRepositoryInterface $questionRepository
     * @param AnswerRepositoryInterface $answerRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        private readonly Registry $registry,
        private readonly Session $customerSession,
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly AnswerRepositoryInterface $answerRepository,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get list of approved questions for current product
     *
     * @return QuestionInterface[]
     */
    public function getQuestions(): array
    {
        return $this->questionRepository->getByProductId(
            (int) $this->getProduct()->getId(),
            QuestionInterface::STATUS_APPROVED
        );
    }

    /**
     * Get answers for a question
     *
     * @param int $questionId
     * @return array
     */
    public function getAnswers(int $questionId): array
    {
        return $this->answerRepository->getByQuestionId(
            $questionId,
            AnswerInterface::STATUS_APPROVED
        );
    }

    /**
     * Check if customer is logged in
     *
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * Get form submission URL
     *
     * @return string
     */
    public function getFormAction(): string
    {
        return $this->getUrl('productqa/product/question', ['product_id' => $this->getProduct()->getId()]);
    }

    /**
     * Get answer form URL
     *
     * @param int $questionId
     * @return string
     */
    public function getAnswerFormAction(int $questionId): string
    {
        return $this->getUrl('productqa/product/answer', ['question_id' => $questionId]);
    }

    /**
     * Get customer data for form prefill
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerData(): array
    {
        if ($this->isCustomerLoggedIn()) {
            $customer = $this->customerSession->getCustomer();

            return [
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'customer_id' => $customer->getId(),
            ];
        }

        return [
            'name' => '',
            'email' => '',
            'customer_id' => null,
        ];
    }
}
