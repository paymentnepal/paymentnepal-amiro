<?php

class Paymentnepal_PaymentSystemDriver extends AMI_PaymentSystemDriver{

    /**
     * Get checkout button HTML form
     *
     * @param array $aRes Will contain "error" (error description, 'Success by default') and "errno" (error code, 0 by default). "forms" will contain a created form
     * @param array $aData The data list for button generation
     * @param bool $bAutoRedirect If form autosubmit required (directly from checkout page)
     * @return bool true if form is generated, false otherwise
     */
    public function getPayButton(&$aRes, $aData, $bAutoRedirect = false){
        // Format fields
        foreach(Array("return", "description") as $fldName){
            $aData[$fldName] = htmlspecialchars($aData[$fldName]);
        }

        //Unset parameters that are not supposed to be shown
        if(isset($aData["secret_key"])){
            unset($aData["secret_key"]);
        }

        $hiddens = '';
        foreach ($aData as $key => $value) {
            $hiddens .= '<input type="hidden" name="' . $key . '" value="' . (is_null($value) ? $aData[$key] : $value) .'" />' . "\n";
        }
        $aData['hiddens'] = $hiddens;

        return parent::getPayButton($aRes, $aData, $bAutoRedirect);
    }
    
    /**
     * Get the form that will be autosubmitted to payment system. This step is required for some shooping cart actions.
     *
     * @param array $aData The data list for button generation
     * @param array $aRes Will contain "error" (error description, 'Success by default') and "errno" (error code, 0 by default). "forms" will contain a created form
     * @return bool true if form is generated, false otherwise
     */
    public function getPayButtonParams($aData, &$aRes){
        //Unset parameters that are not supposed to be shown
        $data =$aData;
        if(isset($вata["secret_key"])){
            unset($data["secret_key"]);
        }
        $data['payment_url'] = "https://pay.paymentnepal.com/alba/input";
/*        //Set desired currency and correct price
        $current_currency = $aData["currency"];
        //how to get rate?
        $exchange_rate = 1;
        $aData["amount"] = $aData["amount"]*$exchange_rate;
        */
        $aRes["error"] ="Success";
        $aRes["errno"] =0;

        return parent::getPayButtonParams($data, $aRes);
    }

    /**
     * Verify the order from user back link. In success case 'accepted' status will be setup for order.
     *
     * @param array $aGet $_GET data
     * @param array $aPost $_POST data
     * @param array $aRes reserved array reference
     * @param array $aCheckData Data that provided in driver configuration
     * @param array $aOrderData order data that contains such fields as id, total, order_date, status
     * @return bool true if order is correct and false otherwise
     * @see AMI_PaymentSystemDriver::payProcess(...)
     */
    public function payProcess($aGet, $aPost, &$aRes, $aCheckData){
        
        return parent::payProcess($aGet, $aPost, $aRes, $aCheckData);
    }

    /**
     * Verify the order by payment system background responce. In success case 'confirmed' status will be setup for order.
     *
     * @param array $aGet $_GET data
     * @param array $aPost $_POST data
     * @param array $aRes reserved array reference
     * @param array $aCheckData Data that provided in driver configuration
     * @param array $aOrderData order data that contains such fields as id, total, order_date, status
     * @return int -1 - ignore post, 0 - reject(cancel) order, 1 - confirm order
     * @see AMI_PaymentSystemDriver::payCallback(...)
     */
    public function payCallback($aGet, $aPost, &$aRes, $aCheckData, $aOrderData){
        //Sort parameters in required order
        $parameters = array (
            $aPost["tid"],
            urldecode($aPost["name"]),
            $aPost["comment"],
            $aPost["partner_id"],
            $aPost["service_id"],
            $aPost["order_id"],
            $aPost["type"],
            $aPost["partner_income"],
            $aPost["system_income"],
            $aPost["test"],
            $aCheckData["secret_key"],
        );

        //Get check from POST
        $given_check = $aPost["check"];

        //Generate check from parameters above
        $generated_check = md5(join('',$parameters));

        //Verify checks. Verify prices.
        if ($given_check === $generated_check){
            if ($aOrderData["total"] == $aPost["system_income"]){
                $status = 1;
            } else $status = 0;
        } else $status = 0;

        return $status;
//        return parent::payCallback($aGet, $aPost, &$aRes, $aCheckData, $aOrderData);
    }

    /**
     * Return real system order id from data that provided by payment system.
     *
     * @param array $aGet $_GET data
     * @param array $aPost $_POST data
     * @param array $aRes reserved array reference
     * @param array $aAdditionalParams reserved array
     * @return int order Id
     * @see AMI_PaymentSystemDriver::getProcessOrder(...)
     */
    public function getProcessOrder($aGet, $aPost, &$aRes, $aAdditionalParams){
        return parent::getProcessOrder($aGet, $aPost, $aRes, $aAdditionalParams);
    }
}
