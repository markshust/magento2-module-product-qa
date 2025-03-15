<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Answer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::answers';

    /**
     * @param Context $context
     * @param AnswerRepositoryInterface $answerRepository
     */
    public function __construct(
        Context $context,
        private readonly AnswerRepositoryInterface $answerRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $this->answerRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the answer.'));

                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The answer no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the answer.'));

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find an answer to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
