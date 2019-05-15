DROP TABLE IF EXISTS reminder;

CREATE TABLE reminder ( 
`id` INT NOT NULL AUTO_INCREMENT , 
`owner` VARCHAR(30) NOT NULL DEFAULT 'test' COMMENT 'user ID', 
`title` VARCHAR(30) NOT NULL COMMENT 'e.g. feed cat', 
`description` VARCHAR(255) NULL  COMMENT 'clarify title if needed', 
`notes` TEXT NULL  COMMENT 'additional information including steps to complete', 
`category` CHAR(30) NULL , 
`priority` INT NULL  , 
`recur_scale` INT NOT NULL DEFAULT '1' COMMENT 'hours,days,weeks,months,years = 0,1,2,3,4' , 
`recur_units` INT NULL COMMENT 'number of time units before reminder will recur quietly; null values indicate non-recurrence', 
`recur_float` INT NOT NULL DEFAULT '1' COMMENT 'recur after complete_date rather than after start_date; 0=false, other=true',
`grace_scale` INT NOT NULL DEFAULT '1' COMMENT 'hours,days,weeks,months,years = 0,1,2,3,4' , 
`grace_units` INT NULL  COMMENT 'amount of time after start_date before reminder will appear as overdue', 
`passive_scale` INT NOT NULL DEFAULT '1' COMMENT 'hours,days,weeks,months,years = 0,1,2,3,4' , 
`passive_units` INT NULL  COMMENT 'amount of time between start_date and alarm condition', 
`snooze_scale` INT NOT NULL DEFAULT '1' COMMENT 'hours,days,weeks,months,years = 0,1,2,3,4' , 
`snooze_units` INT NULL  COMMENT 'default amount of time to delay this reminder if user snoozes it', 
`alarm_interval_scale` INT NOT NULL DEFAULT '2' COMMENT 'hours,days,weeks,months,years = 0,1,2,3,4' , 
`alarm_interval_units` FLOAT NULL  COMMENT 'how often to send active reminders ', 
`alarm_sent_date` DATETIME NULL COMMENT 'date of last reminder sent',
`complete_date` DATETIME NULL COMMENT 'date last completed', 
`snooze_date` DATETIME NULL  COMMENT 'defer reminder until this date', 
`end_date` DATETIME NULL  COMMENT 'reminder will not recur after this date', 
`start_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this reminder will appear in the UI', 
`due_date` DATETIME NULL  COMMENT 'calculated based on start_date and days_grace', 
`active_date` DATETIME NULL COMMENT 'calculated based on start_date and days_passive', 
`days_of_week` CHAR(7)  NULL  COMMENT 'days of week this reminder is active: MTWtFSs; null implies all' , 
`season_start` INT  NULL COMMENT '0-364; days after January 1 that the season for this reminder starts'  , 
`season_end` INT NULL COMMENT '0-364; days after January 1 that the season for this reminder ends', 
`day_start` INT  NULL COMMENT '0-2359; military time for time of day that this reminder becomes active (mod 100 values over 59 will round down to 59)' ,
`day_end` INT  NULL COMMENT '0-2359; military time for time of day that this reminder becomes inactive (mod 100 values over 59 will round down to 59)'  , 
`last_updated` DATE NULL COMMENT 'date of last change to this record', 
`sequence` BIGINT NOT NULL  COMMENT 'used for preventing accidental updates', 
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date created', 
PRIMARY KEY (`id`), 
UNIQUE KEY(`sequence`),
INDEX `reminder_category_indx` (`category`), 
INDEX `reminder_owner_indx` (`owner`), 
INDEX `reminder_snooze_date_indx` (`snooze_date`),
INDEX `reminder_init_date_indx` (`complete_date`),
INDEX `reminder_end_date_indx` (`end_date`),
INDEX `reminder_start_date_indx` (`start_date`),
INDEX `reminder_due_date_indx` (`due_date`),
INDEX `reminder_active_date_indx` (`active_date`)
);


create table user (
`id` INT NOT NULL AUTO_INCREMENT , 
`username` VARCHAR(30) NOT NULL  ,
`email` VARCHAR(30) NOT NULL  ,
`password` VARCHAR(255) NOT NULL COMMENT 'php password_hash(password,PASSWORD_BCRYPT)' ,
`first_name` VARCHAR(30) NOT NULL ,
`last_name` VARCHAR(30) NOT NULL ,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date created', 
`last_updated` DATE NULL COMMENT 'date of last change to this record', 
PRIMARY KEY (`id`), 
UNIQUE KEY(`username`)
);

--test/foo
insert into user(username,email,first_name,last_name,password) VALUES ('Test','y@x.com','John','Doe','$2y$10$JA6W8MpTPLlwt4nXg7yJKeZYF15L3qmFDXJ42hKBc9fHWmBKKzxv6');




