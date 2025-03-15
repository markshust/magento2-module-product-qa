<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Block\Adminhtml\Answer\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class DeleteButton implements ButtonProviderInterface
{
    /**
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        private readonly Context $context,
        private readonly Registry $registry,
    ) {}

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];

        if ($this->getAnswerId()) {
            $data = [
                'label' => __('Delete Answer'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to delete this answer?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['id' => $this->getAnswerId()]);
    }

    /**
     * Get Answer ID
     *
     * @return int|null
     */
    public function getAnswerId(): ?int
    {
        $answer = $this->registry->registry('productqa_answer');

        return $answer ? (int) $answer->getId() : null;
    }
}
