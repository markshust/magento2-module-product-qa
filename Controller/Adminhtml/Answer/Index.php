<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Answer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::answers';

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
    ) {
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MarkShust_ProductQA::answers');
        $resultPage->addBreadcrumb(__('Product Q&A'), __('Product Q&A'));
        $resultPage->addBreadcrumb(__('Answers'), __('Answers'));
        $resultPage->getConfig()->getTitle()->prepend(__('Product Answers'));

        return $resultPage;
    }
}
