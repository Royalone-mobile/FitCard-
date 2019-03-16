var Payment = {

    /**
     * Payment token as received from server
     */
    paymentToken: null,

    /**
     * Initialize object & listeners
     */
    init: function () {
        $('#credit-card-form').submit(this.makePayment);
    },

    /**
     * Make payment using data from form
     */
    makePayment: function (event) {

        $('body').addClass("loading");
        event.preventDefault();

        var chargeRequest = $.get("/api/v1/payment/create_charge/" + $('input[name="plan_id"]').val());
        chargeRequest.done(Payment.chargeRequestDone);
        chargeRequest.error(function (d) {
            sweetAlert("Error while processing payment, please refresh the page and try again.");
            $('body').removeClass("loading");
            return null;
        });

        return false;
    },

    /**
     * After charge request created
     *
     * @param data
     */
    chargeRequestDone: function (data) {

        Payment.paymentToken = data.token;

        var request = $.post(data.payment_url, {
            "token": data.token,
            "card": $('input[name="cardNumber"]').val(),
            "amount": data.amount,
            "currency": data.currency,
            "exp_month": $('select[name="expMonth"]').val(),
            "exp_year": $('select[name="expYear"]').val(),
            "security_code": $('input[name="cvv"]').val()
        });
        request.done(Payment.paymentDone);
        request.error(function (d) {
            sweetAlert("Error while processing payment, please refresh the page and try again.");
            $('body').removeClass("loading");
        });
    },

    /**
     * After payment done via external gateway
     *
     * @param data
     */
    paymentDone: function (data) {
        if ($.parseJSON(data).result == 1) {
            sweetAlert("Error while processing payment, please refresh the page and try again.");
            $('body').removeClass("loading");
            return false;
        }

        var check_request = $.post('/api/v1/payment/check_successful', {'payment_token': Payment.paymentToken});

        check_request.done(function (result) {
            if (result.success == true) {
                document.location.href = '/consumer/payment/plans';
            } else {
                sweetAlert("Error while finalizing payment.");
            }

            $('body').removeClass("loading");
        });
    },

    /**
     * Show loading overlay
     */
    showLoading: function () {
        $('body').addClass("loading");
    },

    /**
     * Hide loading overlay
     */
    hideLoading: function () {
        $('body').removeClass("loading");
    }
};

$(function () {
    Payment.init();
});
