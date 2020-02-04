// datatables
var selections = [];

function initTable() {
    $('.vtbl').each(function (i, item) {
        var id = $(item).attr('id');
        $table = $('#' + id);
        selections[id] = [];
        $table.bootstrapTable({
            detailFormatter: detailFormatter,
            iconsPrefix: 'font-icon',
            queryParams: function (params) {
                let arrkey = [];
                $.each($('#form-' + id).serializeArray(), function (k, v) {

                    let name = v.name;
                    if (name.indexOf("[]") !== -1) {
                        let names = name.split("[]");
                        if (arrkey[name] === undefined) {
                            arrkey[name] = 0;
                        }
                        params[names[0] + "[" + arrkey[name] + "]"] = v.value;
                        arrkey[name]++;
                    } else {
                        params[name] = v.value;
                    }

                });
                return params;
            },
            icons: {
                paginationSwitchDown: 'font-icon-arrow-square-down',
                paginationSwitchUp: 'font-icon-arrow-square-down up',
                refresh: 'font-icon-refresh',
                toggle: 'font-icon-list-square',
                columns: 'font-icon-list-rotate',
                export: 'font-icon-download',
                detailOpen: 'font-icon-plus',
                detailClose: 'font-icon-minus-1'
            },
            paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
            paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
        });
        // sometimes footer render error.
        setTimeout(function () {
            $table.bootstrapTable('resetView');
        }, 100);
        $table.on('check.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table', function () {
            var totalSelect = $table.bootstrapTable('getSelections').length;
            $('.btn-actions').prop('disabled', !totalSelect);
            $('.' + id + '-slct-total').text(totalSelect);
            selections[id] = getIdSelections($table);
        });

        $table.on('load-error.bs.table', function (x, y) {
            if (y === 503) {
                location.reload(true);
            }
        });
    });
}

function getIdSelections($table) {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
        return row.id
    });
}

function detailFormatter(index, row) {
    var html = [];
    $.each(row.detailFormatter, function (key, value) {
        var title = key == 0 ? '' : '<b>' + key + ':</b> ';
        html.push('<p>' + title + value + '</p>');
    });
    return html.join('');
}

window.operateEvents = {
    'click .like': function (e, value, row, index) {
        alert('You click like action, row: ' + JSON.stringify(row));
    },
    'click .remove': function (e, value, row, index) {
        $table.bootstrapTable('remove', {
            field: 'id',
            values: [row.id]
        });
    }
};

function bgColorSetter(value, row, index, field) {
    if (field === undefined && ("bgColor" in row)) {
        return {css: {"background-color": row.bgColor}};
    } else {
        return false;
    }
}

// block loading
function LoadBlock(container, message) {
    $(container).block({
        message: message
    });
}

// notifications
PNotify.prototype.options.styling = "bootstrap3";

function notify(title, text, type, icon) {
    new PNotify({
        title: title,
        text: text,
        type: type,
        icon: icon,
        addclass: 'alert-with-icon'
    });
}

$('.filter-reset').on('click', function (e) {
    let select2 = $(this).closest('form').find('[data-class="select2"]');
    select2.val("").trigger('change.select2');
});


function clearErrorField(field) {
    field = field.replace('[]', '');
    $('.' + field).removeClass('error');
}

$(function () {
    initTable();

    $('body').on('click', '[data-toggle="modal"]', function () {
        $($(this).data("target") + ' .modal-content').load($(this).attr("href"));
    });

    function cb(start, end) {
        let element = this.element.closest('.input-group').find('input');
        element.val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        clearErrorField(this.element.attr('name'));
    }

    $('.daterange').daterangepicker({
        "linkedCalendars": false,
        "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "showDropdowns": true,
    }, cb);


    function cb2(start, end) {
        let element = this.element.closest('.input-group').find('input');
        element.val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        clearErrorField(this.element.attr('name'));
    }

    $('form input, form [data-class="select2"]').on('keypress, keyup, change', function (e) {
        clearErrorField($(this).attr('name'));
    });
});
