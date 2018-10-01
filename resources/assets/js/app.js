
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'select2';

if ($('#addOrderPosition').length) {
    var nextOrderPositionNumber = 1;
}

$('#addOrderPosition').click(function() {
    let template = $('.orderRow:first');
    let container = $('#orderPositions');

    let clone = template.clone();
    clone.attr('data-row-id', nextOrderPositionNumber);
    clone.find('input').each(function() {
        $(this).attr('name', $(this).attr('name').replace('[0]', '[' + nextOrderPositionNumber + ']'))
               .val('');
    });

    container.append(clone);

    nextOrderPositionNumber++;
    $('.removeOrderPosition').css('visibility', 'visible');
});

$(document).on('click', '.removeOrderPosition', function() {
    if ($('.orderRow').length === 2) {
        $('.removeOrderPosition').css('visibility', 'hidden');
    }

    $(this).closest('.orderRow').remove();
});

$(document).ready(function() {
    $('[data-select2-ajax]').select2({
        ajax: {
            url: function (){
                return $(this).data('select2Ajax');
            },
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: Object.keys(data).map(function(key) {
                        return {id: key, text: data[key]};
                    })
                };
            },
        },
        tags: $(this).data('select2Tags') === 'true'
    });
});
