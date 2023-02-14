(function ($) {

    /**
     * This helper manages custom preview mode for product reviews form
     */
    FLBuilder.registerModuleHelper('fl-bc-product-reviews', {

        /**
         * current state of review form
         */
        showing: false,

        /**
         * Settings form opened.
         */
        init: function () {
            this._setupInitialState();
            this._bindSelect();
        },

        /**
         * Set up the initial preview state for the review form.
         * @private
         */
        _setupInitialState: function() {
            this.showing = ($('select[name=bc_show_review_form]').val() === "show");
            this._showReviewForm();
        },

        /**
         * Bind the change event on the review form select
         * @private
         */
        _bindSelect: function() {
            $('select[name=bc_show_review_form]').on('change', $.proxy(this._stateChanged, this));
        },

        /**
         * Fired on change event from review form select
         *
         * @param event
         * @private
         */
        _stateChanged: function(event) {
            this.showing = (event.target.value === "show");
            this._showReviewForm()
        },


        /**
         * Toggles display of review form
         *
         * @param show
         * @private
         */
        _showReviewForm: function () {

            var writeBtnSelector = FLBuilder.preview.classes.node + " .bc-product-review__write-btn";
            var closeBtnSelector = FLBuilder.preview.classes.node + " .bc-product-review__cancel-write-btn";

            if (this.showing) {
                $(writeBtnSelector).click();
            } else {
                $(closeBtnSelector).click();
            }
        }
    });

})(jQuery);
