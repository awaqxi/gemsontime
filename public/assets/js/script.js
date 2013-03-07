var bDebug = false;
var o;
//---------------------------------------------------------------------------------------------------------
var oTimeMap = {
	xBegin				:0
	,xEnd				:0
	,xScrollStep		:1000
	,urlGetEvents 		:"/events"
	,urlSubscribe 		:"/events/subscribe"
	,iMyLineCount		:0
	,iOtherLineCount	:0
	,arrMyLines 		:[]
	,arrOtherLines 		:[]
	,xEventLength		:200
	,xEventsPadding		:20
	,iEventCount		:0
	,arrEvents 			:[]
	,arrEventsObj 		:[]
	,dtNow 				:new Date()
	,data 				:""
	,datePeriodBegin	:""
	,x1min				:0


	,Init	:function (){
		if(bDebug)console.log("Init...");

		var now = new Date();
		
		this.datePeriodBegin = DateFuncs.dateAdd("h",-3,now);
		
		this.datePeriodBegin.setHours(this.datePeriodBegin.getHours());
    	this.datePeriodBegin.setMinutes(0);
    	this.datePeriodBegin.setSeconds(0);

		this.datePeriodEnd = DateFuncs.dateAdd("h",3,now);
		this.datePeriodEnd.setHours(this.datePeriodEnd.getHours());
    	this.datePeriodEnd.setMinutes(0);
    	this.datePeriodEnd.setSeconds(0);

		this.x1min = 5;	// шаг 1 минута - 1 пиксель

		this.drawTimeMap();

		$("#NOWpoint").click();
	}


	,drawTimeMap	:function(){
		// изначальное состояние TimeMap
		var s = '<div id="timemap_curtain" class="timemap_curtain">События загружаются...</div>'+
				'<div id="ruler">'+
				'	<ul id="rulerUL" class="ruler" data-items="1"></ul>'+
				'</div>';
		$('#timemap').html(s);

		if(bDebug)console.log("--=== drawTimeMap ===--");

		// обнуление глоб.переменных перед
		this.iMyLineCount = 0;
		this.iOtherLineCount	= 0;
		this.arrMyLines = [];
		this.arrOtherLines = [];
		this.iEventCount = 0;
		this.arrEvents = [];
		this.arrEventsObj = [];

		this.drawRuler();

		this.drawNOWpoint();

		// временно отключаем отрисовку событий
		this.loadTimeData(this.datePeriodBegin,this.datePeriodEnd);

	/*	o = $('#timemap').overscroll({
			wheelDirection: 'horizontal',
		});*/

		$("#timemap_curtain").hide();
	}


	,moveLeft	:function(){
		if(bDebug)console.log("moveLeft...");

    	this.datePeriodBegin = DateFuncs.dateAdd("h",-3,this.datePeriodBegin);

    	this.drawTimeMap();

    	this.scrollLeft(0);
	}


	,moveRight	:function(){
		if(bDebug)console.log("moveRight...");

    	this.datePeriodEnd = DateFuncs.dateAdd("h",3,this.datePeriodEnd);

    	this.drawTimeMap();

    	this.scrollLeft(
    		$("#rulerUL").width()
    	);
	}

	,moveCenter	:function(){
		$("#NOWpoint").click();
	}


	,drawRuler	:function(){
		var min = DateFuncs.diffMinut(this.datePeriodBegin,this.datePeriodEnd);
		var width = min*this.x1min;

		var dateCurrent = this.datePeriodBegin;
		var item;
		var ruler = $("#rulerUL");
		var step = 30*this.x1min;
		var sdate = "";
		var s;

		while(dateCurrent<=this.datePeriodEnd){
			sdate = DateFuncs.getHourMinut(dateCurrent);

			s = "<li style='width:"+step+"px;'>"+sdate+"</li>";
			ruler.append(s);

			dateCurrent = DateFuncs.dateAdd("m",30,dateCurrent);
		}
	}


	,drawNOWpoint	:function(){
		if(bDebug)console.log("drawNOWpoint...");

		var now = new Date();
		var min = DateFuncs.diffMinut(this.datePeriodBegin,now);

		var x = min*this.x1min;

		var s = "<div id='NOWpoint'>"+DateFuncs.getHourMinut(now)+"</div>";
		$("#timemap").append(s);
		$("#NOWpoint").css("left",x);

		$("#NOWpoint").click(this.scrollLeft_byDiv);
	}


	,scrollLeft_byDiv 	:function( data ){
		if(bDebug)console.log("scrollLeft_byDiv...");

		var divEvent = data.currentTarget;	// элемент, по которому кликнули

		xscrollLeft = $("#"+divEvent.id).position().left;
		xscrollLeft = xscrollLeft-$(window).width()/2;

		if(bDebug)console.log("divEvent.id:"+divEvent.id);
		if(bDebug)console.log("xscrollLeft:"+xscrollLeft);

		oTimeMap.scrollLeft(xscrollLeft);
	}

	,scrollLeft 	:function( x ){
		$('#timemap').animate( { scrollLeft: x }, 300);
	}


	,loadTimeData 	:function (dBegin,dEnd) {
		parent_oTimeMap = this;

		$("#timemap_curtain").show();

		if(bDebug)console.log("Load Time Data... : "+dBegin+" - "+dEnd);

	  	// получим события с сервера
	  	var URL = this.urlGetEvents+"/1"+"/"+DateFuncs.getSQLdate(dBegin)+"/"+DateFuncs.getSQLdate(dEnd);
	  	if(bDebug)console.log("this.urlGetEvents: "+URL);

	  	$.getJSON(URL, processGetTimeData );

		function processGetTimeData (data,status) {
			// обрабочик получения событий
			if(bDebug)console.log("processGetTimeData...");
			if(bDebug)console.log(data);

			$.each(data,processEvent);

			function processEvent (i,elmntEvent) {
				if(bDebug)console.log("processEvent... elmntEvent.name:"+elmntEvent.name);
				parent_oTimeMap.addEvent(i,elmntEvent);
			}

			$("#timemap_curtain").hide();

			// почему-то навешивание обработчика срабатывает только здесь. вообще надо бы отсюда куда-нить перенести
			$(".event").click(oTimeMap.scrollLeft_byDiv);
			$(".EventPoint").click(oTimeMap.scrollLeft_byDiv);
		}

		// обновим скроллинг для увеличенной панели
		/*o = $('#timemap').overscroll({
			wheelDirection: 'horizontal',
		});*/

		$("#NOWpoint").css("z-index",999999);
	}

	,addEvent	: function(p_i,oEvent,oUser){
		if(bDebug)console.log("addEvent... Caption: "+oEvent.name);
		if(bDebug)console.log(oEvent);

		// рассчитаем координаты события от времени
		if(bDebug)console.log("oEvent.date: "+oEvent.date);

		oEvent.dateStart = DateFuncs.getDateFromString(oEvent.date);

		var min = DateFuncs.diffMinut(this.datePeriodBegin,oEvent.dateStart);

		// запишем в объект его рассчитанные координаты
		oEvent.xBegin = min*this.x1min;
		oEvent.xEnd = oEvent.xBegin+this.xEventLength;

		var classLine;
		// ВЫБЕРЕМ Мое или Чужое событие
		if(oEvent.isMine==1) {
			iLineCount 	= this.iMyLineCount;
			arrLines	= this.arrMyLines;
			classLine	= "MineLine";
		}
		else {
			iLineCount 	= this.iOtherLineCount;
			arrLines	= this.arrOtherLines;
			classLine	= "line";
		}

		SelectedLine=null;	//на случай когда линий	нет ни одной

		$("."+classLine).each(function(i,element){
			lineWidth = $("#"+element.id).width();

			if(bDebug)console.log("---element: "+element.id+". width: "+lineWidth);

			if(lineWidth < oEvent.xBegin){	//  конец последнего события на линии меньше начала добавляемого
				// выбираем эту линию
				SelectedLine=i;

				if(bDebug)console.log("Break. SelectedLine: "+SelectedLine);

				return false;
			}
		});

		if(SelectedLine==null){
			// ни одна линия не выбрана, создаем
			SelectedLine = this.addLine(oEvent);
		}

		// на этот момент SelectedLine выбрано в цикле или создано и равно 1
		this.addEventToLine(arrLines,SelectedLine,oEvent,p_i);

		this.arrEvents.push(oEvent);
	}


//======================================================================================================
	,addEventToLine	: function(p_arrLine,p_SelectedLine,p_oEvent,p_i){
		var dtNow;

		if(bDebug)console.log("addEventToLine... p_oEvent.name: "+p_oEvent.name);

		this.iEventCount++;

		var xBegin = p_oEvent.xBegin;

		var date = DateFuncs.getDateFromString(p_oEvent.date);
		var min = DateFuncs.getHourMinut(date);
		p_oEvent.dateCap = min;
		if(bDebug)console.log("date: "+date+". min: "+min);

		// нарастим линию по длине
		oLine 	= p_arrLine[p_SelectedLine];
		xEnd 	= xBegin + this.xEventLength;
		$(oLine.divID).css("width",xEnd);

		// добавим событие на линию
		e = new Event();
		e.init(p_oEvent);
		this.arrEventsObj[e.id] = e;
		divID = "#event_"+e.id;
		$(oLine.divID).append(e.render());
		
		var addEventToMyLine = $.proxy(oTimeMap, "addEventToMyLine");	
		$("#event_" + e.id + " a.event_add_url").click(addEventToMyLine);   
		if(bDebug)console.log("#event_ AFETR");
		//$(divID).css("left",xBegin);
		// if(bDebug)console.log($(divID));
		// if(bDebug)console.log("-------------divID: "+divID+". xBegin: "+xBegin);

		this.drawEventPoint(p_oEvent);

		// сохраним новый левый край линии
		p_arrLine[p_SelectedLine].xEndLast = xEnd;

		if(bDebug)console.log("xEndLast: "+p_arrLine[p_SelectedLine].xEndLast+". p_SelectedLine: "+p_SelectedLine);
	}


//======================================================================================================
	,drawEventPoint	:function( p_oEvent ){
		if(bDebug)console.log("<<<<<<<  --- drawEventPoint...");

		var divID = "EventPoint_"+p_oEvent.id;

		var s = "<div id='"+divID+"' class='EventPoint'>"+p_oEvent.dateCap+"</div>";
		$("#ruler").append(s);

		if(bDebug)console.log("x: "+p_oEvent.xBegin);

		$("#"+divID).css("left",p_oEvent.xBegin);
		$("#"+divID).css("top",0);

		// $("#NOWpoint").click(this.scrollLeft_byDiv);
	}


//======================================================================================================
	,addLine 	: function(oEvent) {
		// добавление линии

		if(bDebug)console.log("addLine... p_bMine: "+oEvent.IsMine);

		// ВЫБЕРЕМ Мои или Чужие линии
		if (oEvent.isMine==1) {
			iLineCount 	= this.iMyLineCount;
			arrLines	= this.arrMyLines;
			divClass	= "MineLine";
		}
		else {
			iLineCount 	= this.iOtherLineCount;
			arrLines	= this.arrOtherLines;
			divClass	= "line";
		}

		var divID = ""+divClass+"_"+iLineCount;

		//  div линии
		str = 
			"<div id='"+divID+"' class='"+divClass+"'>"+
			"</div>";
		if(bDebug)console.log("str="+str);

		// добавим линию	
		if(oEvent.isMine==1)
		{
			if(iLineCount==0)	
			{
				//первую "мою линию" добавляем в самый верх
				$("#ruler").after(str);
			}				
			else 
			{				
				var myLineDivID = "MineLine_" + (this.iMyLineCount - 1);								
				$("#" + myLineDivID).after(str);
			}
		}
		else
		{
			if(iLineCount==0)	
			{
				if(this.iMyLineCount == 0)
					$("#timemap").append(str);
				else
				{
					//новую чужую линию добавляем после своих
					var myLineDivID = "MineLine_" + (this.iMyLineCount - 1);								
					$("#" + myLineDivID).after(str);
				}						
			}					
			else 
			{
				$( arrLines[arrLines.length-1].divID ).after(str);
			}
				
		}
		
		// СОХРАНИМ Мои или Чужие линии
		if (oEvent.isMine==1) {
			this.iMyLineCount++;			
			this.arrMyLines.push(
				{divID:"#"+divID}
			);
		}
		else {
			this.iOtherLineCount++;
			this.arrOtherLines.push(
				{divID:"#"+divID}
			);
		}
		// if(bDebug)console.log("str="+str);
		return iLineCount++;
	}
	,addEventToMyLine: function(event){
		var id = event.target.parentNode.id.substring(6);
		
		var URL = this.urlSubscribe + "/1" + "/" + id;	  	
		var events = this.arrEventsObj;
		var addLine = $.proxy(oTimeMap, "addLine");	
		var lineCount = this.iMyLineCount;	
				
	  	$.getJSON(URL, function(data)
	  	{
	  		if(data.result = "OK")
	  		{
	  			var left = $("#" + event.target.parentNode.id).css('left');		
				$("#" + event.target.parentNode.id).remove();
				events[id].isMine = '1';
				addLine(events[id]);		
				$("#MineLine_" + (lineCount)).append(events[id].render());
				$("#" + event.target.parentNode.id).css('left', left);
	  		}	  		
	  	});
		
		return false;
	}
	
};

var event_groups = {
	switch: function(event){
	    //
	    if($(event.target).hasClass('active'))
	    {
	        $('div.' + event.target.id).show();
	    }
	    else
	    {
	        $('div.' + event.target.id).hide();
	    }
	}
}

//---------------------------------------------------------------------------------------------------------
$(document).ready(function() {
	if(bDebug)console.log("ready...");

	// // добавим обработчик на событие нажатия кнопки
	$("#moveLeft").click(moveLeft);
	$("#moveRight").click(moveRight);

	$("#moveCenter").click(moveCenter);
	 $("#moveCenter").click(Test);

	// инициализация TimeMap
	oTimeMap.Init();
	
	//привязываем обработчики нажатия кнопок фильтров
	$("#event_group_switch button").bind("click", event_groups.switch);
});

//---------------------------------------------------------------------------------------------------------
function moveLeft(){
	oTimeMap.moveLeft();
}

//---------------------------------------------------------------------------------------------------------
function moveRight(){
	oTimeMap.moveRight();
}

//---------------------------------------------------------------------------------------------------------
function moveCenter(){
	oTimeMap.moveCenter();
}

//---------------------------------------------------------------------------------------------------------
function Test(){
	if(bDebug)console.log("<<< TEST >>>");
}

