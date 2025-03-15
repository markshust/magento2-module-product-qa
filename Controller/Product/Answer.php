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
use MarkShust\ProductQA\Api\Data\AnswerInterface;
use MarkShust\ProductQA\Api\Data\AnswerInterfaceFactory;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;

class Answer implements ActionInterface, HttpPostActionInterface
{
    /**
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     * @param FormKeyValidator $formKeyValidator
     * @param ManagerInterface $messageManager
     * @param Session $customerSession
     * @param AnswerInterfaceFactory $answerFactory
     * @param AnswerRepositoryInterface $answerRepository
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly RedirectFactory $redirectFactory,
        private readonly FormKeyValidator $formKeyValidator,
        private readonly ManagerInterface $messageManager,
        private readonly Session $customerSession,
        private readonly AnswerInterfaceFactory $answerFactory,
        private readonly AnswerRepositoryInterface $answerRepository,
        private readonly QuestionRepositoryInterface $questionRepository,
    ) {}

    /**
     * Submit a new answer
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->redirectFactory->create();

        if (!$this->formKeyValidator->validate($this->request)) {
            $this->messageManager->addErrorMessage(__('Invalid form key. Please try again.'));

            return $resultRedirect->setRefererUrl();
        }

        $data = $this->request->getPostValue();
        $questionId = (int) $this->request->getParam('question_id');

        if (!$questionId) {
            $this->messageManager->addErrorMessage(__('Invalid question ID. Please try again.'));

            return $resultRedirect->setRefererUrl();
        }

        try {
            // Validate that question exists
            $question = $this->questionRepository->getById($questionId);

            if (!$question->getQuestionId()) {
                $this->messageManager->addErrorMessage(__('Invalid question ID. Please try again.'));

                return $resultRedirect->setRefererUrl();
            }

            $answer = $this->answerFactory->create();
            $answer->setQuestionId($questionId);
            $answer->setAnswer($data['answer']);
            $answer->setAuthorName($data['author_name']);
            $answer->setAuthorEmail($data['author_email']);
            $answer->setStatus(AnswerInterface::STATUS_PENDING);

            if ($this->customerSession->isLoggedIn()) {
                $answer->setCustomerId((int) $this->customerSession->getCustomerId());
            }

            $this->answerRepository->save($answer);

            $this->messageManager->addSuccessMessage(__('Your answer has been submitted and will be reviewed soon.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while submitting your answer.'));
        }

        return $resultRedirect->setRefererUrl();
    }
}
