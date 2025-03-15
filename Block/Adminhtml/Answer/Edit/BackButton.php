<?php

declare(strict_types=1);

namespace MarkShust\ProductQA\Block\Adminhtml\Answer\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

class BackButton implements ButtonProviderInterface
{
    /**
     * @param Context $context
     */
    public function __construct(
        private readonly Context $context,
    ) {}

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    /**
     * Get URL for back button
     *
     * @return string
     */
    public function getBackUrl(): string {
        return $this->context->getUrlBuilder()->getUrl('*/*/');
    }
}
