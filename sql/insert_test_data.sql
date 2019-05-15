delete from reminder;

-- default timing
INSERT INTO reminder(category,title,description) VALUES ('default','feed cat','description');
INSERT INTO reminder(category,title,description) VALUES ('default','ship orders','description');
INSERT INTO reminder(category,title,description) VALUES ('default','read news','description');
INSERT INTO reminder(category,title,description) VALUES ('default','write code','description');

-- current
INSERT INTO reminder(category,title,description, start_date, due_date, days_of_week) VALUES ('current','kick ass','MWF',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),'MWF');
INSERT INTO reminder(category,title,description, start_date, due_date, days_of_week) VALUES ('current','take names','Tu Thu Weekend',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),'TtSs');


INSERT INTO reminder(category,title,description, start_date, due_date, season_start, season_end) VALUES ('current','hike','summer',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),90,270);
INSERT INTO reminder(category,title,description, start_date, due_date, season_start, season_end) VALUES ('current','hibernate','winter',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),271,89);

INSERT INTO reminder(category,title,description, start_date, due_date, day_start, day_end) VALUES ('current','sunbathe','day',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),0600,1800);
INSERT INTO reminder(category,title,description, start_date, due_date, day_start, day_end) VALUES ('current','stargaze','night',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),1800,0600);


-- future
INSERT INTO reminder(category,title,description, start_date, due_date) VALUES ('future','change passwords','future',addtime(current_timestamp(),'6000000'),addtime(current_timestamp(),'25000000'));
INSERT INTO reminder(category,title,description, start_date, due_date) VALUES ('future','wash dishes','future',addtime(current_timestamp(),'5000000'),addtime(current_timestamp(),'15000000'));

-- overdue
INSERT INTO reminder(category,title,description, start_date, due_date, snooze_date) VALUES ('overdue','goof off','overdue but snoozed',subtime(current_timestamp(),'25000000'),subtime(current_timestamp(),'8000000'),addtime(current_timestamp(),'3000000'));
INSERT INTO reminder(category,title,description, start_date, due_date) VALUES ('overdue','answer mail','overdue',subtime(current_timestamp(),'15000000'),subtime(current_timestamp(),'5000000'));


-- recurrence
UPDATE reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=0 where title='kick ass';
UPDATE reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=1 where title='take names';
UPDATE reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='answer mail';
UPDATE reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='goof off';
UPDATE reminder set recur_units=3, grace_units=3, passive_units=2, recur_scale=1 where title='hike';
UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='hibername';
UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='sunbathe';
UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=2 where title='stargaze';
UPDATE reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=3 where title='read news';
UPDATE reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=4 where title='write code';

