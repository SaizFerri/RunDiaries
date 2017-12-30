$(document).ready(function() {
    $('input').val('');
});

$('.js-toggle-form').click(function() {
    $('.my-form').toggleClass('is-hidden');
    $('.js-toggle-form').toggleClass('is-fixed-bottom');
});
