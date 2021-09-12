jQuery(function ($) {

    TSAjax = function (endpoint_url) {

        var _this = this;
        this.endpoint_url = endpoint_url;
        this.requests = new Array();

        this.call = function (query_string, scrollto, total_result_span_id, callback) {

            for (var i = 0; i < this.requests.length; i++) {
                this.requests[i].abort();
            }

            this.requests.push($.ajax({
                url: this.endpoint_url + '?' + query_string,
                method: 'GET',
                data: null
            }).done(function (data) {
                callback(data, query_string, scrollto, total_result_span_id);
            }));
        }

        this.setSpinner = function (search_result) {
            $('.spinner').show();
            $(search_result).html('');
            $('.pagination').hide();
        }

        this.removeSpinner = function () {
            $('.spinner').hide();
            $('.pagination').show();
        }

        this.resultHandlerWishlist = function (data) {

            // set the wishlist
            for (var key in data.html) {
                $('#' + key).html(data.html[key]);
            }

            // sync results to localstorage (if object are deleted from server)
            let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
            if (!jQuery.isEmptyObject(wishlist)) {
                $(wishlist).each(function (key, item) {
                    var is_valid = false;
                    $(data.ids).each(function (key, id) {
                        if (item['pm-id'] == id) {
                            is_valid = true;
                        }
                    });
                    if (!is_valid) {
                        console.log(' not valid remove' + item['pm-id']);
                        _this.wishlistRemoveElement(wishlist, item['pm-id']);
                    }
                });
                $('.wishlist-count').text(wishlist.length);
                window.localStorage.setItem('wishlist', JSON.stringify(wishlist));
            }

        }

        this.resultHandlerSearch = function (data, query_string, scrollto, total_result_span_id) {

            _this.removeSpinner();

            for (var key in data.html) {
                if (key == 'search-result') {
                    $('#' + key).html(data.html[key]).find('.content-block-travel-cols').fadeIn()
                        .css({
                            top: 1000,
                            position: 'relative'
                        })
                        .animate({
                            top: 0
                        }, 200, 'swing')
                } else {
                    $('#' + key).html(data.html[key]);
                }

                if (key == 'search-filter' && $('.js-range-slider').length > 0) {
                    $(".js-range-slider").ionRangeSlider({});
                }
            }

            if (total_result_span_id != null) {
                var total_count_span = $(total_result_span_id);
                var str = '';
                if (data.count == 1) {
                    str = data.count + ' ' + total_count_span.data('total-count-singular');
                } else if (data.count > 1 || data.count == 0) {
                    str = data.count + ' ' + total_count_span.data('total-count-plural');
                } else {
                    str = data.count + ' ' + total_count_span.data('total-count-default');
                }
                total_count_span.html(str.trim());
            }

            if (scrollto != null) {
                _this.scrollTo(scrollto);
            }

            window.history.pushState(null, '', window.location.pathname + '?' + query_string);

        }

        this.scrollTo = function (scrollto) {
            $('html, body').stop().animate({
                'scrollTop': $(scrollto).offset().top - $('header.affix').height()
            }, 200, 'swing');
        }


        this.resultHandlerSearchBarStandalone = function (data, query_string, scrollto, total_result_span_id) {

            if (total_result_span_id != null) {
                var total_count_span = $(total_result_span_id);
                var str = '';
                if (data.count == 1) {
                    str = data.count + ' ' + total_count_span.data('total-count-singular');
                } else if (data.count > 1 || data.count == 0) {
                    str = data.count + ' ' + total_count_span.data('total-count-plural');
                } else {
                    str = data.count + ' ' + total_count_span.data('total-count-default');
                }
                total_count_span.html(str.trim());
            }

        }


        this.renderWishlist = function () {

            let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
            if (wishlist !== null && wishlist.length !== 0) {
                let query_string = 'action=wishlist&view=Teaser2&pm-id=';
                $('.wishlist-count').text(wishlist.length);
                $('.wishlist-toggler').addClass('animate');
                setTimeout(function () {
                    $('.wishlist-toggler').removeClass('animate');
                }, 1250);
                wishlist.forEach(function (item, key) {
                    if (key !== wishlist.length - 1) {
                        query_string += item['pm-id'] + ',';
                    } else {
                        query_string += item['pm-id'];
                    }
                });
                _this.call(query_string, null, null, _this.resultHandlerWishlist);
            } else {
                _this.wishlistEventListeners();
                $('.wishlist-count').text(0);
                $('.wishlist-items').html(`<p>Keine Reisen auf der Merkliste</p>`);
            }
        }

        this.wishlistEventListeners = function () {

            $('body').on('DOMSubtreeModified', '#search-result', function () {
                _this.wishListInit();
            });

            $('body').on('click', '.remove-from-wishlist', function (e) {
                let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
                if (!jQuery.isEmptyObject(wishlist)) {
                    if (wishlist.some(wi => wi['pm-id'] == $(e.target).data('pm-id'))) {
                        _this.wishlistRemoveElement(wishlist, $(e.target).data('pm-id'));
                        // $('.wishlist-heart').removeClass('active');
                        $('.add-to-wishlist').each(function (key, item) {
                            if ($(item).data('pm-id') == $(e.target).data('pm-id')) {
                                $(item).removeClass('active');
                            }
                        });
                    }
                }
                window.localStorage.setItem('wishlist', JSON.stringify(wishlist));
                _this.renderWishlist();
            });
            if ($('.add-to-wishlist').length > 0) {
                let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
                $('body').on('click', '.add-to-wishlist', function (e) {
                    if (jQuery.isEmptyObject(wishlist)) {
                        wishlist = [];
                    }
                    if (wishlist.some(wi => wi['pm-id'] == $(e.target).data('pm-id'))) {
                        _this.wishlistRemoveElement(wishlist, $(e.target).data('pm-id'));
                        $(e.target).removeClass('active');
                    } else {
                        wishlist.push({
                            'pm-ot': $(e.target).data('pm-ot'),
                            'pm-id': $(e.target).data('pm-id'),
                            'pm-dr': $(e.target).data('pm-dr'),
                            'pm-du': $(e.target).data('pm-du')
                        });
                        $(e.target).addClass('active');
                    }
                    window.localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    _this.renderWishlist();
                });
            }
        }

        this.wishListInit = function () {
            let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
            if (!jQuery.isEmptyObject(wishlist)) {
                $('.add-to-wishlist').each(function (key, item) {
                    if (wishlist.some(wi => wi['pm-id'] == $(item).data('pm-id'))) {
                        $(item).addClass('active');
                    }
                });
            }
        }

        this.wishlistRemoveElement = function (array, elem) {
            array.some(function (item) {
                if (item['pm-id'] == elem) {
                    var index = array.indexOf(item);
                    array.splice(index, 1);
                }
            });
        }

        this.pagination = function () {

            $("#search-result").on('click', ".page-link", function (e) {
                var href = $(this).attr('href').split('?');
                var query_string = href[1];

                _this.scrollTo('#search-result');
                _this.setSpinner('#pm-search-result');
                _this.call(query_string, null, null, _this.resultHandlerSearch);
                e.preventDefault();
            });

        }

        this.buildSearchQuery = function (form) {

            let query = [];
            query.push('action=search');

            // the object type
            let id_object_type = $(form).find('input[name=pm-ot]').val();
            if (id_object_type && id_object_type != '') {
                query.push('pm-ot=' + id_object_type);
            }

            // checkboxes
            let tree_conditions = ['c', 'cl']; // cl = support for trees in object links
            let i;
            for (i in tree_conditions) {
                let selected = [];
                $(form).find('.category-tree input[data-type="' + tree_conditions[i] + '"]:checked').each(function () {

                    let id_parent = $(this).data('id-parent');
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let type = $(this).data('type');


                    if (!selected[name]) {
                        selected[name] = [];
                    }

                    let i = selected[name].indexOf(id_parent);
                    if (i > -1) {
                        // remove if parent is set
                        selected[name].splice(i, 1);
                    }

                    i = selected[name].indexOf(id);
                    if (i == -1) {
                        // has no parent, add
                        selected[name].push(id);
                    }

                });

                let delimiter = ',';

                /* @todo
                if (selected_item.data('behaivor') == 'AND'){
                    var delimiter = '+';
                }
                */

                let key;
                for (key in selected) {
                    query.push('pm-' + tree_conditions[i] + '[' + key + ']=' + selected[key].join(delimiter));
                }

            }

            // check and set price-range

            let price_range = $(form).find('input[name=pm-pr]').val();
            let price_mm_range = $(form).find('input[name=pm-pr]').data('min') + '-' + $(form).find('input[name=pm-pr]').data('max');
            if (price_range && price_mm_range != price_range && price_range != '') {
                query.push('pm-pr=' + price_range);
            }

            // check and set duration-range
            let duration_range = $(form).find('input[name=pm-du]').val();
            let duration_mm_range = $(form).find('input[name=pm-du]').data('min') + '-' + $(form).find('input[name=pm-du]').data('max');
            if (duration_range && duration_mm_range != duration_range && duration_range != '') {
                query.push('pm-du=' + duration_range);
            }

            // check and set date-range
            let date_range = $(form).find('input[name=pm-dr]').data('value');
            if (date_range && date_range != '') {
                query.push('pm-dr=' + date_range);
            }

            // check and set search term
            let search_term = $(form).find('input[name=pm-t]').val();
            if (search_term && search_term != '') {
                query.push('pm-t=' + search_term);
            }

            let order = $(form).find('select[name=pm-o]').val();
            if (order && order != '') {
                query.push('pm-o=' + order);
            }

            // the view
            let view = $('.pm-switch-result-view .pm-switch-checkbox').prop('checked');
            if (view) {
                query.push('view=' + $('.pm-switch-result-view .pm-switch-checkbox').val());
            }

            // Build the Query
            let query_string;
            query_string = query.join('&');

            return query_string;
        }

        this.filter = function () {

            // dont run default realtime ajax-functions on small viewport
            if ($(window).width() > 768) {
                $("#search-filter").on('change', ".list-filter-box input, .list-filter-box select", function (e) {
                    var form = $(this).closest('form');
                    var query_string = _this.buildSearchQuery(form);
                    _this.setSpinner('#pm-search-result');
                    _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                    e.preventDefault();
                });
            }

            $("#search-filter").on('click', ".list-filter-box-submit", function (e) {
                var form = $(this).closest('form');
                var query_string = _this.buildSearchQuery(form);
                _this.setSpinner('#pm-search-result');
                _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                e.preventDefault();
            });

        }


        this.searchbox = function () {

            /**
             * This Event checks if a input field is modified and building the query string.
             * The query string is added to the form > a.btn > href
             * If the search box is on the same site as the search result, than the ajax search query is fired
             */
            $(".search-box input, .search-box  select").on('change', function (e) {

                let form = $(this).closest('form');

                // build the query string and set him on the search button
                let query_string = _this.buildSearchQuery(form);

                let button = $(form).find('a.btn');
                let href = button.attr('href').split('?');
                button.attr('href', href[0] + '?' + query_string);

                // if we're on the same page, let fire the search and set the search results
                let current_location = window.location.href.split('?');
                if (current_location[0] == href[0]) {
                    _this.setSpinner('#pm-search-result');
                    _this.call(query_string, null, '.search-bar-total-count', _this.resultHandlerSearch);
                } else {
                    // in this case we have placed a search box on a site without a direct result output
                    _this.call(query_string, null, '.search-bar-total-count', _this.resultHandlerSearchBarStandalone);
                }

                e.preventDefault();
            });

        }

    };

    var Search = new TSAjax('/wp-content/themes/travelshop/pm-ajax-endpoint.php');
    Search.renderWishlist();
    Search.wishlistEventListeners();
    Search.wishListInit();
    Search.pagination();
    Search.searchbox();
    Search.filter();

});