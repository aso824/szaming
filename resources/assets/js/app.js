
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

    template.find('[data-select2-ajax]').select2('destroy');

    let templateNo = template.data('rowId');
    let clone = template.clone();

    clone.attr('data-row-id', nextOrderPositionNumber);

    clone.find('input,select').each(function() {
        if (undefined !== $(this).attr('name')) {
            $(this).attr('name', $(this).attr('name').replace('[' + templateNo + ']', '[' + nextOrderPositionNumber + ']'))
                .val('');
        }

        if (undefined !== $(this).attr('id')) {
            $(this).attr('id', $(this).attr('id').replace('-' + templateNo, '-' + nextOrderPositionNumber));
        }

        if (undefined !== $(this).attr('data-select2-id')) {
            $(this).attr('data-select2-id', $(this).attr('data-select2-id').replace('-' + templateNo, '-' + nextOrderPositionNumber));
        }
    });

    container.append(clone);

    createSelect2(clone.find('[data-select2-ajax]'));
    createSelect2(template.find('[data-select2-ajax]'));

    nextOrderPositionNumber++;
    $('.removeOrderPosition').css('visibility', 'visible');
});

$(document).on('click', '.removeOrderPosition', function() {
    if ($('.orderRow').length === 2) {
        $('.removeOrderPosition').css('visibility', 'hidden');
    }

    $(this).closest('.orderRow').remove();
});

function createSelect2(obj) {
    obj.select2({
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
}

$(document).ready(function() {
    $('[data-select2-ajax]').each(function (index, el) {
        createSelect2($(el));
    });
});
