define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).on('click', '.answer-toggle', function() {
            $(this).next('.answer-form').slideToggle();
        });
    };
});
