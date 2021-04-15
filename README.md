# paymentnepal-amiro

Installation guide for Paymentnepal AmiroCSM plugin

For correct plugin work you need to:

1. Copy paymentnepal catalogue to _local/eshop/pay_drivers.

2. In the "Service: System settings: Payment methods" set Paymentnepal driver.  
 (http://yoursite/_admin/pay_drivers.php)

3. Open it in write mode and set payment key and secret key (can be obtained from service settings inside Paymentnepal merchant area)

4. In "Goods catalogue: Orders" enable Paymentnepal payment driver.

5. Set next values in your service settings inside Paymentnepal merchane area:

* URL success: http://yoursite/members/order?action=process&status=ok
* URL error: http://yoursite/members/order?action=process&status=fail
* URL notification: http://yoursite/eshop_final.php
