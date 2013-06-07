function Event(entry)
{
    this._init(entry);
}

Event.prototype = {
	id: 0,
	name: '',
	isMine: 0,
	startdate: '',
	enddate: '',
	groupCSS: '',
    left: 0,
    top: 0,
    width: 0,
    height: 0,
    types:[],
    venue: "",
    relation: "",
    timeType: "",
    duration: 0,
    actualWidth: 0,
    needShadow: false,

	_init: function(entry){
		this.id = entry['id'];
		this.name = entry['name'];
		this.isMine = entry['isMine'];
		this.startdate = entry['startdate'];
		this.enddate = entry['enddate'];
		this.venue = entry['venueName'];
		this.relation = entry['userRel'];
		this.timeType = entry['timeType'];

		this.types = new Array();
		for (var key in entry['groupsTypes']) {
			this.types[key]=entry['groupsTypes'][key]['typeName'];
			if(entry['groupsTypes'][key]['isMain'] === '1')
			{
				this.groupCSS = entry['groupsTypes'][key]['groupCSS'];
			}
		}
		
        return this;
	},

	render: function(){
		var id = this.id;
		
		var element = this.getEventElement();
		
		element.attr("id", "event_"+this.id);
		element.attr("class", "event");
		
		//категории
		if(typeof(this.groupCSS) !== "undefined")
		{			
			element.addClass(this.groupCSS);     
		}       

		element.css("left", this.left);
        element.css("width", this.width);
        element.css("height", this.height);

        if(this.top != 0){
            element.css("top", this.top)
        };
		
		//кнопка добавить
		if(this.isMine !== '1')
		{
			var addURL = $('<a>', {href: '#',
			                       class: 'event_add_url'}).html('+');					
						                  
			element.append(addURL);	
		}
		
		// отношение
		var relation = "";
		switch(this.relation)
		{
		case "participant":
		  relation = "Вы идете";
		  break;
		case "saved":
		  relation = "Вы сохранили";
		  break;
		case "friend_participant":
		  relation = "Друг пойдет";
		  break;
		case "friend_saved":
		  relation = "Друг сохранил";
		  break;
		default:
		  relation = "";
		}
		if(relation != ""){
			relation = $('<span>', {class: 'event_relation'}).html(relation);
			element.append(relation);
			element.append('</br>');
		}
		
		// тень длинных событий
		if(this.duration>200){
			element.hover(this.showShadow,this.hideShadow);
		}

        element.data("object", this);
        
		return element;
	}
	
	,getEventElement: function(){
		var id = this.id;
		var element = $('<div>', {id: 'temp_event_' + id,
		                          class: 'event'});
		// //категории
		// if(typeof(this.groupCSS) !== "undefined")
		// {			
			// // element.addClass(this.groupCSS);  
			// if(this.groupCSS=="leasure")	
		// }

		//название        
		var name = $('<span>', {class: 'event_name'}).html(this.name);	
		element.append(name);
		element.append('</br>');
		
		//кнопка добавить
		if(this.isMine !== '1')
		{
			var addURL = $('<a>', {href: '#',
			                       class: 'event_add_url'}).html('+');
			element.append(addURL);	
		}
		
		//список типов
		var stypes = "";
		for (var key in this.types) {
			stypes = stypes + this.types[key] + ", ";			
		}
		stypes = stypes.substring(0,stypes.length-2);
		var htype = $('<span>', {class: 'event_name'}).html(stypes);
		element.append(htype);
		element.append('</br>');
		
		// место
		var venue = $('<span>', {class: 'event_venue'}).html(this.venue);
		element.append(venue);
		element.append('</br>');
		
		// дата
		var startdate = $('<span>', {class: 'event_date'}).html(moment(this.startdate).format("DD.MM.YYYY HH:mm"));
		element.append(startdate);
		element.append('</br>');
		var enddate = $('<span>', {class: 'event_date'}).html(moment(this.enddate).format("DD.MM.YYYY HH:mm"));
		element.append(enddate);
		element.append('</br>');

		return element;
	}
	
	,renderShadow: function(){
		var element = $('<div>', {id: 'shadow_event_' + this.id,
	                          class: 'event_shadow'});

		element.css("left", this.left);
        element.css("width", this.actualWidth);
        element.css("height", this.height);
        element.css("opacity", 0.5);
        element.css("display", "none");

		return element;
	}
	
	,showShadow: function(){
		var id = "#shadow_" + this.id;
		$(id).show();
	}
	
	,hideShadow: function(){
		var id = "#shadow_" + this.id;
		$(id).hide();
	}

	// IDEA
	,renderIdea: function(){
		var element = this.getEventElement();
		
		element.attr("id", "idea_"+this.id);
		element.attr("class", "idea");
		
		//категории
		if(typeof(this.groupCSS) !== "undefined")
		{  
			if(this.groupCSS=="leasure")
				element.css("background-color", "green");
			if(this.groupCSS=="advance")
				element.css("background-color", "#FF6633");
		}

		element.hover(this.showIdeaShadow,this.hideIdeaShadow);
		
		element.css("width", this.width);
		
		element.data("object", this);

		return element;
	}
	
	,renderIdeaShadow: function(){	
	    var element = this.getEventElement();
	    
	    element.attr("id", "shadow_idea_"+this.id);
		element.attr("class", "idea_shadow");

		element.css("left", this.left);
		element.css("left", this.left);
        element.css("width", this.actualWidth);
        element.css("opacity", 0.5);
        element.css("display", "none");

		return element;
	}

    ,showIdeaShadow: function(){
		var id = "#shadow_" + this.id;
		$(id).show();
    }
    
    ,hideIdeaShadow: function(){
		var id = "#shadow_" + this.id;
		$(id).hide();
	}
}