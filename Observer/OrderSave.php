<?php

namespace BethlehemIT\AdditionalInvoiceEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\QuoteRepository;

/**
 * Class SetOrderAttributes
 */
class OrderSave implements ObserverInterface
{
    /**
     * OrderSave constructor.
     *
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(
        private readonly QuoteRepository $quoteRepository
    ) {
    }

    /**
     * Sets invoice email on order from quote
     *
     * @param  Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();

        try {
            $quote = $this->quoteRepository->get($order->getQuoteId());
        } catch (NoSuchEntityException $e) {
            return $this;
        }

        if ($quote->getEmailInvoice() && $order->getCustomerEmail() !== $quote->getEmailInvoice()) {
            $order->setEmailInvoice($quote->getEmailInvoice());
        }

        return $this;
    }
}
