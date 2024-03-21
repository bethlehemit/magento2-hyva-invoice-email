<?php

namespace BethlehemIT\AdditionalInvoiceEmail\Model;

use Magento\Sales\Model\Order\Email\Sender\InvoiceSender as Subject;
use Magento\Sales\Model\Order\Invoice;

class InvoiceSender extends Subject
{
    /**
     * @param  Invoice $invoice
     * @param  $forceSyncMode
     * @return bool
     * @throws \Exception
     */
    public function send(Invoice $invoice, $forceSyncMode = false)
    {
        $result = parent::send($invoice, $forceSyncMode);

        $order = $invoice->getOrder();
        if ($order->getEmailInvoice()) {
            $originalEmail = $order->getCustomerEmail();
            $order->setCustomerEmail($order->getEmailInvoice());
            parent::send($invoice, $forceSyncMode);
            $order->setCustomerEmail($originalEmail);
        }

        return $result;
    }
}
