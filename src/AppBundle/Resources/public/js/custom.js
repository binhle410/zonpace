jQuery(function () {

    (function ($, window, document, undefined) {

        $(".datepicker").datepicker({autoclose: true});


    })(jQuery, window, document);

    /**
     *  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "space-create-step1";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.drawShape();
            },
            searchPlace: function (map) {
                var that = this;
                //init search input
                var input = document.getElementById('app_space_space_location_streetAddress');
                var options = {
                    // types: ['(cities)'],
                    componentRestrictions: {country: 'vn'}
                };
                var searchBox = new google.maps.places.Autocomplete(input, options);
                var markers = [];
                //event when input change
                searchBox.addListener('place_changed', function () {
                    var place = searchBox.getPlace();

                    if (place.length == 0) {
                        return;
                    }

                    var bounds = new google.maps.LatLngBounds();
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    var lat = bounds.getCenter().lat();
                    var lng = bounds.getCenter().lng();
                    $('#app_space_space_location_lat').val(lat);
                    $('#app_space_space_location_lng').val(lng);
                    map.setCenter({lat: lat, lng: lng});
                });
            },
            drawShape: function () {
                var that = this;
                var width = $('.map').parent('div').width();
                $('.map').width(width).height(width);
                function initialize() {
                    var goo = google.maps,
                        map_in = new goo.Map(document.getElementById('map_in'),
                            {
                                zoom: 20,
                                center: new goo.LatLng(43, -88)
                            }),
                        shapes = [],
                        selected_shape = null,
                        drawman = new goo.drawing.DrawingManager({
                            map: map_in,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [
                                    google.maps.drawing.OverlayType.POLYGON,
                                ]
                            },
                            polygonOptions: {
                                fillColor: '#ff0000',
                                strokeColor: '#ff0000',
                            }
                        }),


                        byId = function (s) {
                            return document.getElementById(s)
                        },
                        clearSelection = function () {
                            if (selected_shape) {
                                selected_shape.set((selected_shape.type
                                    ===
                                    google.maps.drawing.OverlayType.MARKER
                                ) ? 'draggable' : 'editable', false);
                                selected_shape = null;
                            }
                        },
                        setSelection = function (shape) {
                            clearSelection();
                            selected_shape = shape;

                            selected_shape.set((selected_shape.type
                                ===
                                google.maps.drawing.OverlayType.MARKER
                            ) ? 'draggable' : 'editable', true);

                        },
                        clearShapes = function () {
                            for (var i = 0; i < shapes.length; ++i) {
                                shapes[i].setMap(null);
                            }
                            shapes = [];

                            shapes = IO.OUT([], map_in);
                        };

                    goo.event.addListener(drawman, 'overlaycomplete', function (e) {
                        var shape = e.overlay;
                        shape.type = e.type;
                        goo.event.addListener(shape, 'click', function () {
                            setSelection(this);
                        });
                        setSelection(shape);
                        shapes.push(shape);
                    });

                    goo.event.addListener(map_in, 'click', clearSelection);
                    goo.event.addDomListener(byId('clear_shapes'), 'click', clearShapes);
                    goo.event.addDomListener(byId('save'), 'click', function () {
                        var data = IO.IN(shapes, false);
                        byId('app_space_space_shape').value = JSON.stringify(data);
                    });
                    if (byId('app_space_space_shape').value != '') {
                        shapes = IO.OUT(JSON.parse(byId('app_space_space_shape').value), map_in);
                    }

                    that.searchPlace(map_in);
                }


                var IO = {
                    //returns array with storable google.maps.Overlay-definitions
                    IN: function (arr,//array with google.maps.Overlays
                                  encoded//boolean indicating whether pathes should be stored encoded
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];
                            tmp = {type: this.t_(shape.type), id: shape.id || null};


                            switch (tmp.type) {
                                case 'CIRCLE':
                                    tmp.radius = shape.getRadius();
                                    tmp.geometry = this.p_(shape.getCenter());
                                    break;
                                case 'MARKER':
                                    tmp.geometry = this.p_(shape.getPosition());
                                    break;
                                case 'RECTANGLE':
                                    tmp.geometry = this.b_(shape.getBounds());
                                    break;
                                case 'POLYLINE':
                                    tmp.geometry = this.l_(shape.getPath(), encoded);
                                    break;
                                case 'POLYGON':
                                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                                    break;
                            }
                            shapes.push(tmp);
                        }

                        return shapes;
                    },
                    //returns array with google.maps.Overlays
                    OUT: function (arr,//array containg the stored shape-definitions
                                   map//map where to draw the shapes
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            map = map || null,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];

                            switch (shape.type) {
                                case 'CIRCLE':
                                    tmp = new goo.Circle({
                                        radius: Number(shape.radius),
                                        center: this.pp_.apply(this, shape.geometry)
                                    });
                                    break;
                                case 'MARKER':
                                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                                    break;
                                case 'RECTANGLE':
                                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                                    break;
                                case 'POLYLINE':
                                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                                    break;
                                case 'POLYGON':
                                    tmp = new goo.Polygon({
                                        paths: this.mm_(shape.geometry),
                                        fillColor: '#ff0000',
                                        strokeColor: '#ff0000',
                                    });
                                    map.setCenter(new google.maps.LatLng(shape.geometry[0][0][0], shape.geometry[0][0][1]));

                                    break;
                            }
                            tmp.setValues({map: map, id: shape.id})
                            shapes.push(tmp);
                        }
                        return shapes;
                    },
                    l_: function (path, e) {
                        path = (path.getArray) ? path.getArray() : path;
                        if (e) {
                            return google.maps.geometry.encoding.encodePath(path);
                        } else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.p_(path[i]));
                            }
                            return r;
                        }
                    },
                    ll_: function (path) {
                        if (typeof path === 'string') {
                            return google.maps.geometry.encoding.decodePath(path);
                        }
                        else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.pp_.apply(this, path[i]));
                            }
                            return r;
                        }
                    },

                    m_: function (paths, e) {
                        var r = [];
                        paths = (paths.getArray) ? paths.getArray() : paths;
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.l_(paths[i], e));
                        }
                        return r;
                    },
                    mm_: function (paths) {
                        var r = [];
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.ll_.call(this, paths[i]));

                        }
                        return r;
                    },
                    p_: function (latLng) {
                        return ([latLng.lat(), latLng.lng()]);
                    },
                    pp_: function (lat, lng) {
                        return new google.maps.LatLng(lat, lng);
                    },
                    b_: function (bounds) {
                        return ([this.p_(bounds.getSouthWest()),
                            this.p_(bounds.getNorthEast())]);
                    },
                    bb_: function (sw, ne) {
                        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                            this.pp_.apply(this, ne));
                    },
                    t_: function (s) {
                        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
                        for (var i = 0; i < t.length; ++i) {
                            if (s === google.maps.drawing.OverlayType[t[i]]) {
                                return t[i];
                            }
                        }
                    }

                }
                google.maps.event.addDomListener(window, 'load', initialize);

            }
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /**
     *  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "space-create-step2";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.calendar;
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.loadCalendar();
                $('#app_space_space_dateBooking_dateFrom').change(function () {
                    that.loadCalendar();
                });
                $('#app_space_space_dateBooking_dateTo').change(function () {
                    that.loadCalendar();
                });

                that.checkPrice();
                that.drawShape();
                that.uploadImageSpace();
            },
            loadCalendar: function () {
                var that = this;
                var startDate = '2000-01-01';
                var endDate = '2100-01-01';
                if ($('#app_space_space_dateBooking_dateFrom').val() != '') {
                    var startDateRaw = $('#app_space_space_dateBooking_dateFrom').val();
                    startDateRaw = startDateRaw.split('/');
                    startDate = startDateRaw[2] + '-' + startDateRaw[0] + '-' + startDateRaw[1];
                }
                if ($('#app_space_space_dateBooking_dateTo').val() != '') {
                    var endDateRaw = $('#app_space_space_dateBooking_dateTo').val();
                    endDateRaw = endDateRaw.split('/');
                    endDate = endDateRaw[2] + '-' + endDateRaw[0] + '-' + endDateRaw[1];
                }
                if (that.calendar != undefined) {
                    that.calendar.destroy();
                }
                that.initCalendar(startDate, endDate);
            },
            initCalendar: function (startDate, endDate) {
                var that = this;
                that.calendar = $('#mini-clndr').clndr({
                    template: $('#mini-clndr-template').html(),
                    // events: events,
                    clickEvents: {
                        click: function (target) {
                            if ($('#app_space_space_dateBooking_dateFrom').val() != '' && $('#app_space_space_dateBooking_dateTo').val() != '') {
                                if ($(target.element).hasClass('inactive') === false) {
                                    if ($(target.element).hasClass('inactive-by-hand')) {
                                        $(target.element).removeClass('inactive-by-hand');
                                        var blockedDate = $(target.element).attr('id');
                                        that.updateBlockedDate(blockedDate, false);
                                    } else {
                                        $(target.element).addClass('inactive-by-hand');
                                        var blockedDate = $(target.element).attr('id');
                                        that.updateBlockedDate(blockedDate, true);
                                    }
                                }
                            }
                        },
                        onMonthChange: function (month) {
                            that.loadBlockedDate();
                        },
                        onYearChange: function (month) {
                            that.loadBlockedDate();
                        },
                    },

                    adjacentDaysChangeMonth: true,
                    // forceSixRows: true,
                    constraints: {
                        startDate: startDate,
                        endDate: endDate
                    },
                });
                that.loadBlockedDate();

            },
            updateBlockedDate: function (date, add) {
                var dateArr = date.split('-');
                var year = dateArr[0];
                var month = dateArr[1];
                var blockedDateJson = $('#app_space_space_dateBooking_blockedDateBookings').val();
                var blockedDateJsonParsed = JSON.parse(blockedDateJson.trim());
                if (add) {
                    if (blockedDateJsonParsed[year] == undefined) {
                        blockedDateJsonParsed[year] = {};
                    }
                    if (blockedDateJsonParsed[year][month] == undefined) {
                        blockedDateJsonParsed[year][month] = {};
                    }
                    blockedDateJsonParsed[year][month][date] = date;
                } else {
                    delete blockedDateJsonParsed[year][month][date];
                }
                var stringJson = JSON.stringify(blockedDateJsonParsed);
                $('#app_space_space_dateBooking_blockedDateBookings').val(stringJson);
            },
            loadBlockedDate: function () {
                var blockedDateJson = $('#app_space_space_dateBooking_blockedDateBookings').val();
                var blockedDateJsonParsed = JSON.parse(blockedDateJson);

                var blockedDateArr = [];

                $.each(blockedDateJsonParsed, function (index, year) {
                    $.each(year, function (index, month) {
                        $.each(month, function (index, date) {
                            blockedDateArr.push(date);
                        });
                    });
                });
                if (blockedDateArr.length) {
                    for (var i = 0; i < blockedDateArr.length; i++) {
                        $('.calendar-day-' + blockedDateArr[i]).addClass('inactive-by-hand');
                    }
                }
            },
            checkPrice: function () {
                var dailySel = $('#app_space_space_price_daily');
                var weeklySel = $('#app_space_space_price_weeklyDiscount');
                var monthlySel = $('#app_space_space_price_monthlyDiscount');
                if (dailySel.val() != '') {
                    dailySel.parents('div.checkbox').find(':checkbox').attr('checked', true);
                } else {
                    dailySel.attr('disabled', true);
                    dailySel.parents('div.checkbox').find(':checkbox').attr('checked', false);
                }
                if (weeklySel.val() != '') {
                    weeklySel.parents('div.checkbox').find(':checkbox').attr('checked', true);
                } else {
                    weeklySel.attr('disabled', true);
                    weeklySel.parents('div.checkbox').find(':checkbox').attr('checked', false);
                }
                if (monthlySel.val() != '') {
                    monthlySel.parents('div.checkbox').find(':checkbox').attr('checked', true);
                } else {
                    monthlySel.attr('disabled', true);
                    monthlySel.parents('div.checkbox').find(':checkbox').attr('checked', false);
                }

                $('.price-daily').click(function () {
                    if ($(this).is(':checked')) {
                        dailySel.attr('disabled', false);
                    } else {
                        dailySel.val('');
                        dailySel.attr('disabled', true);
                    }
                });
                $('.price-weekly').click(function () {
                    if ($(this).is(':checked')) {
                        weeklySel.attr('disabled', false);
                    } else {
                        weeklySel.val('');
                        weeklySel.attr('disabled', true);
                    }
                });
                $('.price-monthly').click(function () {
                    if ($(this).is(':checked')) {
                        monthlySel.attr('disabled', false);
                    } else {
                        monthlySel.val('');
                        monthlySel.attr('disabled', true);
                    }
                });
            },
            drawShape: function () {
                var that = this;
                var width = $('.map').parent('div').width();
                $('.map').width(width).height(width);
                function initialize() {
                    var goo = google.maps,
                        map_in = new goo.Map(document.getElementById('map_in'),
                            {
                                zoom: 20,
                                center: new goo.LatLng(43, -88)
                            }),
                        shapes = [],
                        selected_shape = null,
                        drawman = new goo.drawing.DrawingManager({
                            map: map_in,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [
                                    // google.maps.drawing.OverlayType.POLYGON,
                                ]
                            },
                            polygonOptions: {
                                fillColor: '#ff0000',
                                strokeColor: '#ff0000',
                            }
                        }),


                        byId = function (s) {
                            return document.getElementById(s)
                        },
                        clearSelection = function () {
                            if (selected_shape) {
                                selected_shape.set((selected_shape.type
                                    ===
                                    google.maps.drawing.OverlayType.MARKER
                                ) ? 'draggable' : 'editable', false);
                                selected_shape = null;
                            }
                        },
                        setSelection = function (shape) {
                            clearSelection();
                            selected_shape = shape;

                            selected_shape.set((selected_shape.type
                                ===
                                google.maps.drawing.OverlayType.MARKER
                            ) ? 'draggable' : 'editable', true);

                        },
                        clearShapes = function () {
                            for (var i = 0; i < shapes.length; ++i) {
                                shapes[i].setMap(null);
                            }
                            shapes = [];

                            shapes = IO.OUT([], map_in);
                        };

                    goo.event.addListener(drawman, 'overlaycomplete', function (e) {
                        var shape = e.overlay;
                        shape.type = e.type;
                        goo.event.addListener(shape, 'click', function () {
                            setSelection(this);
                        });
                        setSelection(shape);
                        shapes.push(shape);
                    });

                    goo.event.addListener(map_in, 'click', clearSelection);
                    if (byId('app_space_space_shape').value != '') {
                        shapes = IO.OUT(JSON.parse(byId('app_space_space_shape').value), map_in);
                    }

                }


                var IO = {
                    //returns array with storable google.maps.Overlay-definitions
                    IN: function (arr,//array with google.maps.Overlays
                                  encoded//boolean indicating whether pathes should be stored encoded
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];
                            tmp = {type: this.t_(shape.type), id: shape.id || null};


                            switch (tmp.type) {
                                case 'CIRCLE':
                                    tmp.radius = shape.getRadius();
                                    tmp.geometry = this.p_(shape.getCenter());
                                    break;
                                case 'MARKER':
                                    tmp.geometry = this.p_(shape.getPosition());
                                    break;
                                case 'RECTANGLE':
                                    tmp.geometry = this.b_(shape.getBounds());
                                    break;
                                case 'POLYLINE':
                                    tmp.geometry = this.l_(shape.getPath(), encoded);
                                    break;
                                case 'POLYGON':
                                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                                    break;
                            }
                            shapes.push(tmp);
                        }

                        return shapes;
                    },
                    //returns array with google.maps.Overlays
                    OUT: function (arr,//array containg the stored shape-definitions
                                   map//map where to draw the shapes
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            map = map || null,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];

                            switch (shape.type) {
                                case 'CIRCLE':
                                    tmp = new goo.Circle({
                                        radius: Number(shape.radius),
                                        center: this.pp_.apply(this, shape.geometry)
                                    });
                                    break;
                                case 'MARKER':
                                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                                    break;
                                case 'RECTANGLE':
                                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                                    break;
                                case 'POLYLINE':
                                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                                    break;
                                case 'POLYGON':
                                    tmp = new goo.Polygon({
                                        paths: this.mm_(shape.geometry),
                                        fillColor: '#ff0000',
                                        strokeColor: '#ff0000',
                                    });
                                    map.setCenter(new google.maps.LatLng(shape.geometry[0][0][0], shape.geometry[0][0][1]));

                                    break;
                            }
                            tmp.setValues({map: map, id: shape.id})
                            shapes.push(tmp);
                        }
                        return shapes;
                    },
                    l_: function (path, e) {
                        path = (path.getArray) ? path.getArray() : path;
                        if (e) {
                            return google.maps.geometry.encoding.encodePath(path);
                        } else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.p_(path[i]));
                            }
                            return r;
                        }
                    },
                    ll_: function (path) {
                        if (typeof path === 'string') {
                            return google.maps.geometry.encoding.decodePath(path);
                        }
                        else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.pp_.apply(this, path[i]));
                            }
                            return r;
                        }
                    },

                    m_: function (paths, e) {
                        var r = [];
                        paths = (paths.getArray) ? paths.getArray() : paths;
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.l_(paths[i], e));
                        }
                        return r;
                    },
                    mm_: function (paths) {
                        var r = [];
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.ll_.call(this, paths[i]));

                        }
                        return r;
                    },
                    p_: function (latLng) {
                        return ([latLng.lat(), latLng.lng()]);
                    },
                    pp_: function (lat, lng) {
                        return new google.maps.LatLng(lat, lng);
                    },
                    b_: function (bounds) {
                        return ([this.p_(bounds.getSouthWest()),
                            this.p_(bounds.getNorthEast())]);
                    },
                    bb_: function (sw, ne) {
                        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                            this.pp_.apply(this, ne));
                    },
                    t_: function (s) {
                        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
                        for (var i = 0; i < t.length; ++i) {
                            if (s === google.maps.drawing.OverlayType[t[i]]) {
                                return t[i];
                            }
                        }
                    }

                }
                google.maps.event.addDomListener(window, 'load', initialize);

            },
            uploadImageSpace: function () {
                var myFileInput = $('#space-image');
                myFileInput.change(function () {
                    var url = myFileInput.data('href');
                    var data = document.querySelector("#form-space");
                    var formData = new FormData(data);
                    formData.append("CustomField", "This is some extra data");
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (response) {
                            if (response.status) {
                                var html = '<div width="165px;" height="102px;" class="col-md-4" style="margin-top: 2px"><img src="' + response.url + '"></div>';
                                $('.wrap-img-space').append(html);
                                $('#space-image').val('');
                            }
                        }
                    });
                });
            },
        }

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);
    /**
     *  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "space-create-stepx";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.calendar;
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.drawShape();
            },
            drawShape: function () {
                var that = this;
                var width = $('.map').parent('div').width();
                $('.map').width(width).height(width);
                function initialize() {
                    var goo = google.maps,
                        map_in = new goo.Map(document.getElementById('map_in'),
                            {
                                zoom: 20,
                                center: new goo.LatLng(43, -88)
                            }),
                        shapes = [],
                        selected_shape = null,
                        drawman = new goo.drawing.DrawingManager({
                            map: map_in,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [
                                    // google.maps.drawing.OverlayType.POLYGON,
                                ]
                            },
                            polygonOptions: {
                                fillColor: '#ff0000',
                                strokeColor: '#ff0000',
                            }
                        }),


                        byId = function (s) {
                            return document.getElementById(s)
                        },
                        clearSelection = function () {
                            if (selected_shape) {
                                selected_shape.set((selected_shape.type
                                    ===
                                    google.maps.drawing.OverlayType.MARKER
                                ) ? 'draggable' : 'editable', false);
                                selected_shape = null;
                            }
                        },
                        setSelection = function (shape) {
                            clearSelection();
                            selected_shape = shape;

                            selected_shape.set((selected_shape.type
                                ===
                                google.maps.drawing.OverlayType.MARKER
                            ) ? 'draggable' : 'editable', true);

                        },
                        clearShapes = function () {
                            for (var i = 0; i < shapes.length; ++i) {
                                shapes[i].setMap(null);
                            }
                            shapes = [];

                            shapes = IO.OUT([], map_in);
                        };

                    goo.event.addListener(drawman, 'overlaycomplete', function (e) {
                        var shape = e.overlay;
                        shape.type = e.type;
                        goo.event.addListener(shape, 'click', function () {
                            setSelection(this);
                        });
                        setSelection(shape);
                        shapes.push(shape);
                    });

                    goo.event.addListener(map_in, 'click', clearSelection);
                    if (byId('app_space_space_shape').value != '') {
                        shapes = IO.OUT(JSON.parse(byId('app_space_space_shape').value), map_in);
                    }

                }


                var IO = {
                    //returns array with storable google.maps.Overlay-definitions
                    IN: function (arr,//array with google.maps.Overlays
                                  encoded//boolean indicating whether pathes should be stored encoded
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];
                            tmp = {type: this.t_(shape.type), id: shape.id || null};


                            switch (tmp.type) {
                                case 'CIRCLE':
                                    tmp.radius = shape.getRadius();
                                    tmp.geometry = this.p_(shape.getCenter());
                                    break;
                                case 'MARKER':
                                    tmp.geometry = this.p_(shape.getPosition());
                                    break;
                                case 'RECTANGLE':
                                    tmp.geometry = this.b_(shape.getBounds());
                                    break;
                                case 'POLYLINE':
                                    tmp.geometry = this.l_(shape.getPath(), encoded);
                                    break;
                                case 'POLYGON':
                                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                                    break;
                            }
                            shapes.push(tmp);
                        }

                        return shapes;
                    },
                    //returns array with google.maps.Overlays
                    OUT: function (arr,//array containg the stored shape-definitions
                                   map//map where to draw the shapes
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            map = map || null,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];

                            switch (shape.type) {
                                case 'CIRCLE':
                                    tmp = new goo.Circle({
                                        radius: Number(shape.radius),
                                        center: this.pp_.apply(this, shape.geometry)
                                    });
                                    break;
                                case 'MARKER':
                                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                                    break;
                                case 'RECTANGLE':
                                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                                    break;
                                case 'POLYLINE':
                                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                                    break;
                                case 'POLYGON':
                                    tmp = new goo.Polygon({
                                        paths: this.mm_(shape.geometry),
                                        fillColor: '#ff0000',
                                        strokeColor: '#ff0000',
                                    });
                                    map.setCenter(new google.maps.LatLng(shape.geometry[0][0][0], shape.geometry[0][0][1]));

                                    break;
                            }
                            tmp.setValues({map: map, id: shape.id})
                            shapes.push(tmp);
                        }
                        return shapes;
                    },
                    l_: function (path, e) {
                        path = (path.getArray) ? path.getArray() : path;
                        if (e) {
                            return google.maps.geometry.encoding.encodePath(path);
                        } else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.p_(path[i]));
                            }
                            return r;
                        }
                    },
                    ll_: function (path) {
                        if (typeof path === 'string') {
                            return google.maps.geometry.encoding.decodePath(path);
                        }
                        else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.pp_.apply(this, path[i]));
                            }
                            return r;
                        }
                    },

                    m_: function (paths, e) {
                        var r = [];
                        paths = (paths.getArray) ? paths.getArray() : paths;
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.l_(paths[i], e));
                        }
                        return r;
                    },
                    mm_: function (paths) {
                        var r = [];
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.ll_.call(this, paths[i]));

                        }
                        return r;
                    },
                    p_: function (latLng) {
                        return ([latLng.lat(), latLng.lng()]);
                    },
                    pp_: function (lat, lng) {
                        return new google.maps.LatLng(lat, lng);
                    },
                    b_: function (bounds) {
                        return ([this.p_(bounds.getSouthWest()),
                            this.p_(bounds.getNorthEast())]);
                    },
                    bb_: function (sw, ne) {
                        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                            this.pp_.apply(this, ne));
                    },
                    t_: function (s) {
                        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
                        for (var i = 0; i < t.length; ++i) {
                            if (s === google.maps.drawing.OverlayType[t[i]]) {
                                return t[i];
                            }
                        }
                    }

                }
                google.maps.event.addDomListener(window, 'load', initialize);

            },
        }

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /*  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "search-space";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.calendar;
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.initSlider();
                that.searchPlace();
                $(".search-spaces-input").change(function () {
                    $('.form-search-spaces').submit();
                });
                that.filters();
            },
            initSlider: function () {
                $("#Slider1").slider({
                    from: 40,
                    to: 1000,
                    step: 10,
                    dimension: '',
                    callback: function (value) {
                        $('.form-search-spaces').submit();
                    }
                });
                $("#Slider2").slider({
                    from: 100,
                    to: 1000,
                    step: 10,
                    dimension: '&nbsp;$',
                    heterogeneity: ['50/500'],
                    callback: function (value) {
                        $('.form-search-spaces').submit();
                    }
                });
            },
            filters: function () {
                $('.start-filters').click(function () {
                    $(this).addClass('display-none');
                    $('.search-results').addClass('display-none');
                    $('.filter-group').removeClass('display-none');
                });
                $('.apply-filter').click(function () {
                    $('.form-search-spaces').submit();
                });
                $('.cancel-filter').click(function () {
                    $('.search-results').removeClass('display-none');
                    $('.start-filters').removeClass('display-none');
                    $('.filter-group').addClass('display-none');
                });
            },
            searchPlace: function () {
                var that = this;
                //init map
                var width = $('.map').parent('div').width();
                var lat = parseFloat($('#lat').val());
                var lng = parseFloat($('#lng').val());
                $('.map').width(width).height(width);
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: lat, lng: lng},
                    zoom: 11,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                //nearby location
                var request = {
                    location: new google.maps.LatLng(lat, lng),
                    radius: '10000',
                    types: ['address']
                };
                service = new google.maps.places.PlacesService(map);
                service.nearbySearch(request, function (results, status) {
                    var data = [];
                    var currentQuery = $('.main-container').data('query');
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        var length = results.length <= 5 ? results.length : 5;
                        for (var i = 0; i <= length; i++) {
                            var place = results[i];
                            currentQuery.location = place.name;
                            currentQuery.lat = place.geometry.location.lat();
                            currentQuery.lng = place.geometry.location.lng();

                            var currentQueryClone = $.extend(true, {}, currentQuery);
                            data[i] = currentQueryClone;
                        }
                        if (length) {
                            data = data.slice(1, length + 1);
                        }

                    }
                    if (data.length) {
                        var url = $('.main-container').data('url-search-nearby-listing');
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                nearByLocations: data,
                            },
                            success: function (result) {
                                if (result.status) {
                                    var html = '';
                                    for (var i = 0; i < result.data.length; i++) {
                                        var name = result.data[i].name;
                                        var numberListing = result.data[i].numberListing;
                                        var link = result.data[i].link;
                                        html += '<div class="row"><div class="col-md-9"><a href="' + link + '">' + name + ' </a></div><div class="col-md-3"><span class="pull-right">' + numberListing + '</span> </div> </div><hr class="divider">';
                                    }
                                    $('.nearby-listing').append(html);
                                } else {
                                }
                            }
                        });

                    }
                });
                //init maker
                var items = $('.search-space-item');
                items.each(function () {
                    var lat = $(this).data('lat');
                    var lng = $(this).data('lng');
                    var aphabet = $(this).data('aphabet');
                    // var icon = {
                    //     // url: place.icon,
                    //     size: new google.maps.Size(71, 71),
                    //     origin: new google.maps.Point(0, 0),
                    //     anchor: new google.maps.Point(17, 34),
                    //     scaledSize: new google.maps.Size(25, 25)
                    // };

                    // Create a marker for each place.
                    new google.maps.Marker({
                        map: map,
                        // icon: icon,
                        title: aphabet,
                        label: aphabet,
                        position: {lat: lat, lng: lng}
                    });
                });

                //init search input
                var input = document.getElementById('search-space-input');
                var options = {
                    // types: ['(cities)'],
                    componentRestrictions: {country: 'vn'}
                };
                var searchBox = new google.maps.places.Autocomplete(input, options);
                //event when input change
                searchBox.addListener('place_changed', function () {
                    var place = searchBox.getPlace();

                    if (place.length == 0) {
                        return;
                    }

                    var bounds = new google.maps.LatLngBounds();
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    $('#lat').val(bounds.getCenter().lat());
                    $('#lng').val(bounds.getCenter().lng());
                    $('.form-search-spaces').submit();
                });
            },

        },

            $.fn[pluginName] = function (options) {
                return this.each(function () {
                    if (!$.data(this, pluginName)) {
                        $.data(this, pluginName,
                            new Plugin(this, options));
                    }
                });
            };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /*  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "homepage";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.calendar;
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.initSlider();
                that.searchPlace();
            },
            initSlider: function () {
                $("#Slider1").slider({
                    from: 40,
                    to: 1000,
                    step: 10,
                    dimension: ''
                });
                $("#Slider2").slider({
                    from: 100,
                    to: 1000,
                    step: 10,
                    dimension: '&nbsp;$',
                    heterogeneity: ['50/500'],
                });
            },
            searchPlace: function () {
                var that = this;
                var input = document.getElementById('search-space-input');
                var options = {
                    // types: ['(cities)'],
                    componentRestrictions: {country: 'vn'}
                };
                var searchBox = new google.maps.places.Autocomplete(input, options);
                searchBox.addListener('place_changed', function () {
                    var place = searchBox.getPlace();

                    if (place.length == 0) {
                        return;
                    }
                    var bounds = new google.maps.LatLngBounds();
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    $('#lat').val(bounds.getCenter().lat());
                    $('#lng').val(bounds.getCenter().lng());
                });
            },

        },

            $.fn[pluginName] = function (options) {
                return this.each(function () {
                    if (!$.data(this, pluginName)) {
                        $.data(this, pluginName,
                            new Plugin(this, options));
                    }
                });
            };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })
    (jQuery, window, document);
    /*  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "list-space";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.filter();
            },
            filter: function () {
                var that = this;
                $('.type-space').change(function () {
                    $('.form-filter-list-space').submit();
                });
                $('.status-space').change(function () {
                    $('.form-filter-list-space').submit();
                });
            },

        },

            $.fn[pluginName] = function (options) {
                return this.each(function () {
                    if (!$.data(this, pluginName)) {
                        $.data(this, pluginName,
                            new Plugin(this, options));
                    }
                });
            };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);
    /*  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "list-booking";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.filter();
            },
            filter: function () {
                var that = this;
                $('.type-space').change(function () {
                    $('.form-filter-list-booking').submit();
                });
                $('.type-sort').change(function () {
                    $('.form-filter-list-booking').submit();
                });
                $('.status-booking').change(function () {
                    $('.form-filter-list-booking').submit();
                });
            },

        },

            $.fn[pluginName] = function (options) {
                return this.each(function () {
                    if (!$.data(this, pluginName)) {
                        $.data(this, pluginName,
                            new Plugin(this, options));
                    }
                });
            };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /*  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "review-space";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.review();
            },
            review: function () {
                var that = this;
                $('.fa-star').click(function () {
                    var parent = $(this).parent('p');
                    var type = parent.data('type');
                    var point = $(this).data('point');
                    $('#' + type).val(point);
                    parent.find('.fa-star').each(function () {
                        if ($(this).data('point') <= point) {
                            $(this).addClass('text-default');
                        } else {
                            $(this).removeClass('text-default');
                        }
                    });
                });
            },

        },

            $.fn[pluginName] = function (options) {
                return this.each(function () {
                    if (!$.data(this, pluginName)) {
                        $.data(this, pluginName,
                            new Plugin(this, options));
                    }
                });
            };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /**
     *  @name  init menu
     *  @description list view
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "nav";

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.setActive();
            },
            setActive: function () {
                var urlrequest = $('#left-nav').data('request');
                $('.sidebar ul.nav li a').each(function () {
                    if ($(this).attr('href') == urlrequest) {
                        $(this).parent().addClass('active');
                    }
                });
            }
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);
    /**
     *  @name  init menu
     *  @description list view
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "space-detail";

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.drawChart();
                var startDate = $('.main-container').data('date-booking-from');
                var endDate = $('.main-container').data('date-booking-to');
                that.initCalendar(startDate, endDate);
            },
            drawChart: function () {
                // Load the Visualization API and the corechart package.
                google.charts.load('current', {'packages': ['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.charts.setOnLoadCallback(drawChart);

                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawChart() {

                    // Set chart options
                    var options = {
                        // 'title': 'How Much Pizza I Ate Last Night',
                        // 'width': 400,
                        // 'height': 300
                    };
                    var options = {
                        annotations: {
                            textStyle: {
                                fontName: 'Times-Roman',
                                fontSize: 18,
                                bold: true,
                                italic: true,
                                // The color of the text.
                                color: '#871b47',
                                // The color of the text outline.
                                auraColor: '#d799ae',
                                // The transparency of the text.
                                opacity: 0.8
                            }
                        }
                    };
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '');
                    data.addColumn('number', 'Listing views');
                    data.addColumn('number', 'Add to wishlists');
                    data.addColumn('number', 'Resevation');
                    data.addRows([
                        ['May 1, 2016', 4, 4, 5],
                        ['May 2, 2016', 6, 4, 5],
                        ['May 3, 2016', 21, 4, 5],
                        ['May 4, 2016', 3, 24, 5],
                        ['May 5, 2016', 3, 23, 5],
                        ['May 6, 2016', 3, 4, 25],
                        ['May 7, 2016', 3, 24, 5],
                        ['May 8, 2016', 3, 22, 5],
                        ['May 9, 2016', 3, 4, 15],
                        ['May 10, 2016', 3, 4, 25],
                        ['May 11, 2016', 3, 4, 25],
                        ['May 12, 2016', 3, 4, 25],
                        ['May 13, 2016', 3, 4, 5],
                        ['May 14, 2016', 3, 4, 13],
                        ['May 15, 2016', 3, 4, 15],
                        ['May 16, 2016', 16, 4, 5],
                        ['May 17, 2016', 3, 24, 5],
                        ['May 18, 2016', 3, 21, 5],
                        ['May 19, 2016', 3, 18, 5],
                        ['May 20, 2016', 3, 15, 5],
                        ['May 21, 2016', 3, 12, 5],
                        ['May 22, 2016', 3, 4, 3],
                        ['May 23, 2016', 3, 4, 2],
                        ['May 24, 2016', 3, 4, 15],
                        ['May 25, 2016', 3, 4, 5],
                        ['May 26, 2016', 3, 4, 25],
                        ['May 27, 2016', 23, 4, 5],
                        ['May 28, 2016', 3, 24, 5],
                        ['May 29, 2016', 3, 24, 5],
                        ['May 30, 2016', 3, 24, 5],

                    ]);

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            },
            initCalendar: function (startDate, endDate) {
                var that = this;
                that.calendar = $('#mini-clndr').clndr({
                    template: $('#mini-clndr-template').html(),
                    // events: events,
                    clickEvents: {
                        click: function (target) {

                        },
                        onMonthChange: function (month) {
                        },
                        onYearChange: function (month) {
                        },
                    },

                    adjacentDaysChangeMonth: true,
                    // forceSixRows: true,
                    constraints: {
                        startDate: startDate,
                        endDate: endDate
                    },
                });
                that.loadBookingDate()

            },
            loadBookingDate: function () {
                var bookingDateJsonParsed = $('#mini-clndr').data('bookings');

                var bookingDateArr = [];

                $.each(bookingDateJsonParsed, function (type, booking) {
                    $.each(booking, function (index, key) {
                        var bookingDateArr = [];
                        $.each(key, function (index, year) {
                            $.each(year, function (index, month) {
                                $.each(month, function (index, date) {
                                    bookingDateArr.push(date);
                                });
                            });
                        });
                        if (bookingDateArr.length) {
                            for (var i = 0; i < bookingDateArr.length; i++) {
                                $('.calendar-day-' + bookingDateArr[i]).addClass('booking-date-' + type);
                            }
                        }
                    });
                });
            },
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /**
     *  @name  init menu
     *  @description list view
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "verify-phone-number";

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.sendMessageVerifyPhoneNumber();
                that.verifyPhoneNumber();
            },
            sendMessageVerifyPhoneNumber: function () {
                $('.verify-phone-number').click(function () {
                    var url = $(this).data('url');
                    var phone = $('.phone-need-verify').val();
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            phone: phone,
                        },
                        success: function (result) {
                            if (result.status) {
                            } else {
                            }
                        }
                    });
                });
            },
            verifyPhoneNumber: function () {
                $('.btn-verified-code').click(function () {
                    var url = $('#verified-code').data('url');
                    var code = $('#verified-code').val();
                    if (code == '') {
                        $('#verified-code').addClass('input-error');
                    } else {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                code: code,
                            },
                            success: function (result) {
                                if (result.status) {
                                    window.location.reload();
                                } else {
                                    $('#verified-code').addClass('input-error');
                                    $('.bs-modal-sm-verify-phone .modal-body span').removeClass('display-none');
                                }
                            }
                        });
                    }
                });
                $('#verified-code').keypress(function () {
                    $('#verified-code').removeClass('input-error');
                    $('.bs-modal-sm-verify-phone .modal-body span').addClass('display-none');
                });
            }
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);


    /**
     *  @name  add user
     *  @description list view
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "paging-ajax";

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.loadPage();
            },
            loadPage: function () {
                var that = this;
                $("body").delegate("ul.pagination-ajax a.page", "click", function (e) {
                    e.preventDefault();
                    var url = $(this).attr('rel');
                    var wrap = $(this).parents('.list-paging-ajax');
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (result) {
                            if (result.status) {
                                wrap.html(result.html)
                            }
                        }
                    });

                });
            },
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /**
     *  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "booking-space";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.calendar;
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.drawShape();
                that.booking();
                that.getPrice();
                that.checkAvailableBooking();
                that.getCorrectForm();
            },
            getCorrectForm: function(){
                if ($('.booking-step-0').length || $('.booking-step-1').length) {
                    $('#app_booking_bookingPeriod').hide().attr('required',false);
                    $('#app_booking_bookingType_0').click(function(){
                        $('.btn-submit').attr('disabled',false);
                        $('.available').html('');
                        $('#app_booking_bookingPeriod').hide().attr('required',false);
                        $('#app_booking_dateFrom').val('');
                        $('#app_booking_dateTo').show().attr('required',true).val('');
                        if($('.price').length){
                            $('.price').html('N/A');
                        }
                    });
                    $('#app_booking_bookingType_1').click(function(){
                        $('.btn-submit').attr('disabled',false);
                        $('.available').html('');
                        $('#app_booking_bookingPeriod').show().attr('required',true).val('');
                        $('#app_booking_dateFrom').val('');
                        $('#app_booking_dateTo').hide().attr('required',false);
                        if($('.price').length){
                            $('.price').html('N/A');
                        }
                    });
                    $('#app_booking_bookingType_2').click(function(){
                        $('.btn-submit').attr('disabled',false);
                        $('.available').html('');
                        $('#app_booking_bookingPeriod').show().attr('required',true).val('');
                        $('#app_booking_dateFrom').val('');
                        $('#app_booking_dateTo').hide().attr('required',false);
                        if($('.price').length){
                            $('.price').html('N/A');
                        }
                    });
                    if($('#app_booking_bookingType input:checked').val() =='DAILY'){
                        $('#app_booking_bookingPeriod').hide().attr('required',false);
                        $('#app_booking_dateTo').show().attr('required',true);
                    }else{
                        $('#app_booking_bookingPeriod').show().attr('required',true);
                        $('#app_booking_dateTo').hide().attr('required',false);
                    }
                }
            },
            getPrice: function () {
                if ($('.booking-step-1').length) {
                    $('#app_booking_dateFrom').change(function () {
                        if($('#app_booking_bookingType input:checked').val() =='DAILY'){
                            if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_dateTo').val() != '') {
                                getPrice();
                            }
                        }else{
                            if ($('#app_booking_dateFrom').val() != '') {
                                getPrice();
                            }
                        }
                    });
                    $('#app_booking_dateTo').change(function () {
                        if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_dateTo').val() != '') {
                            getPrice();
                        }
                    });
                    $('#app_booking_bookingPeriod').change(function () {
                        if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_bookingPeriod').val() != '') {
                            getPrice();
                        }
                    });
                    function getPrice() {
                        var fromDate = $('#app_booking_dateFrom').val();
                        var toDate = $('#app_booking_dateTo').val();
                        var bookingType = $('#app_booking_bookingType input:checked').val();
                        var period = parseInt($('#app_booking_bookingPeriod').val());
                        var pricePerDay = parseFloat($('.price-per-day').html());
                        var pricePerWeek = parseFloat($('.price-per-week').html());
                        var pricePerMonth = parseFloat($('.price-per-month').html());
                        var price = 0;
                        if(bookingType == 'DAILY'){
                            var numberDate = daydiff(parseDate(fromDate), parseDate(toDate))+1;
                            price = numberDate * pricePerDay;
                        }else if(bookingType == 'WEEKLY'){
                            price = period * pricePerWeek;
                        }else if(bookingType == 'MONTHLY'){
                            price = period * pricePerMonth;
                        }
                        price = Number((price).toFixed(1));
                        $('.price').html(price);

                    }
                    function parseDate(str) {
                        var mdy = str.split('/');
                        return new Date(mdy[2], mdy[0]-1, mdy[1]);
                    }

                    function daydiff(first, second) {
                        return Math.round((second-first)/(1000*60*60*24));
                    }
                }
            },
            checkAvailableBooking: function () {
                if ($('.check-date-available').length) {
                    $('#app_booking_dateFrom').change(function () {
                        if($('#app_booking_bookingType input:checked').val() =='DAILY'){
                            if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_dateTo').val() != '') {
                                checkDate();
                            }
                        }else{
                            if ($('#app_booking_dateFrom').val() != '') {
                                checkDate();
                            }
                        }
                    });
                    $('#app_booking_dateTo').change(function () {
                        if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_dateTo').val() != '') {
                            checkDate();
                        }
                    });
                    $('#app_booking_bookingPeriod').change(function () {
                        if ($('#app_booking_dateFrom').val() != '' && $('#app_booking_bookingPeriod').val() != '') {
                            checkDate();
                        }
                    });
                    function checkDate() {
                        var url = $('.check-date-available').data('url-check-date');
                        var fromDate = $('#app_booking_dateFrom').val();
                        var toDate = $('#app_booking_dateTo').val();
                        var bookingType = $('#app_booking_bookingType input:checked').val();
                        var period = $('#app_booking_bookingPeriod').val();
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                'fromDate': fromDate,
                                'toDate': toDate,
                                'bookingType': bookingType,
                                'period': period,
                            },
                            success: function (result) {
                                if (result.status) {
                                    if (result.available) {
                                        $('.available').html('Available');
                                        $('.btn-submit').attr('disabled',false);
                                    } else {
                                        $('.available').html('Unavailable');
                                        $('.btn-submit').attr('disabled',true);
                                    }
                                }
                            }
                        });
                    }
                }
            },
            booking: function () {

                var publishableKey = $("#payment-form").data('publishable-key');
                Stripe.setPublishableKey(publishableKey);

                function stripeResponseHandler(status, response) {
                    if (response.error) {
                        // re-enable the submit button
                        $('.submit-button').removeAttr("disabled");
                        // show the errors on the form
                        $(".payment-errors").html(response.error.message);
                    } else {
                        var form$ = $("#payment-form");
                        // token contains id, last4, and card type
                        var token = response['id'];
                        var cardNumber = $('.card-number').val();
                        var cardNameHolder = $('.card-name-holder').val();
                        // insert the token into the form so it gets submitted to the server
                        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                        form$.append("<input type='hidden' name='fromStep2' value='1' />");
                        form$.append("<input type='hidden' name='card-number' value='"+cardNumber+"' />");
                        form$.append("<input type='hidden' name='card-name-holder' value='"+cardNameHolder+"' />");
                        // and submit
                        form$.get(0).submit();
                    }
                }

                $("#payment-form").submit(function (event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val(),
                        name: $('.card-name-holder').val(),
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            },
            drawShape: function () {
                var that = this;
                var width = $('.map').parent('div').width();
                $('.map').width(width).height(width / 2);
                function initialize() {
                    var goo = google.maps,
                        map_in = new goo.Map(document.getElementById('map'),
                            {
                                zoom: 20,
                                center: new goo.LatLng(43, -88)
                            }),
                        shapes = [],
                        selected_shape = null,
                        drawman = new goo.drawing.DrawingManager({
                            map: map_in,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [
                                    // google.maps.drawing.OverlayType.POLYGON,
                                ]
                            },
                            polygonOptions: {
                                fillColor: '#ff0000',
                                strokeColor: '#ff0000',
                            }
                        }),


                        byId = function (s) {
                            return document.getElementById(s)
                        },
                        clearSelection = function () {
                            if (selected_shape) {
                                selected_shape.set((selected_shape.type
                                    ===
                                    google.maps.drawing.OverlayType.MARKER
                                ) ? 'draggable' : 'editable', false);
                                selected_shape = null;
                            }
                        },
                        setSelection = function (shape) {
                            clearSelection();
                            selected_shape = shape;

                            selected_shape.set((selected_shape.type
                                ===
                                google.maps.drawing.OverlayType.MARKER
                            ) ? 'draggable' : 'editable', true);

                        },
                        clearShapes = function () {
                            for (var i = 0; i < shapes.length; ++i) {
                                shapes[i].setMap(null);
                            }
                            shapes = [];

                            shapes = IO.OUT([], map_in);
                        };

                    goo.event.addListener(drawman, 'overlaycomplete', function (e) {
                        var shape = e.overlay;
                        shape.type = e.type;
                        goo.event.addListener(shape, 'click', function () {
                            setSelection(this);
                        });
                        setSelection(shape);
                        shapes.push(shape);
                    });

                    goo.event.addListener(map_in, 'click', clearSelection);
                    if (byId('app_space_space_shape').value != '') {
                        shapes = IO.OUT(JSON.parse(byId('app_space_space_shape').value), map_in);
                    }

                }


                var IO = {
                    //returns array with storable google.maps.Overlay-definitions
                    IN: function (arr,//array with google.maps.Overlays
                                  encoded//boolean indicating whether pathes should be stored encoded
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];
                            tmp = {type: this.t_(shape.type), id: shape.id || null};


                            switch (tmp.type) {
                                case 'CIRCLE':
                                    tmp.radius = shape.getRadius();
                                    tmp.geometry = this.p_(shape.getCenter());
                                    break;
                                case 'MARKER':
                                    tmp.geometry = this.p_(shape.getPosition());
                                    break;
                                case 'RECTANGLE':
                                    tmp.geometry = this.b_(shape.getBounds());
                                    break;
                                case 'POLYLINE':
                                    tmp.geometry = this.l_(shape.getPath(), encoded);
                                    break;
                                case 'POLYGON':
                                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                                    break;
                            }
                            shapes.push(tmp);
                        }

                        return shapes;
                    },
                    //returns array with google.maps.Overlays
                    OUT: function (arr,//array containg the stored shape-definitions
                                   map//map where to draw the shapes
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            map = map || null,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];

                            switch (shape.type) {
                                case 'CIRCLE':
                                    tmp = new goo.Circle({
                                        radius: Number(shape.radius),
                                        center: this.pp_.apply(this, shape.geometry)
                                    });
                                    break;
                                case 'MARKER':
                                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                                    break;
                                case 'RECTANGLE':
                                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                                    break;
                                case 'POLYLINE':
                                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                                    break;
                                case 'POLYGON':
                                    tmp = new goo.Polygon({
                                        paths: this.mm_(shape.geometry),
                                        fillColor: '#ff0000',
                                        strokeColor: '#ff0000',
                                    });
                                    map.setCenter(new google.maps.LatLng(shape.geometry[0][0][0], shape.geometry[0][0][1]));

                                    break;
                            }
                            tmp.setValues({map: map, id: shape.id})
                            shapes.push(tmp);
                        }
                        return shapes;
                    },
                    l_: function (path, e) {
                        path = (path.getArray) ? path.getArray() : path;
                        if (e) {
                            return google.maps.geometry.encoding.encodePath(path);
                        } else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.p_(path[i]));
                            }
                            return r;
                        }
                    },
                    ll_: function (path) {
                        if (typeof path === 'string') {
                            return google.maps.geometry.encoding.decodePath(path);
                        }
                        else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.pp_.apply(this, path[i]));
                            }
                            return r;
                        }
                    },

                    m_: function (paths, e) {
                        var r = [];
                        paths = (paths.getArray) ? paths.getArray() : paths;
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.l_(paths[i], e));
                        }
                        return r;
                    },
                    mm_: function (paths) {
                        var r = [];
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.ll_.call(this, paths[i]));

                        }
                        return r;
                    },
                    p_: function (latLng) {
                        return ([latLng.lat(), latLng.lng()]);
                    },
                    pp_: function (lat, lng) {
                        return new google.maps.LatLng(lat, lng);
                    },
                    b_: function (bounds) {
                        return ([this.p_(bounds.getSouthWest()),
                            this.p_(bounds.getNorthEast())]);
                    },
                    bb_: function (sw, ne) {
                        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                            this.pp_.apply(this, ne));
                    },
                    t_: function (s) {
                        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
                        for (var i = 0; i < t.length; ++i) {
                            if (s === google.maps.drawing.OverlayType[t[i]]) {
                                return t[i];
                            }
                        }
                    }

                }
                google.maps.event.addDomListener(window, 'load', initialize);

            },
            uploadImageSpace: function () {
                var myFileInput = $('#space-image');
                myFileInput.change(function () {
                    var url = myFileInput.data('href');
                    var data = document.querySelector("#form-space");
                    var formData = new FormData(data);
                    formData.append("CustomField", "This is some extra data");
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (response) {
                            if (response.status) {
                                var html = '<div width="165px;" height="102px;" class="col-md-4" style="margin-top: 2px"><img src="' + response.url + '"></div>';
                                $('.wrap-img-space').append(html);
                                $('#space-image').val('');
                            }
                        }
                    });
                });
            },
        }

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

    /**
     *  @name  Job Type
     *  @description Map
     *  @version 1.0
     *  @options
     *    option
     *  @events
     *    event
     *  @methods
     *    init
     */
    (function ($, window, document, undefined) {
        var pluginName = "plot-space";
        var map
        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, $.fn[pluginName].defaults, options);
            this.init();
        }

        Plugin.prototype = {
            init: function () {
                var that = this;
                that.drawShape();
            },
            drawShape: function () {
                var that = this;
                var width = 598;
                $('.map_plot').width(width).height(width/2);
                function initialize(that) {
                    var lat = $('.map_plot').data('lat');
                    var lng = $('.map_plot').data('lng');
                    var goo = google.maps,
                        map_in = new goo.Map(document.getElementById('map_in_plot'),
                            {
                                zoom: 20,
                                center: new goo.LatLng(lat, lng)
                            }),
                        shapes = [],
                        selected_shape = null,
                        drawman = new goo.drawing.DrawingManager({
                            map: map_in,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: [
                                    google.maps.drawing.OverlayType.POLYGON,
                                ]
                            },
                            polygonOptions: {
                                fillColor: '#ff0000',
                                strokeColor: '#ff0000',
                            }
                        }),



                        byId = function (s) {
                            return document.getElementById(s)
                        },
                        clearSelection = function () {
                            if (selected_shape) {
                                selected_shape.set((selected_shape.type
                                    ===
                                    google.maps.drawing.OverlayType.MARKER
                                ) ? 'draggable' : 'editable', false);
                                selected_shape = null;
                            }
                        },
                        setSelection = function (shape) {
                            clearSelection();
                            selected_shape = shape;

                            selected_shape.set((selected_shape.type
                                ===
                                google.maps.drawing.OverlayType.MARKER
                            ) ? 'draggable' : 'editable', true);

                        },
                        clearShapes = function () {
                            for (var i = 0; i < shapes.length; ++i) {
                                shapes[i].setMap(null);
                            }
                            shapes = [];

                            shapes = IO.OUT([], map_in);
                        };

                    that.map = map_in;

                    goo.event.addListener(drawman, 'overlaycomplete', function (e) {
                        var shape = e.overlay;
                        shape.type = e.type;
                        goo.event.addListener(shape, 'click', function () {
                            setSelection(this);
                        });
                        setSelection(shape);
                        shapes.push(shape);
                    });

                    goo.event.addListener(map_in, 'click', clearSelection);
                    goo.event.addDomListener(byId('clear_shapes'), 'click', clearShapes);
                    goo.event.addDomListener(byId('save'), 'click', function () {
                        var data = IO.IN(shapes, false);
                        byId('app_plot_space_spaceShape').value = JSON.stringify(data);
                    });
                    // if (byId('app_space_space_shape').value != '') {
                    //     shapes = IO.OUT(JSON.parse(byId('app_space_space_shape').value), map_in);
                    // }
                }


                var IO = {
                    //returns array with storable google.maps.Overlay-definitions
                    IN: function (arr,//array with google.maps.Overlays
                                  encoded//boolean indicating whether pathes should be stored encoded
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];
                            tmp = {type: this.t_(shape.type), id: shape.id || null};


                            switch (tmp.type) {
                                case 'CIRCLE':
                                    tmp.radius = shape.getRadius();
                                    tmp.geometry = this.p_(shape.getCenter());
                                    break;
                                case 'MARKER':
                                    tmp.geometry = this.p_(shape.getPosition());
                                    break;
                                case 'RECTANGLE':
                                    tmp.geometry = this.b_(shape.getBounds());
                                    break;
                                case 'POLYLINE':
                                    tmp.geometry = this.l_(shape.getPath(), encoded);
                                    break;
                                case 'POLYGON':
                                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                                    break;
                            }
                            shapes.push(tmp);
                        }

                        return shapes;
                    },
                    //returns array with google.maps.Overlays
                    OUT: function (arr,//array containg the stored shape-definitions
                                   map//map where to draw the shapes
                    ) {
                        var shapes = [],
                            goo = google.maps,
                            map = map || null,
                            shape, tmp;

                        for (var i = 0; i < arr.length; i++) {
                            shape = arr[i];

                            switch (shape.type) {
                                case 'CIRCLE':
                                    tmp = new goo.Circle({
                                        radius: Number(shape.radius),
                                        center: this.pp_.apply(this, shape.geometry)
                                    });
                                    break;
                                case 'MARKER':
                                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                                    break;
                                case 'RECTANGLE':
                                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                                    break;
                                case 'POLYLINE':
                                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                                    break;
                                case 'POLYGON':
                                    tmp = new goo.Polygon({
                                        paths: this.mm_(shape.geometry),
                                        fillColor: '#ff0000',
                                        strokeColor: '#ff0000',
                                    });
                                    map.setCenter(new google.maps.LatLng(shape.geometry[0][0][0], shape.geometry[0][0][1]));

                                    break;
                            }
                            tmp.setValues({map: map, id: shape.id})
                            shapes.push(tmp);
                        }
                        return shapes;
                    },
                    l_: function (path, e) {
                        path = (path.getArray) ? path.getArray() : path;
                        if (e) {
                            return google.maps.geometry.encoding.encodePath(path);
                        } else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.p_(path[i]));
                            }
                            return r;
                        }
                    },
                    ll_: function (path) {
                        if (typeof path === 'string') {
                            return google.maps.geometry.encoding.decodePath(path);
                        }
                        else {
                            var r = [];
                            for (var i = 0; i < path.length; ++i) {
                                r.push(this.pp_.apply(this, path[i]));
                            }
                            return r;
                        }
                    },

                    m_: function (paths, e) {
                        var r = [];
                        paths = (paths.getArray) ? paths.getArray() : paths;
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.l_(paths[i], e));
                        }
                        return r;
                    },
                    mm_: function (paths) {
                        var r = [];
                        for (var i = 0; i < paths.length; ++i) {
                            r.push(this.ll_.call(this, paths[i]));

                        }
                        return r;
                    },
                    p_: function (latLng) {
                        return ([latLng.lat(), latLng.lng()]);
                    },
                    pp_: function (lat, lng) {
                        return new google.maps.LatLng(lat, lng);
                    },
                    b_: function (bounds) {
                        return ([this.p_(bounds.getSouthWest()),
                            this.p_(bounds.getNorthEast())]);
                    },
                    bb_: function (sw, ne) {
                        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                            this.pp_.apply(this, ne));
                    },
                    t_: function (s) {
                        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
                        for (var i = 0; i < t.length; ++i) {
                            if (s === google.maps.drawing.OverlayType[t[i]]) {
                                return t[i];
                            }
                        }
                    }

                }
                google.maps.event.addDomListener(window, 'load', initialize(that));
                $('#plot-space').on('shown.bs.modal', function () {
                    google.maps.event.trigger(that.map, "resize");
                })

            }
        };
        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName,
                        new Plugin(this, options));
                }
            });
        };
        $.fn[pluginName].defaults = {
            propertyName: 1
        };
        $(function () {
            $('[data-' + pluginName + ']')[pluginName]();
        });

    })(jQuery, window, document);

});