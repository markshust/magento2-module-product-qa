<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Controller\Adminhtml\Answer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use MarkShust\ProductQA\Api\Data\AnswerInterfaceFactory;
use MarkShust\ProductQA\Api\AnswerRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'MarkShust_ProductQA::answers';

    /**
     * @param Context $context
     * @param AnswerRepositoryInterface $answerRepository
     * @param AnswerInterfaceFactory $answerFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        private readonly AnswerRepositoryInterface $answerRepository,
        private readonly AnswerInterfaceFactory $answerFactory,
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
            // If answer_id is an empty string or "0", set it to null
            if (isset($data['answer_id']) && (empty($data['answer_id']) || $data['answer_id'] === '0')) {
                $data['answer_id'] = null;
            }

            try {
                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model = $this->answerRepository->getById($id);
                } else {
                    $model = $this->answerFactory->create();
                }

                $model->setData($data);
                $this->answerRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the answer.'));
                $this->dataPersistor->clear('productqa_answer');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the answer.'));
            }

            $this->dataPersistor->set('productqa_answer', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
