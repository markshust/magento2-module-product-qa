<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use MarkShust\ProductQA\Api\Data\QuestionInterfaceFactory;
use MarkShust\ProductQA\Api\QuestionRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::questions';

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionInterfaceFactory $questionFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly QuestionInterfaceFactory $questionFactory,
        private readonly DataPersistorInterface $dataPersistor,
    ) {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (isset($data['question_id']) && (empty($data['question_id']) || $data['question_id'] === '0')) {
                $data['question_id'] = null;
            }

            try {
                if ($id = $this->getRequest()->getParam('id')) {
                    $model = $this->questionRepository->getById($id);
                } else {
                    $model = $this->questionFactory->create();
                }

                $model->setData($data);
                $this->questionRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the question.'));
                $this->dataPersistor->clear('productqa_question');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the question.'));
            }

            $this->dataPersistor->set('productqa_question', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
