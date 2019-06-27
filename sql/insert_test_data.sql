delete from cadence_reminder;

-- default timing
INSERT INTO cadence_reminder(sequence,category,summary,description) VALUES (999001,'default','feed cat','description');
INSERT INTO cadence_reminder(sequence,category,summary,description) VALUES (999002,'default','ship orders','description');
INSERT INTO cadence_reminder(sequence,category,summary,description) VALUES (999003,'default','read news','description');
INSERT INTO cadence_reminder(sequence,category,summary,description) VALUES (999004,'default','write code','description');

-- current
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, days_of_week) VALUES (999005,'current','kick ass','MWF',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),'MWF');
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, days_of_week) VALUES (999006,'current','take names','Tu Thu Weekend',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),'TtSs');


INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, season_start, season_end) VALUES (999007,'current','hike','summer',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),90,270);
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, season_start, season_end) VALUES (999008,'current','hibernate','winter',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),271,89);

INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, day_start, day_end) VALUES (999009,'current','sunbathe','day',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),0600,1800);
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, day_start, day_end) VALUES (999010,'current','stargaze','night',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),1800,0600);


-- future
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date) VALUES (999011,'future','change passwords','future',addtime(current_timestamp(),'6000000'),addtime(current_timestamp(),'25000000'));
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date) VALUES (999012,'future','wash dishes','future',addtime(current_timestamp(),'5000000'),addtime(current_timestamp(),'15000000'));

-- overdue
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date, snooze_date) VALUES (999013,'overdue','goof off','overdue but snoozed',subtime(current_timestamp(),'25000000'),subtime(current_timestamp(),'8000000'),addtime(current_timestamp(),'3000000'));
INSERT INTO cadence_reminder(sequence,category,summary,description, start_date, due_date) VALUES (999014,'overdue','answer mail','overdue',subtime(current_timestamp(),'15000000'),subtime(current_timestamp(),'5000000'));


-- recurrence
UPDATE cadence_reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=0 where summary='kick ass';
UPDATE cadence_reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=1 where summary='take names';
UPDATE cadence_reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where summary='answer mail';
UPDATE cadence_reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where summary='goof off';
UPDATE cadence_reminder set recur_units=3, grace_units=3, passive_units=2, recur_scale=1 where summary='hike';
UPDATE cadence_reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where summary='hibername';
UPDATE cadence_reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where summary='sunbathe';
UPDATE cadence_reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=2 where summary='stargaze';
UPDATE cadence_reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=3 where summary='read news';
UPDATE cadence_reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=4 where summary='write code';

UPDATE cadence_reminder set uid=CONCAT("dummytestdata",sequence) where UID is null and owner='test';
