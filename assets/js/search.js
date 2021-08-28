jQuery(function ($) {

// -----------------------------------------------
// --- Filter
// -----------------------------------------------

    // Filter toggle second level filter (open second level tree item)
    $('#search-filter').on('click', '.toggle-second-level', function (e) {
        $(this).parent().toggleClass('is--open');
    });


    // Filter toggle
    $('.list-filter-close').on('click', function (e) {
        e.preventDefault();
        $('.content-block-list-filter').removeClass('is--open');
    });

    $('#search-result').on('click', '.list-filter-open', function (e) {
        e.preventDefault();
        $('.content-block-list-filter').addClass('is--open');
    });

    // -- make filter span-checkboxes clickable
    function addFilterCheckboxEventListener() {
        $('#search-filter').on('click','#filter .form-check span', function (e) {
            if ($(e.target).siblings('input').is(':disabled')) {
                return;
            }
            if ($(e.target).siblings('input').is(':checked')) {
                $(e.target).siblings('input').prop('checked', false).trigger('change');
            } else {
                $(e.target).siblings('input').prop('checked', true).trigger('change');
            }
        });
    }

    addFilterCheckboxEventListener();


// -------------------------------------------------
// --- Daterangepicker
// -------------------------------------------------

    if ($('[data-type="daterange"]').length > 0) {


        let easterDate = theEasterDate(dayjs().year());
        if(easterDate.isBefore(dayjs())){
            easterDate = theEasterDate(dayjs().add(1, 'year').year());
        }

        let pfingstenDate = theEasterDate(dayjs().year()).add(49, 'days');
        if(pfingstenDate.isBefore(dayjs())){
            pfingstenDate = theEasterDate(dayjs().add(1, 'year').year()).add(49, 'days');
        }

        let rosenmontagDate = theEasterDate(dayjs().year()).subtract(48, 'days');
        if(rosenmontagDate.isBefore(dayjs())){
            rosenmontagDate = theEasterDate(dayjs().add(1, 'year').year()).subtract(48, 'days');
        }


        let picker = $('[data-type="daterange"]').daterangepicker({
            "ranges": {
                'Heute': [dayjs(), dayjs()],
                'Abreise in 30 Tagen': [dayjs().add(30, 'days'), dayjs().add(1, 'month')],
                'Abreise in 60 Tagen': [dayjs().add(60, 'days'), dayjs().add(1, 'month')],
                'in diesem Monat': [dayjs().startOf('month'), dayjs().endOf('month')],
                'über Rosenmontag': [rosenmontagDate.subtract(7, 'days'), rosenmontagDate.add(7, 'days')],
                'über Ostern': [easterDate.subtract(7, 'days'), easterDate.add(7, 'days')],
                'über Pfingsten': [pfingstenDate.subtract(7, 'days'), pfingstenDate.add(7, 'days')],
                'über Weihnachten': [dayjs().date(15).month(11), dayjs().date(15).month(11).add(1, 'month')],
                'über Silvester': [dayjs().date(25).month(11), dayjs().date(10).month(11).add(1, 'month')],
                'im nächsten Monat': [dayjs().add(1, 'month').startOf('month'), dayjs().add(1, 'month').endOf('month')],
            },
            "showWeekNumbers": false,
            "autoUpdateInput": false,
            "alwaysShowCalendars": true,
            "showDropdowns": true,
            "minDate": $('[data-type="daterange"]').data('mindate'),
            "maxDate": $('[data-type="daterange"]').data('maxdate'),
            "showCustomRangeLabel": false,
            // "autoApply": true,
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Auswahl übernehmen",
                "fromLabel": "Von",
                "toLabel": "Bis",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "So",
                    "Mo",
                    "Di",
                    "Mi",
                    "Do",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "Januar",
                    "Februar",
                    "März",
                    "April",
                    "Mai",
                    "Juni",
                    "Juli",
                    "August",
                    "September",
                    "Oktober",
                    "November",
                    "Dezember"
                ],

                "firstDay": 1,
                "buttonClasses": "btn btn-outline-secondary btn-block",
                "applyButtonClasses": "btn btn-outline-secondary btn-block",
                "cancelClass": "btn-default",
                "cancelLabel": '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>'
            },
            /*
            "startDate": dayjs().startOf('hour'),
            "endDate": dayjs().startOf('hour').add(64, 'hour')
            */
        }, function (start, end, label) {
            if ($(window).width() <= 767) {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('.travelshop-datepicker').offset().top - 83
                }, 500);
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });


        $('[data-type="daterange"]').on('apply.daterangepicker', function (ev, picker) {

            $(this).val(picker.startDate.format('DD.MM.') + ' - ' + picker.endDate.format('DD.MM.YYYY'));

            // build the a pm ready query string
            $(this).data('value', picker.startDate.format('YYYYMMDD') + '-' + picker.endDate.format('YYYYMMDD'));

            $(this).trigger('change');
        });


        $('[data-type="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            $(this).data('value', '');
            $(this).trigger('change');
        });

        document.addEventListener("DOMContentLoaded", function (event) {
            $('.travelshop-datepicker-input').on('click', function () {
                $('.daterangepicker select').prettyDropdown({
                    height: 30
                });
            });
            $('.monthselect').on('change', function () {
                $('.daterangepicker select').prettyDropdown({
                    height: 30
                });
            });
        });

        // -- show/hide clear button in datepicker
        $('.travelshop-datepicker-input').on('change', function (e) {
            if ($(e.target).val() != '') {
                $(e.target).parent().siblings('.datepicker-clear').show();
            } else {
                $(e.target).parent().siblings('.datepicker-clear').hide();
            }
        });

    }

