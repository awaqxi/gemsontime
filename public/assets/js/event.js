function Event(){}

Event.prototype = {
	id: 0,
	name: '',
	isMine: 0,
	date: '',
	element: '',
	//отобржение события
	render: function(){
		this.element = $('<div>', {id: 'event_' + this.id,
		                           class: 'event'});
		var name = $('<span>', {class: 'event_name'}).html(this.name);		
		var date = $('<span>', {class: 'event_date'}).html(this.date);
		
		this.element.append(name);
		this.element.append(date);
		return this.element;
	}
}