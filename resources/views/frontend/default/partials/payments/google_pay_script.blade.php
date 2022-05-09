<div class="modal fade" id="gPayModal" tabindex="-1" role="dialog" aria-labelledby="JazzCashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('wallet.google_payment') }}</h5>
            </div>
            <div class="modal-body">
                <section class="send_query bg-white contact_form">
                    
                        <div class="send_query_btn d-flex justify-content-between mt-4">
                            <button type="button" class="btn_1" data-dismiss="modal">{{ __('common.cancel') }}</button>
                            <a class="btn_1 pointer" id="buyButton">{{ __('wallet.continue_to_pay') }}</a>
                        </div>
                    
                </section>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    
    <script type="text/javascript">
        const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
        const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
        if (window.PaymentRequest) {
            const request = createPaymentRequest();

            request.canMakePayment()
            .then(function(result) {
                if (result) {
                // Display PaymentRequest dialog on interaction with the existing checkout button
                document.getElementById('buyButton')
                .addEventListener('click', onBuyClicked);
                }
            })
            .catch(function(err) {
                showErrorForDebugging(
                'canMakePayment() error! ' + err.name + ' error: ' + err.message);
            });
        } else {
            showErrorForDebugging('PaymentRequest API not available.');
        }

        /**
        * Show a PaymentRequest dialog after a user clicks the checkout button
        */
        function onBuyClicked() {
            createPaymentRequest()
              .show()
              .then(function(response) {
                // Dismiss payment dialog.
                response.complete('success');
                console.log(response);
                console.log(response.requestId);
                // handlePaymentResponse(response);
                storeData(response.requestId);
              })
              .catch(function(err) {
                showErrorForDebugging(
                    'show() error! ' + err.name + ' error: ' + err.message);
              });
        }

        /**
        * Define your unique Google Pay API configuration
        *
        * @returns {object} data attribute suitable for PaymentMethodData
        */
        function getGooglePaymentsConfiguration() {
            return {
                environment: '{{ env('GOOGLE_PAY_ENVIRONMENT') }}',
                apiVersion: 2,
                apiVersionMinor: 0,
                merchantInfo: {
                      // A merchant ID is available after approval by Google.
                      // 'merchantId':'12345678901234567890',
                      merchantName: '{{ env('GOOGLE_PAY_MERCHANT_NAME') }}'
                },
                allowedPaymentMethods: [{
                  type: 'CARD',
                  parameters: {
                    allowedAuthMethods: allowedCardAuthMethods,
                    allowedCardNetworks: allowedCardNetworks
                  },
                  tokenizationSpecification: {
                    type: 'PAYMENT_GATEWAY',
                    // Check with your payment gateway on the parameters to pass.
                    // @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway}
                    parameters: {
                      'gateway': '{{ env('GOOGLE_PAY_GATEWAY') }}',
                      'gatewayMerchantId': '{{ env('GOOGLE_PAY_MERCHANT_ID') }}'
                    }
                  }
                }]
            };
        }

        /**
        * Create a PaymentRequest
        *
        * @returns {PaymentRequest}
        */
        function createPaymentRequest() {
            // Add support for the Google Pay API.
            const methodData = [{
                supportedMethods: 'https://google.com/pay',
                data: getGooglePaymentsConfiguration()
            }];
            // Add other supported payment methods.
            methodData.push({
                supportedMethods: 'basic-card',
                data: {
                  supportedNetworks:
                      Array.from(allowedCardNetworks, (network) => network.toLowerCase())
                }
            });

            const details = {
                total: {label: 'Test Purchase', amount: {currency: 'USD', value: '{{ $grandtotal }}'}}
            };

            const options = {
                requestPayerEmail: true,
                requestPayerName: true
            };

            return new PaymentRequest(methodData, details, options);
        }

        /**
        * Process a PaymentResponse
        *
        * @param {PaymentResponse} response returned when a user approves the payment request
        */
        function handlePaymentResponse(response) {
            const formattedResponse = document.createElement('pre');
            formattedResponse.appendChild(
              document.createTextNode(JSON.stringify(response.toJSON(), null, 2)));
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', formattedResponse);
        }

        /**
        * Display an error message for debugging
        *
        * @param {string} text message to display
        */
        function showErrorForDebugging(text) {
            const errorDisplay = document.createElement('code');
            errorDisplay.style.color = 'red';
            errorDisplay.appendChild(document.createTextNode(text));
            const p = document.createElement('p');
            p.appendChild(errorDisplay);
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', p);
        }

        function storeData(el)
        {
            $.post('{{ route('googlePay.payment_status') }}', {_token:'{{ csrf_token() }}', purpose:'order_payment', amount:'{{ $grandtotal }}', requestId:el}, function(data){
               if(data == 0){
                   toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                   location.reload()
               }
               else{
                toastr.success("{{__('common.transaction_successfully')}}","{{__('common.success')}}")
                   location.replace(data);
               }
           });
        }
    </script>
@endpush
