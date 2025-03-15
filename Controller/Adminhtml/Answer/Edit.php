<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Answer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::answers';

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param AnswerRepositoryInterface $answerRepository
     */
    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly Registry $coreRegistry,
        private readonly AnswerRepositoryInterface $answerRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * Edit answer page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = (int) $this->getRequest()->getParam('id');

        try {
            $model = $this->answerRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This answer no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        // Register model to use later in blocks
        $this->coreRegistry->register('productqa_answer', $model);

        // Build edit form
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MarkShust_ProductQA::answers')
            ->addBreadcrumb(__('Product Q&A'), __('Product Q&A'))
            ->addBreadcrumb(__('Answers'), __('Answers'))
            ->addBreadcrumb(
                $id ? __('Edit Answer') : __('New Answer'),
                $id ? __('Edit Answer') : __('New Answer')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('Answers'));
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Answer #%1', $id) : __('New Answer')
        );

        return $resultPage;
    }
}
