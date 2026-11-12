<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{ asset('admin/dist/vendors/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/toastr.script.js') }}"></script>
<script type="text/javascript">
    (function($) {
        "use strict";
        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-right",
            "closeButton": true,
            "progressBar": true
        };
    })(jQuery);
</script>
@yield('scripts')
<script>
    
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    const clearButton = document.getElementById('clearButton');
    const saveButton = document.getElementById('saveButton');
    const signatureBase64 = document.getElementById('signatureBase64');
    const proceedButton = document.getElementById('proceedButton');
    const exampleCheck1 = document.getElementById('exampleCheck1');
    var order_id = "{{ $order->id }}";
    const emptySignature = 'data:image/png;base64,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';

    let drawing = false;
    let isSigned = true;      // To track if the canvas has been signed
    let ajaxSuccess = false;   // To track if the signature was saved successfully
    let areFieldsValid = false;  // Tracks whether all form fields are valid
    let isSignatureSaved = true; // Tracks whether the signature was successfully saved via AJAX

    // Function to resize canvas according to the screen size
    function resizeCanvas() {
        const canvasWidth = canvas.parentElement.offsetWidth; // Get parent container width
        canvas.width = canvasWidth;
        canvas.height = 200; // Adjust height as per requirement
    }

    // Call resizeCanvas() initially and on window resize
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Prevent default scrolling behavior when drawing on the canvas
    function preventScroll(e) {
        e.preventDefault();
    }

    // Event listeners for mouse/touch events
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Mobile touch events
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', draw, { passive: false });
    canvas.addEventListener('touchend', stopDrawing, { passive: false });

    // Start drawing and disable scrolling
    function startDrawing(e) {
        drawing = true;
        ctx.beginPath();
        document.body.addEventListener('touchmove', preventScroll, { passive: false }); // Disable touch scrolling
        document.body.style.overflow = 'hidden'; // Disable scroll on page
        draw(e);
    }

    // Stop drawing and re-enable scrolling
    function stopDrawing() {
        drawing = false;
        ctx.beginPath();
        isSigned = true; // Mark the canvas as signed when the user draws
        document.body.removeEventListener('touchmove', preventScroll); // Re-enable touch scrolling
        document.body.style.overflow = ''; // Re-enable scroll on page
    }
    
    // Draw on canvas 
    function draw(e) {
        if (!drawing) return;

        const rect = canvas.getBoundingClientRect();
        let x, y;

        if (e.type.includes('touch')) {
            // For touch events (mobile)
            const touch = e.touches[0];
            x = touch.clientX - rect.left;
            y = touch.clientY - rect.top;
        } else {
            // For mouse events
            x = e.clientX - rect.left;
            y = e.clientY - rect.top;
        }

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }
    
    // Clear the canvas
    $(document).on('click', '#clearSignature', function () {
        console.log('clearSignature');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        signatureBase64.value = '';
        isSigned = false;         // Reset signature completion status
        isSignatureSaved = false; // Reset signature AJAX success
        validateForm();           // Re-validate the form
    });

    // Save the signature as base64 and send it to the server
    $(document).on('click', '#saveSignature', function () {
        console.log('saveSignature');
        
        const dataURL = canvas.toDataURL();
        if (!dataURL || dataURL  === emptySignature) {
            toastr.error("Signature is required before proceeding.");
            isSigned = false;         // Mark the signature as incomplete
            isSignatureSaved = false; // Mark AJAX as failed
            validateForm();  // Re-validate the form
            return;
        }else{

            signatureBase64.value = dataURL;
    
            toastr.success("Signature saved successfully.");
            isSigned = true;         // Mark the signature as complete
            isSignatureSaved = true; // Mark AJAX success for signature
            validateForm();          // Re-validate the form
        }

        // Send base64 string to the server
        // $.ajax({
        //     url: "{{ route('signature.save') }}",
        //     method: 'POST',
        //     data: {
        //         order_id: order_id,
        //         signature: dataURL,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function (response) {
        //         toastr.success(response.message || "Signature saved successfully.");
        //         isSigned = true;         // Mark the signature as complete
        //         isSignatureSaved = true; // Mark AJAX success for signature
        //         validateForm();          // Re-validate the form
        //     },
        //     error: function (xhr) {
        //         const errorMessage = xhr.responseJSON?.message || xhr.responseText || "An error occurred.";
        //         toastr.error('Error saving signature: ' + errorMessage);
        //         isSigned = false;         // Mark the signature as incomplete
        //         isSignatureSaved = false; // Mark AJAX as failed for signature
        //         validateForm();           // Re-validate the form
        //     }
        // });
    });

    // Validate input fields on keyup or paste
    $(document).on('keyup paste', '.validate', function () {
        let allFieldsFilled = true;
        // Check if all fields with 'validate' class are filled
        $('.validate').each(function () {
            if (!$(this).val().trim()) {
                allFieldsFilled = false;
                return false; // Break loop if any field is empty
            }
        });
        console.log('Form fields filled:', allFieldsFilled);
        areFieldsValid = allFieldsFilled; // Update form fields validation state
        validateForm();                   // Re-validate the form
    });

    // Validate if the form can be submitted
    function validateForm() {
        // Ensure both signature is saved and all form fields are valid
        console.log(isSigned);
        console.log(isSignatureSaved);
        console.log(areFieldsValid);
        
        const canSubmit = isSigned && isSignatureSaved && areFieldsValid;

        if (canSubmit) {
            $('#payment-methods').show();                // Show payment methods
            $('.pay-message').css('color', 'darkgrey');  // Update message color
        } else {
            $('#payment-methods').hide();                // Hide payment methods
            $('.pay-message').css('color', 'red');       // Update message color
        }
    }

    
    $(document).ready(function($) {
        $(".card-cvc").mask("999");
        $(".card-number").mask("9999 9999 9999 9999");
        $("#phonenumber").mask("+999999999999");
    });


    ;
    (function(window, $) {
        "use strict";

        var defaultConfig = {
            type: '',
            autoDismiss: false,
            container: '#toasts',
            autoDismissDelay: 4000,
            transitionDuration: 500
        };

        $.toast = function(config) {
            var size = arguments.length;
            var isString = typeof(config) === 'string';

            if (isString && size === 1) {
                config = {
                    message: config
                };
            }

            if (isString && size === 2) {
                config = {
                    message: arguments[1],
                    type: arguments[0]
                };
            }

            return new toast(config);
        };

        var toast = function(config) {
            config = $.extend({}, defaultConfig, config);
            // show "x" or not
            var close = config.autoDismiss ? '' : '&times;';

            // toast template
            var toast = $([
                '<div class="toast ' + config.type + '">',
                '<p>' + config.message + '</p>',
                '<div class="close">' + close + '</div>',
                '</div>'
            ].join(''));

            // handle dismiss
            toast.find('.close').on('click', function() {
                var toast = $(this).parent();

                toast.addClass('hide');

                setTimeout(function() {
                    toast.remove();
                }, config.transitionDuration);
            });

            // append toast to toasts container
            $(config.container).append(toast);

            // transition in
            setTimeout(function() {
                toast.addClass('show');
            }, config.transitionDuration);

            // if auto-dismiss, start counting
            if (config.autoDismiss) {
                setTimeout(function() {
                    toast.find('.close').click();
                }, config.autoDismissDelay);
            }

            return this;
        };

    })(window, jQuery);

    /* ---- start demo code ---- */

    var count = 1;
    var types = ['default', 'error', 'warning', 'info'];

    $('button').click(function() {
        var data = this.dataset;

        switch (data.type) {
            case 'types':
                $.toast(data.kind, 'This is a ' + data.kind + ' toast.');
                break;
            case 'html':
                $.toast(
                    '<div class="custom-toast"><img src="https://dysfunc.github.io/animat.io/images/ron_burgundy.png"><p>You stay classy San Deigo</p></div>'
                    );
                break;

            case 'auto':
                $.toast({
                    autoDismiss: true,
                    message: 'This is my auto-dismiss toast message'
                });

                break;

            default:
        }
    });
</script>

@if (old('card_holder_name') != '' &&
        old('card_number') != '' &&
        old('cvv_number') != '' &&
        old('exp_month') != '' &&
        old('exp_year') != '')
    <script>
        $(document).ready(function() {
            $('#payment-methods').show();
        })
    </script>
@endif

@if (Session::has('error'))
    <script>
        $.toast("{{ Session::get('error') }}");
    </script>
@endif