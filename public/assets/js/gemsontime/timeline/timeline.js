(function( $ ) {
    var Timeline = function(element, options){
        var $timeline = $(element);

        var settings = $.extend({
            minDate:          "2013-04-01",
            monthsToMaxDate:  1,
            pixelPerMinute:   1,
            urlGetEvents:     "/events/1",
            urlGetIdeas:     "/events/ideas/1",
            eventCardWidth:   140,
            eventCardWidthMax:   300,
            eventCardWidthMin: 100,
            eventCardHeight:  100,
            verticalEventGap: 15,
            verticalLineGap:  20,
            ideaWidth:		  200,
            ideaPeriod: 	  50,
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
        
        var getRandLeftInInterval = function(event,dbeg,dend)
        {
        	var dbeg = moment(dbeg);
            var dend = moment(dend);
            var diff = dend.diff(dbeg, 'minutes');
            
            var left = Math.random() * diff;
            
            var randDate = moment(dbeg).add('minutes', left);

            var margin = getMarginFromMinDate(randDate);
            return(margin);
        }

        this.getMarginFromMinDateForOverscroll = function(date)
        {
            return getMarginFromMinDate(date) - halfWindowWidth;
        }

        this.load = function(position)
        {
            loader.adjustPositionAndLoad(position - halfWindowWidth);
            
            var screenCenter = getScreenCenterDate(position);
            
            loader.fillIdeas(screenCenter);
        }
        
        var getScreenCenterDate = function(position)
        {
            var ScreenCenter = position - halfWindowWidth;
            
            var screenCenterDate = getDateFromPosition(ScreenCenter);

            $("#marker").text(moment(screenCenterDate).format('DD.MM.YYYY HH:mm'));
            
            return screenCenterDate;
        }
        
        var getDateFromPosition = function(position)
        {
            return moment(settings.minDate).add('minutes', position);
        }

        var eventsRegistry = {
            events: [],
            
            add : function(event)
            {
                if(this.events[event.id] === undefined){
                    this.events[event.id] = event;

                    event.width = settings.eventCardWidth;
                    event.height = settings.eventCardHeight;
                    this._appendToLine(event);
                }
            },

            _appendToLine: function(event)
            {
                this._calcEventLeft(event);
                this._calcEventTop(event);
                this._calcEventWidth(event);
                var line = getLine(event.isMine);
                line.appendEvent(event.render());
                
                if(event.needShadow){
                	line.appendEvent(event.renderShadow());
                }
                
                this._checkOpacity(event);
                
                line.adjustHeight(event);
            },

            _calcEventLeft: function(event)
            {
				var date = moment(event.startdate);
				event.left = getMarginFromMinDate(date);
            },
            
            _checkOpacity: function(event)
            {
            	//если событие неопределенное, то делаем его полупрозрачным
            	//TODO ввести признак Неопределенности, иметь его в объекте события 
            	if(event.id==1){
					$("#event_"+event.id).css("opacity", 0.5);
				}
            },
            
            _calcEventWidth: function(event)
            {
                var startdate = moment(event.startdate);
                var enddate = moment(event.enddate);
                
                if(enddate!=null) {
                	var duration = enddate.diff(startdate, 'minutes');
                	event.duration = duration;
                	
	            	var width = duration * settings.pixelPerMinute;
	            	
	            	if(width>settings.eventCardWidthMax) {
	            		event.width = settings.eventCardWidthMax;
	            		event.actualWidth = width;
	            		event.needShadow = true;
	            	} else if(width<settings.eventCardWidthMin) {
	            		event.width = settings.eventCardWidthMin;
	            		event.actualWidth = width;
	            	} else
	            		event.width = width;
	            }
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
                var j=0;	// счетчик для времени. i - счетчик для координаты
                
                for(var i = bDateInp; i < eDateInp; i = i + step){
                    var element = $('<div>');
                    var newDate = moment(bDate).add('minutes', j);
                    var hour = newDate.hour();
                    
                    if(hour=="0") {
                    	var text = newDate.format('DD.MM')+": "+hour;
                    	element.css('background-color', "orange");
                    }
                    else
                    	var text = hour;
                    	  
                    element.css('left', i)
                        .css('width', step)
                        .html(text);
                    
                    items.push(element);
                    
                    j = j + step;
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
                
                var position = (this.endPosition-this.beginPosition)/2+this.beginPosition;
                var screenCenter = getScreenCenterDate(position);
                
	            loader.fillIdeas(screenCenter);
                
                return this;
            },
            
            fillIdeas: function(screenCenter)
            {
            	ideasRegistry.fillIdeas(screenCenter);
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
            },

            
            loadAndFillIdeas: function(screenCenterDate)
            {
            	var pDate = moment(screenCenterDate).format('YYYY-MM-DD HH');
            	
                $.ajax({
                    type: "GET",
                    url: settings.urlGetIdeas + "/" + pDate,
                    dataType: "json",
                    async : true,
                    success: function(data){
                        ideasRegistry.saveAndFillIdeas(data,screenCenterDate);
                    }
                });
            }
        }
        
        var ideasRegistry = {
            events: {},
            events_length: 0,
            
            bunches_length: 0,
            iBunches: {},
            iBunch: {
            	date: "",
            	ideas: {}
            },
            
            fillIdeas: function(screenCenterDate)
            {
            	var ideasBunch = this.findBunchForDate(screenCenterDate);
            	
            	if(ideasBunch===undefined) {
            		ideas = loader.loadAndFillIdeas(screenCenterDate);
            	}
            },
            
            saveAndFillIdeas: function(data,screenCenterDate)
            {
            	var ideasBunch = this.saveBunch(data,screenCenterDate);
            	
            	if(ideasBunch!=undefined)
            		this.fillIdeasDiv(ideasBunch);
            },
            
            fillIdeasDiv : function(ideasBunch)
            {
            	$(".idea").remove();
            	
            	for(var i=0; i<ideasBunch.count; i++)
                    this._append(ideasBunch.ideas[i],ideasBunch.date);
            },
            
            findBunchForDate : function(date)
            {	
            	for(var i=0; i<this.bunches_length; i++)
            	{
            		if(this.iBunches[i].date==date)
            			return this.iBunches[i]; 
            	}
            },
            
            saveBunch : function(data,date)
            {
            	var iBunch = {};
            	iBunch.date=date;
            	iBunch.ideas={};
            		
                $.each(data, function(i, event){
                    var eventObj = new Event(event);
                    
                    iBunch.ideas[i]=eventObj;
                    iBunch.count=i+1;
                });
                
                this.iBunches[this.bunches_length]=iBunch;
                this.bunches_length++;
                
                return iBunch;
            },

            _append: function(event,date)
            {
                var Ideas = $("#ideas");
                event.width = settings.ideaWidth;
                
                var idea = event.renderIdea();
                
                idea.css("left", (this.events_length-1)*(settings.ideaWidth+settings.ideaPeriod));
                
                Ideas.append(idea);
                
                // рассчитаем параметры для тени на таймлайн, аналогичные рассчитываются 
                var startdate = moment(event.startdate);
				event.left = getMarginFromMinDate(startdate);
				
                var enddate = moment(event.enddate);
	            if(enddate!=null) {
                	var duration = enddate.diff(startdate, 'minutes');
                	event.duration = duration;
                	
	            	var width = duration * settings.pixelPerMinute;
	            	
	            	if(width>settings.eventCardWidthMax) {
	            		event.width = settings.eventCardWidthMax;
	            		event.actualWidth = width;
	            		event.needShadow = true;
	            	} else if(width<settings.eventCardWidthMin) {
	            		event.width = settings.eventCardWidthMin;
	            		event.actualWidth = width;
	            	} else
	            		event.width = width;
	            }
				
               	lineMine.appendEvent(event.renderIdeaShadow());
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