// -- offcanvas
    var $offcanvasToggle = $('.offcanvas-toggler'),
        $offcanvasBackdrop = $('#offanvas-backdrop'),
        $offcanvasClose = $('.offcanvas-close');

    $offcanvasToggle.unbind('click');

    $offcanvasToggle.on('click', function (e) {
        e.preventDefault();

        // -- trigger modal.
        $offcanvasBackdrop.modal('show');

        var $target = $($(this).data('target'));

        $target.addClass('is--open');

        e.stopPropagation();
    });

    $offcanvasBackdrop.unbind('click');

    $offcanvasBackdrop.on('click', function (e) {
        e.preventDefault();

        $offcanvasBackdrop.modal('hide');

        e.stopPropagation();
    });


    $offcanvasClose.on('click', function () {
        $offcanvasBackdrop.modal('hide');

    });

    $offcanvasBackdrop.on('hide.bs.modal', function (e) {
        // -- reset class from offcanvas
        $('.offcanvas.is--open').removeClass('is--open');
    });

// ------------------------------------------
// --- Search toggle
// ------------------------------------------
    if ($('#search').length > 0) {
        var $searchToggle = $('.search-toggler'),
            $searchWrapper = $('.header-main .col-search'),
            $searchBackdrop = $('#search-backdrop');

        $searchToggle.on('click', function (e) {
            $searchBackdrop.modal('show');
            $searchWrapper.addClass('is--open');

            e.stopPropagation();
        });

        $searchBackdrop.unbind('click');

        $searchBackdrop.on('click', function (e) {
            e.preventDefault();
            $searchBackdrop.modal('hide');
            e.stopPropagation();
        });

        $searchBackdrop.on('hide.bs.modal', function (e) {
            $searchWrapper.removeClass('is--open');
        });

        $searchBackdrop.on('show.bs.modal', function (e) {
            $searchWrapper.addClass('is--open');
        });
    }

// ------------------------------------------
// --- rangeslider
// ------------------------------------------

    if ($('.js-range-slider').length > 0) {
        $(".js-range-slider").ionRangeSlider();
    }

// ------------------------------------------
// --- autocomplete
// ------------------------------------------
    if ($('.auto-complete').length > 0) {
        $('.auto-complete').autocomplete({
            serviceUrl: '/wp-content/themes/travelshop/pm-ajax-endpoint.php?action=autocomplete',
            type: 'get',
            dataType : 'json',
            paramName : 'q',
            deferRequestBy : 0,
            minChars: 2,
            width: 'flex',
            groupBy: 'category',
            preventBadQueries: false,
            tabDisabled: true,
            preserveInput:  true,
            onSelect: function (suggestion) {
                if(suggestion.data.type == 'link'){
                    document.location.href = suggestion.data.url;
                }else if(suggestion.data.type == 'search'){
                    var url = $(this).parents('form').attr('action');
                    url += '?' + suggestion.data.search_request;
                    document.location.href = url;
                }
            }
        })
    }

