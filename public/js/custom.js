$(document).ready(function() {
    $('input').val('');

    $('.js-toggle-form span').on('click', function() {
        $('.my-form').addClass('is-hidden');
    });

    $('.my-add-btn').on('click', function() {
        $('.my-form').removeClass('is-hidden');
    });

});
