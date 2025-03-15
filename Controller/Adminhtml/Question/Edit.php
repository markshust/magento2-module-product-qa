<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::questions';

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly Registry $coreRegistry,
        private readonly QuestionRepositoryInterface $questionRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * Edit question page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = (int) $this->getRequest()->getParam('id');

        try {
            $model = $this->questionRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This question no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        // Register model to use later in blocks
        $this->coreRegistry->register('productqa_question', $model);

        // Build edit form
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MarkShust_ProductQA::questions')
            ->addBreadcrumb(__('Product Q&A'), __('Product Q&A'))
            ->addBreadcrumb(__('Questions'), __('Questions'))
            ->addBreadcrumb(
                $id ? __('Edit Question') : __('New Question'),
                $id ? __('Edit Question') : __('New Question')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('Questions'));
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Question #%1', $id) : __('New Question')
        );

        return $resultPage;
    }
}
