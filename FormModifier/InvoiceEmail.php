<?php

namespace BethlehemIT\AdditionalInvoiceEmail\FormModifier;

use Hyva\Checkout\Model\Form\EntityFormInterface;
use Hyva\Checkout\Model\Form\EntityFormModifierInterface;
use Magento\Checkout\Model\Session as SessionCheckout;

class InvoiceEmail implements EntityFormModifierInterface
{
    /**
    * @param SessionCheckout $sessionCheckout
    */
    public function __construct(
        protected readonly SessionCheckout $sessionCheckout
    ) {
    }

    public function apply(EntityFormInterface $form): EntityFormInterface
    {
        $form->registerModificationListener(
            'saveInvoiceEmail',
            'form:billing:email_invoice:updated',
            [$this, 'saveInvoiceEmail']
        );

        return $form;
    }

    public function saveInvoiceEmail(EntityFormInterface $form): EntityFormInterface
    {
        $field = $form->getField("email_invoice");
        if ($field && $field->getValue() !== null) {
            $quote = $this->sessionCheckout->getQuote();
            $quote->setEmailInvoice($field->getValue());
        }

        return $form;
    }
}
