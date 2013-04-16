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

	_init: function(entry){
		this.id = entry['id'];
		this.name = entry['name'];
		this.isMine = entry['isMine'];
		this.date = entry['date'];
		for (var key in entry['groupsTypes']) {
			
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
		//кнопка добавить
		if(this.isMine !== '1')
		{
			var addURL = $('<a>', {href: '#',
			                       class: 'event_add_url'}).html('+');					
						                  
			element.append(addURL);
			
		}	
		var date = $('<span>', {class: 'event_date'}).html(this.date);
		element.append(date);
        element.data("object", this);
		return element;
	}
}