// -------------------------------------------
// --- Multiselect category tree drop down in searchbox
// --------------------------------------------
    if ($('.dropdown-menu-select').length > 0) {

        // -- prevent dropdown close when clicked inside
        $('.dropdown-menu-select').on('click', function (e) {
            e.stopPropagation();
        });

        $('.dropdown-menu-select .filter-prompt').on('click', function (e) {
            e.preventDefault();

            $(this).parents('.dropdown').find('.dropdown-toggle').trigger('click');

            e.stopPropagation();
        })

        // -- make dropdown span-checkboxes clickable
        $('.multi-level-checkboxes .form-check span').on('click', function (e) {
            if ($(e.target).siblings('input').is(':checked')) {
                $(e.target).siblings('input').prop('checked', false).trigger('change');
            } else {
                $(e.target).parent().find('input').prop('checked', true).trigger('change');
            }
        });
        

        // -- create label text on input change, put it into span
        $('.dropdown-menu-select').find('input').on('change', function (e) {

            var placeHolderTag = $(this).parents('.dropdown').find('.selected-options'),
                placeHolderDefaultText = placeHolderTag.data('placeholder'),
                placeHolderGetText = placeHolderTag.text(),
                placeHolderOptionsText = '',
                that = $(this);

            if (placeHolderGetText != placeHolderDefaultText) {
                placeHolderOptionsText = placeHolderGetText;
            }

            var thatValue = that.parent().find('> label').text();
            thatValue = $.trim(thatValue);

            var allBoxes = $(this).parent().parent().find('input');
            var allEmpty = true;

            $(allBoxes).each(function (key, input) {
                if (input.checked) {
                    allEmpty = false;
                }
            });

            // function to hide/show the clear-button
            if (!allEmpty) {
                $(this).parent().parent().parent().parent().find('.dropdownReiseziel .dropdown-clear').show();
            } else {
                $(this).parent().parent().parent().parent().find('.dropdownReiseziel .dropdown-clear').hide();
            }

            if (that.prop('checked') === true) {
                if (placeHolderOptionsText != '') {
                    placeHolderOptionsText = placeHolderOptionsText + ', ' + thatValue;
                } else {
                    placeHolderOptionsText = thatValue;
                }
            } else {
                if (placeHolderGetText.indexOf(',') != -1) {
                    if (placeHolderGetText.indexOf(thatValue) == 0) {
                        placeHolderOptionsText = placeHolderOptionsText.replace(thatValue + ', ', '');
                    } else {
                        placeHolderOptionsText = placeHolderOptionsText.replace(', ' + thatValue, '');
                    }
                } else {
                    placeHolderOptionsText = $.trim(placeHolderDefaultText);
                }
            }

            placeHolderTag.text(placeHolderOptionsText);

        });

        $('.dropdown-clear').on('click', function (e) {
            e.stopPropagation();
            var placeHolderTag = $(e.target).parent().parent().find('.selected-options');
            var dropdown = $(e.target).parent().parent().parent().find('.dropdown-menu');
            var allBoxes = $(dropdown).find('input');

            $(allBoxes).each(function (key, input) {
                if (input.checked) {
                    $(input).prop('checked', false).trigger('change');
                }
            });

            $(placeHolderTag).empty().text('bitte wählen');

            $(e.target).hide();
        });

        // Init on load
        $('.dropdown-menu-select input:checked').trigger('change');

    }

    /**
     * based on this magic date (easter sunday), it's possible to calculate some special dates:
     *
     * offset to german feiertag from the easterdate
     * - Weiberfastnacht	-52
     * - Rosenmontag	-48
     * - Fastnachtsdienstag	-47
     * - Aschermittwoch	-46
     * - Gründonnerstag	-3
     * - Karfreitag	-2
     * - Ostersonntag	0
     * - Ostermontag	+1
     * - Christi Himmelfahrt	+39
     * - Pfingstsonntag	+49
     * - Pfingstmontag	+50
     * - Fronleichnam	+60
     *
     * @param Y Year YYYY
     * @returns dayjs
     */
    function theEasterDate(Y) {
        var C = Math.floor(Y/100);
        var N = Y - 19*Math.floor(Y/19);
        var K = Math.floor((C - 17)/25);
        var I = C - Math.floor(C/4) - Math.floor((C - K)/3) + 19*N + 15;
        I = I - 30*Math.floor((I/30));
        I = I - Math.floor(I/28)*(1 - Math.floor(I/28)*Math.floor(29/(I + 1))*Math.floor((21 - N)/11));
        var J = Y + Math.floor(Y/4) + I + 2 - C + Math.floor(C/4);
        J = J - 7*Math.floor(J/7);
        var L = I - J;
        var M = 3 + Math.floor((L + 40)/44);
        var D = L + 28 - 31*Math.floor(M/4);

        return dayjs().date(D).month(M - 1).year(Y);
    }


});
