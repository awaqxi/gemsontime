/* delete from bufEvent; */


/* ========================================================= */
insert into venue(venue)
select distinct b_e.Venue
from bufEvent b_e
left join venue v on b_e.venue=v.venue
where (b_e.Venue is not null and b_e.Venue<>'')
	and v.ID is null;


/* ========================================================= */
insert into event_type(event_group_id,name)
select distinct 1, tp.Type0 from (
select
	b_e.Type0
from bufEvent b_e
where b_e.Type0 is not null and b_e.Type0<>''
union all
select
	b_e.Type1
from bufEvent b_e
where b_e.Type1 is not null and b_e.Type1<>''
) tp
left join event_type et on et.name=tp.Type0
where et.id is null;


/* ========================================================= */
delete from event;

insert into event(name,description,exturl,startdate,enddate,venueid)
select buf.name, buf.descr, buf.url, buf.dateStartdate, buf.dateEnddate, buf.venueid
from (
select distinct
b_e.Name, b_e.Descr, b_e.Url
,case
	when b_e.Startdate is null OR b_e.Startdate='' then null
	else STR_TO_DATE(b_e.Startdate, '%d.%m.%Y %k:%i')
end as dateStartdate
,case when b_e.Enddate is null OR b_e.Enddate=''
	then DATE_ADD(STR_TO_DATE(b_e.Startdate, '%d.%m.%Y %k:%i'),INTERVAL 2 HOUR)
	else STR_TO_DATE(b_e.Enddate, '%d.%m.%Y %k:%i')
end as dateEnddate
,v.ID venueid
from bufEvent b_e
left join venue v on b_e.venue=v.venue
) buf
left join event e on e.name=buf.name and e.startdate=buf.dateStartdate
where e.id is null;


/* ========================================================= */
delete from event_group_type_relation;

insert into event_group_type_relation(event_id,event_type_id)
select distinct e.id, et.id from (
select
	b_e.Type0, b_e.name, 1
	,case when b_e.Startdate is null OR b_e.Startdate='' then null
	else STR_TO_DATE(b_e.Startdate, '%d.%m.%Y %k:%i') end as dateStartdate
from bufEvent b_e
where b_e.Type0 is not null and b_e.Type0<>''
union all
select
	b_e.Type1, b_e.name, 0
	,case when b_e.Startdate is null OR b_e.Startdate='' then null
	else STR_TO_DATE(b_e.Startdate, '%d.%m.%Y %k:%i') end as dateStartdate
from bufEvent b_e
where b_e.Type1 is not null and b_e.Type1<>''
union all
select
	b_e.Type2, b_e.name, 0
	,case when b_e.Startdate is null OR b_e.Startdate='' then null
	else STR_TO_DATE(b_e.Startdate, '%d.%m.%Y %k:%i') end as dateStartdate
from bufEvent b_e
where b_e.Type2 is not null and b_e.Type2<>''
) tp
inner join event_type et on et.name=tp.Type0
inner join event e on e.name=tp.name and e.startdate=tp.dateStartdate
left join event_group_type_relation etrel on etrel.event_id=e.id and etrel.event_type_id=et.id
where etrel.id is null;


/* ========================================================= */
delete from event_participant;

insert into event_participant(user_id,event_id)
select distinct 1, e.id
from event e
left join event_participant ep on ep.event_id=e.id and ep.user_id=1
where ep.id is null;


/* /* ========================================================= *\/
update event set enddate = DATE_ADD(startdate,INTERVAL 2 HOUR)
where enddate is null; */