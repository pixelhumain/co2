## Cart interface 
- shopping.checkout() :: show CC interafce 
- shopping.buyCart() :: proceed to payment with given CC data 

## Controllers
- /pay : shows the user the paying interface
    + IndexAction
        + renders views/with_js

- pay/done : executes the payment when CC validated
    + 