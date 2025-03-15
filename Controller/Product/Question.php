<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Product;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use MarkShust\ProductQA\Api\Data\QuestionInterface;
use MarkShust\ProductQA\Api\Data\QuestionInterfaceFactory;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;

class Question implements ActionInterface, HttpPostActionInterface
{
    /**
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     * @param FormKeyValidator $formKeyValidator
     * @param ManagerInterface $messageManager
     * @param Session $customerSession
     * @param QuestionInterfaceFactory $questionFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly RedirectFactory $redirectFactory,
        private readonly FormKeyValidator $formKeyValidator,
        private readonly ManagerInterface $messageManager,
        private readonly Session $customerSession,
        private readonly QuestionInterfaceFactory $questionFactory,
        private readonly QuestionRepositoryInterface $questionRepository,
    ) {}

    /**
     * Submit a new question
     *
     * @return Redirect
     */
    public function execute(): Redirect {
        $resultRedirect = $this->redirectFactory->create();

        if (!$this->formKeyValidator->validate($this->request)) {
            $this->messageManager->addErrorMessage(__('Invalid form key. Please try again.'));

            return $resultRedirect->setRefererUrl();
        }

        $data = $this->request->getPostValue();
        $productId = (int) $this->request->getParam('product_id');

        if (!$productId) {
            $this->messageManager->addErrorMessage(__('Invalid product ID. Please try again.'));

            return $resultRedirect->setRefererUrl();
        }

        try {
            $question = $this->questionFactory->create();
            $question->setProductId($productId);
            $question->setQuestion($data['question']);
            $question->setAuthorName($data['author_name']);
            $question->setAuthorEmail($data['author_email']);
            $question->setStatus(QuestionInterface::STATUS_PENDING);

            if ($this->customerSession->isLoggedIn()) {
                $question->setCustomerId((int) $this->customerSession->getCustomerId());
            }

            $this->questionRepository->save($question);

            $this->messageManager->addSuccessMessage(__('Your question has been submitted and will be answered soon.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while submitting your question.'));
        }

        return $resultRedirect->setRefererUrl();
    }
}
