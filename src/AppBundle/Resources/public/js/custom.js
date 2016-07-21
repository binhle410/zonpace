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
            this.drawShape();
        }

        Plugin.prototype = {
            init: function () {

            },
            takeImage: function () {
                $('#map_in').html2canvas({
                    onrendered: function (canvas) {
                        $('#app_space_space_spaceImageTmp').val(canvas.toDataURL("image/png"));
                        // $('.img_val').attr('src',canvas.toDataURL("image/png"));
                        // document.getElementById("myForm").submit();
                    }
                });
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
                        that.takeImage();
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
                var that=this;
                that.initSlider();
                that.searchPlace();
            },
            initSlider: function(){
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
                //init map
                var width = $('.map').parent('div').width();
                var lat = parseFloat($('#lat').val());
                var lng = parseFloat($('#lng').val());
                $('.map').width(width).height(width);
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: lat, lng: lng},
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                //init maker
                var items = $('.search-space-item');
                items.each(function(){
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
                        position: {lat:lat,lng:lng}
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
                var that=this;
                that.initSlider();
                that.searchPlace();
            },
            initSlider: function(){
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

    })(jQuery, window, document);

});