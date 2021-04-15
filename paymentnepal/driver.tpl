%%include_language "_local/eshop/pay_drivers/paymentnepal/driver.lng"%%

<!--#set var="settings_form" value="
    <tr>
        <td>%%rfi_key%%:</td>
        <td><input type="text" name="paymentnepal_key" class="field" value="##paymentnepal_key##"></td>
    </tr>
    <tr>
        <td>%%secret_key%%:</td>
        <td><input type="text" name="secret_key" class="field" value="##secret_key##"></td>
    </tr>
"-->

<!--#set var="checkout_form" value="
    <form name="paymentformpaymentnepal" action="##process_url##" method="POST">
    <input type="hidden" name="key" value="##paymentnepal_key##">
    <input type="hidden" name="cost" value="##amount##">
    <input type="hidden" name="default_email" value="##email##"> 
    <input type="hidden" name="order_id" value="##order_id##">
	##hiddens##
    <input type="submit" name="sbmt" class="btn" value="%%button_caption%%" ##disabled##>
    </form>
"-->

<!--#set var="pay_form" value="
    <form name="paymentform" action="https://pay.paymentnepal.com/alba/input" method="POST">
    <input type="hidden" name="key" value="##paymentnepal_key##">
    <input type="hidden" name="cost" value="##amount##">
	<input type="hidden" name="name" value="##description##"> 
	<input type="hidden" name="default_email" value="##email##"> 
	<input type="hidden" name="order_id" value="##order_id##">
    </form>
    <script type="text/javascript">document.paymentform.submit();</script>
"-->
