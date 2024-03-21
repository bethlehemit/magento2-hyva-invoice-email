<?php

namespace BethlehemIT\AdditionalInvoiceEmail\Plugin;

use Fooman\PdfCustomiser\Block\Pdf\AddressFormatter as Subject;

class AddressFormatterPlugin
{
    public function afterGetBillingAddress(Subject $subject, $result, $order)
    {
        if ($order->hasEmailInvoice()) {
            $result .= '<br/>' . __("Invoice email") . ": " . $order->getEmailInvoice();
        }

        return $result;
    }
}
