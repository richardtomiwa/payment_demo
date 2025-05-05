
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAYSTACK</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form id="paymentForm">
    <div class="form-submit">
      <button type="submit" onclick="payWithPaystack()"> Pay </button>
    </div>
  </form>

  <?php
  include 'configs.php';
  $email = "richardfiverr5@gmail.com";
  $amount = 1000;
  $currency = "NGN";
  ?>

  <script type="text/javascript">
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
      e.preventDefault();
      let handler = PaystackPop.setup({
        key: '<?php echo $PublicKey; ?>', // Replace with your public key
        email: '<?php echo $email; ?>',
        amount: <?php echo $amount; ?> * 100,
        currency: '<?php echo $currency; ?>', // Use GHS for Ghana Cedis or USD for US Dollars or KES for Kenya Shillings
        metadata: {
          custom_fields: [
            {
            display_name:"Mobile Number",
            variable_name:"mobile_number",
            value:"+2349138163420"
            }
          ]
        },
      
        // label: "Optional string that replaces customer email"
        onClose: function() {
          alert('Transaction was not completed, window closed.');
        },
        callback: function(response) {
          let message = 'Payment complete! Reference: ' + response.reference;
          alert(message);
          window.location.href = "https://0vtxht40-80.uks1.devtunnels.ms/PAYMENT_DEMO/verify_transaction.php?reference=" + response.reference;
        }
      });

      handler.openIframe();
    }
  </script>

  <script src="https://js.paystack.co/v1/inline.js"></script>
</body>

</html>
