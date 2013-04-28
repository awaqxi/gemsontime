function Event(entry)
{
    this._init(entry);
}

Event.prototype = {
	id: 0,
	name: '',
	isMine: 0,
	date: '',
	groupCSS: '',
    left: 0,
    top: 0,
    width: 0,
    height: 0,
    types:[],
    venue: "",
    relation: "",

	_init: function(entry){
		this.id = entry['id'];
		this.name = entry['name'];
		this.isMine = entry['isMine'];
		this.date = entry['date'];
		this.venue = entry['venueName'];
		this.relation = entry['userRel'];

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
		var element = $('<div>', {id: 'event_' + id,
		                          class: 'event'});
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
		
		// дата
		var date = $('<span>', {class: 'event_date'}).html(moment(this.date).format("DD.MM.YYYY HH:mm"));
		element.append(date);
		element.append('</br>');

        element.data("object", this);
		return element;
	}
}