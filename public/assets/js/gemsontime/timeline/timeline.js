(function( $ ) {
    var Timeline = function(element, options){
        var $timeline = $(element);

        var settings = $.extend({
            minDate:          "2013-04-01",
            monthsToMaxDate:  1,
            pixelPerMinute:   1,
            urlGetEvents:     "/events/1",
            eventCardWidth:   140,
            eventCardHeight:  65,
            verticalEventGap: 15,
            verticalLineGap:  20,
            //колво экранов в сторону от правого и левого концов - загружаемый отрезок
            screensToLoad: 1.5
        }, options);

        var windowWidth = $(window).width();
        var halfWindowWidth = Math.floor(windowWidth / 2);

        function Line(isMine)
        {
            this.isMine = isMine;
            this._init();
        }
        Line.prototype = {
            isMine: 0,
            height: 0,
            element: '',
            _init: function()
            {
                this.element = $('<div>', {class: 'line'});
                this.element.css('margin-top', settings.verticalLineGap);
                $timeline.append(this.element);
            },
            appendEvent: function(element)
            {
                this.element.append(element);
            },
            adjustHeight: function(event)
            {
                var height = event.top + settings.eventCardHeight;
                if(height > this.height){
                    this.height = height;
                    this.element.css('height', this.height);
                }
            }
        }
        var lineMine, lineCommon;

        var getLine = function(isMine)
        {
            return (isMine === '1') ? lineMine : lineCommon;
        }

        var getWidth = function()
        {
            var now = moment();
            var maxDate = now.add('months', settings.monthsToMaxDate);
            var margin = maxDate.diff(moment(), 'minutes') * settings.pixelPerMinute;
            return margin + getMarginFromMinDate(moment());
        }

        var init = function()
        {
            $timeline.css("width", getWidth());

            timeScale.init();
            lineMine = new Line(1);
            lineCommon = new Line(0);

            loader._init();
        }

        var getMarginFromMinDate = function(date)
        {
            var date = moment(date);
            var minDate = moment(settings.minDate);
            var margin = (date.diff(minDate, 'minutes') * settings.pixelPerMinute);
            return(margin);
        }

        this.getMarginFromMinDateForOverscroll = function(date)
        {
            return getMarginFromMinDate(date) - halfWindowWidth;
        }

        this.load = function(position)
        {
            loader.adjustPositionAndLoad(position - halfWindowWidth);
        }

        var eventsRegistry = {
            events: [],
            add : function(event)
            {
                if(this.events[event.id] === undefined){
                    this.events[event.id] = event;

                    event.width = settings.eventCardWidth;
                    event.height = settings.eventCardHeight
                    this._appendToLine(event);
                }
            },

            _appendToLine: function(event)
            {
                this._calcEventLeft(event);
                this._calcEventTop(event);
                var line = getLine(event.isMine);
                line.appendEvent(event.render());
                line.adjustHeight(event);
            },

            _calcEventLeft: function(event)
            {
                var date = moment(event.date);
                event.left = getMarginFromMinDate(date);
            },

            _calcEventTop: function(event)
            {
                var eventBegin = parseInt(event.left);
                var eventEnd = parseInt(event.left) + parseInt(settings.eventCardWidth);
                var eventIsMine = event.isMine;
                var eventId = event.id;
                var crossingEvents = $.grep(this.events, function(num, index){
                    if(num !== undefined){
                        var currentEventBegin = parseInt(num.left);
                        var currentEventEnd = parseInt(num.left) + parseInt(settings.eventCardWidth);
                        //ищем события которые находятся на одной линии с текущим и которые по своему местоположению
                        // пересекают его
                        return num.isMine === eventIsMine &&
                            num.id !== eventId &&
                            ((currentEventBegin >= eventBegin &&
                                currentEventBegin <= eventEnd) ||
                                (currentEventEnd >= eventBegin &&
                                    currentEventEnd <= eventEnd));

                    }});
                event.top = (settings.eventCardHeight + settings.verticalEventGap) * crossingEvents.length;
            }
        }

        var timeScale = {
            element: $('<div>', {class: 'scale'}),
            init: function()
            {
                $timeline.append(this.element);
            },
            renderByPeriod: function(bDate, eDate)
            {
                var step = 60;
                var items = [];
                var bDateInp = getMarginFromMinDate(bDate);
                var eDateInp = getMarginFromMinDate(eDate);
                for(var i = bDateInp; i < eDateInp; i = i + step){
                    var element = $('<div>');
                    element.css('left', i)
                        .css('width', step)
                        .html(moment(bDate).add('minutes', i).hour());
                    items.push(element);
                }
                this.element.append(items);
            }
        }

        var loader = {
            beginPosition: 0,
            endPosition: 0,
            _delta: settings.screensToLoad * windowWidth,

            _init: function()
            {
                var begin = getMarginFromMinDate(moment());
                this.beginPosition = begin - this._delta;
                this.endPosition = begin + this._delta;

                this._load(this.beginPosition, this.endPosition);
                return this;
            },

            _load: function(beginPosition, endPosition)
            {
                var bDate = this._getDate(beginPosition);
                var eDate = this._getDate(endPosition);
                timeScale.renderByPeriod(bDate, eDate);
                $.ajax({
                    type: "GET",
                    url: settings.urlGetEvents + "/" + bDate + "/" + eDate,
                    dataType: "json",
                    async : true,
                    success: function(data){
                        $.each(data, function(i, event){
                            var eventObj = new Event(event);
                            eventsRegistry.add(eventObj);
                        });
                    }
                });
                return this;
            },

            _getDate: function(position)
            {
                var date = moment(settings.minDate).add('minutes', position);
                return(moment(date).format('YYYY-MM-DD HH'));
            },

            adjustPositionAndLoad: function(position)
            {
                if(position < this.beginPosition){
                    this._load(position - this._delta, this.beginPosition);
                    this.beginPosition = position - this._delta;
                }else if(position > this.endPosition){
                    this._load(this.endPosition, position + this._delta);
                    this.endPosition = position + this._delta;
                }
            }
        }

        init();
    }

    $.fn.timeline = function(options)
    {
        return this.each(function()
        {
            var element = $(this);
            if (element.data('timeline')) {
                return;
            }

            var tl = new Timeline(this, options);
            element.data('timeline', tl);
        });
    };
})(jQuery);









