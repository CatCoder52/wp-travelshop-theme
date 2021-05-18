jQuery(function ($) {

    /**
     * Example usage:
     * var Search = new TSAjax('/wordpress/wp-content/themes/travelshop/ajax-endpoint.php');
     * Search.get('test_id', {action: 'get'});
     */

    // -----------------------------------------------
    // -- Helper Functions
    // -----------------------------------------------
    function removeElement(array, elem) {
        var index = array.indexOf(elem);
        if (index > -1) {
            array.splice(index, 1);
        }
    }

    TSAjax = function (endpoint_url) {

        var _this = this;
        this.endpoint_url = endpoint_url;

        // @todo name me
        if ($('.js-range-slider').length > 0) {
            $(".js-range-slider").ionRangeSlider({
                    input_values_separator: '-'
                }
            );
        }

        this.call = function (query_string, scrollto, total_result_span_id) {

            var jqxhr = $.ajax({
                url: this.endpoint_url + '?' + query_string,
                method: 'GET',
                data: null
            })
                .done(function (data) {

                    for (var key in data.html) {
                        $('#' + key).html(data.html[key]);
                    }

                    if (total_result_span_id != null) {

                        var total_count_span = $(total_result_span_id);

                        if (data.count == 1) {
                            total_count_span.html(data.count + ' ' + total_count_span.data('total-count-singular'))
                        } else if (data.count > 1 || data.count == 0) {
                            total_count_span.html(data.count + ' ' + total_count_span.data('total-count-plural'))
                        } else {
                            total_count_span.html(total_count_span.data('total-count-default'));
                        }


                    }

                    if (scrollto) {
                        $('html, body').animate({
                            scrollTop: ($(scrollto).offset().top)
                        }, 500);
                    }

                    window.history.pushState(null, '', window.location.pathname + '?' + query_string);
                    addFilterCheckboxEventListener($('#filter'));
                })
                .fail(function () {
                    console.log('ajax error');
                });
        }

        this.getWishlistMediaObjects = function(query_string) {
            var jqxhr = $.ajax({
                url: this.endpoint_url + query_string,
                method: 'GET',
                data: null
            })
            .done(function (data) {
                console.log(data);
            })
            .fail(function () {
                console.log('ajax error');
            });
        }

        this.renderWishlist = function() {
            let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
            if(wishlist !== null) {
                let query_string = '?wishlistIDs=';
                $('.wishlist-count').text(wishlist.length);
                wishlist.forEach(function(item, key) {
                    if(key !== wishlist.length - 1) {
                        query_string += item + ',';
                    } else {
                        query_string += item;
                    }
                    
                });
                console.log(query_string);
                _this.getWishlistMediaObjects(query_string);
            }
        }

        this.addToWishlist = function() {
            $('.add-to-wishlist').click(function(e) {
                let wishlist = JSON.parse(window.localStorage.getItem('wishlist'));
                if(wishlist == null) {
                    wishlist = [];
                }
                if(wishlist.includes($(e.target).data('id'))) {
                    removeElement(wishlist, $(e.target).data('id'));
                    $('.wishlist-heart').removeClass('active');
                } else {
                    wishlist.push($(e.target).data('id'));
                    $('.wishlist-heart').addClass('active');
                }
                window.localStorage.setItem('wishlist', JSON.stringify(wishlist));
                console.log(wishlist);
            });
        }

        this.pagination = function () {

            // @todo load item list at the end of the existing list
            $("#search-result").on('click', ".page-link", function (e) {
                var href = $(this).attr('href').split('?');
                var query_string = href[1];
                _this.call(query_string, '#search-result');
                e.preventDefault();
            });

        }

        this.buildSearchQuery = function (form) {

            var query = [];

            // the object type
            var id_object_type = $('input[name=pm-ot]').val();
            if (id_object_type && id_object_type != '') {
                query.push('pm-ot=' + id_object_type);
            }

            // checkboxes
            var selected = [];

            $(form).find(".category-tree input:checked").each(function () {

                var id_parent = $(this).data('id-parent');
                var id = $(this).data('id');
                var name = $(this).data('name');

                if (!selected[name]) {
                    selected[name] = [];
                }

                var i = selected[name].indexOf(id_parent);
                if (i > -1) {
                    // parent ist vorhanden entferne
                    selected[name].splice(i, 1);
                }

                var i = selected[name].indexOf(id);
                if (i == -1) {
                    // ist nicht vorhanden, hinzufügen
                    selected[name].push(id);
                }

            });

            var delimiter = ',';

            /* @todo
            if (selected_item.data('behaivor') == 'AND'){
                var delimiter = '+';
            }
            */

            var key;
            for (key in selected) {
                query.push('pm-c[' + key + ']=' + selected[key].join(delimiter));
            }

            // check and set price-range
            var price_range = $('input[name=pm-pr]').val();
            if (price_range && price_range != '') {
                query.push('pm-pr=' + price_range);
            }

            // check and set date-range
            var date_range = $('input[name=pm-dr]').data('value');
            if (date_range && date_range != '') {
                query.push('pm-dr=' + date_range);
            }

            // check and set search term
            var search_term = $('input[name=pm-t]').val();
            if (search_term && search_term != '') {
                query.push('pm-t=' + search_term);
            }

            var order = $('select[name=pm-o]').val();
            if (order && order != '') {
                query.push('pm-o=' + order);
            }

            // Build the Query
            var query_string;
            query_string = query.join('&');

            return query_string;
        }

        this.filter = function () {

            // dont run default realtime ajax-functions on small viewport
            if ($(window).width() > 768) {
                $("#search-filter").on('change', ".list-filter-box input, .list-filter-box select", function (e) {
                    var form = $(this).closest('form');
                    var query_string = _this.buildSearchQuery(form);
                    _this.call(query_string, '#search-result');
                    e.preventDefault();
                });
            }

            $("#search-filter").on('click', ".list-filter-box-submit", function (e) {
                var form = $(this).closest('form');
                var query_string = _this.buildSearchQuery(form);
                _this.call(query_string, '#search-result');
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

                var form = $(this).closest('form');

                // build the query string and set him on the search button
                var query_string = _this.buildSearchQuery(form);

                var button = $(form).find('a.btn');
                var href = button.attr('href').split('?');
                button.attr('href', href[0] + '?' + query_string);

                // if we're on the same page, let fire the search
                var current_location = window.location.href.split('?');
                if (current_location[0] == href[0]) {
                    _this.call(query_string, undefined, '.search-bar-total-count');
                }

                e.preventDefault();
            });

        }

    };

    var Search = new TSAjax('/wp-content/themes/travelshop/pm-ajax-endpoint.php');
    Search.renderWishlist();
    Search.addToWishlist();
    Search.pagination();
    Search.searchbox();
    Search.filter();


});