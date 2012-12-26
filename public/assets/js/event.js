function Event(){}

Event.prototype = {
	id: 0,
	name: '',
	isMine: 0,
	date: '',
	groupCSS: '',
	init: function(entry){
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
	},
	//отображение события
	render: function(){
		var element = $('<div>', {id: 'event_' + this.id,
		                          class: 'event'});
		//категории
		if(typeof(this.groupCSS) !== "undefined")
		{			
			element.addClass(this.groupCSS);     
		}       
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
		return element;
	}
}