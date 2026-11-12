// <script src="https://js.stripe.com/v3/"></script> 



    var stripe_key = "pk_test_51LJXJiHu8oVB4xqL0tsiGVqyTIVUuuXrQfAwPDHBHmLrePhUB8nlGdFxQESn5GX5zYH9q43GdKAfDdemvnnAdwLW006tuRJezd";
    function pay(){
        var amount = $('#sale_amount').val(); 
          var handler = StripeCheckout.configure({
          key:stripe_key, // your publisher key id
          locale: 'us',
          token: function (token) {
          // You can access the token ID with `token.id`.
          // Get the token ID to your server-side code for use.
          $('#payment_method').val('stripe')
          $('#payment_id').val(token.id)
          $('#payer_id').val(token.card.id)
          $('#paid_amount').val(amount)
          $('#last_digit').val(token.card.last4)
          $('#form').submit() 
          //$('#token_response').html(JSON.stringify(token));  
          }
          });
          handler.open({
          name: 'Payment Terminal',
          description: 'Pay with Stripe',
          amount: amount
          });
    }

