$(document).ready(function() {
    $('input').val('');

    $('.my-form').addClass('is-hidden');

    $('.js-toggle-form span').on('click', function() {
        $('.my-form').addClass('is-hidden');
    });

    $('.my-add-btn').on('click', function() {
        $('.my-form').removeClass('is-hidden');
    });

});
