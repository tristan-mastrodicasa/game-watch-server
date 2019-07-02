--
-- Game Watch Database
--
-- Current schema by Tristan Mastrodicasa
--

-- Generate database --

SELECT "Re-create the database" AS "INFO";

DROP DATABASE IF EXISTS game_watch;
CREATE DATABASE IF NOT EXISTS game_watch
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci;

USE game_watch;

-- Clear tables --

SELECT "Clearing Tables" AS "INFO";

DROP TABLE IF EXISTS account_info,
                     password_info,
					 notification_settings,
					 user_subscriptions,
					 events,
					 event_subscriptions,
					 notifications,
					 notifications_seen;

-- Create tables --

SELECT "Creating New Tables" AS "INFO";

CREATE TABLE account_info (
	uid         INT          NOT NULL AUTO_INCREMENT,
	profile_img VARCHAR(64),                          -- Will vary depending on storage algorithm and naming scheme
	username    VARCHAR(20)  NOT NULL,
	rating      INT          NOT NULL DEFAULT 0,      -- Keep in sync with the game ratings
	subscribers INT          NOT NULL DEFAULT 0,      -- Keep in sync with the user_subscriptions table count
						 
	PRIMARY KEY (uid)
) ENGINE = INNODB;

CREATE TABLE password_info (
	uid         INT          NOT NULL,
	phash       VARCHAR(64)  NOT NULL,
	psalt       VARCHAR(64)  NOT NULL,                -- Can vary depending on php function output length

	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE,
	PRIMARY KEY (uid)
) ENGINE = INNODB;

CREATE TABLE notification_settings (
	uid         INT          NOT NULL,
	push_notify TINYINT(1)   NOT NULL DEFAULT 1,
	ev_rem_1h   TINYINT(1)   NOT NULL DEFAULT 1,
	ev_rem_10m  TINYINT(1)   NOT NULL DEFAULT 1,
	ev_changes  TINYINT(1)   NOT NULL DEFAULT 1,
	user_events TINYINT(1)   NOT NULL DEFAULT 1,      -- Notifications for events posted by subscribed users

	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE,
	PRIMARY KEY (uid)
) ENGINE = INNODB;

CREATE TABLE user_subscriptions (
	huid        INT          NOT NULL,                -- Host Userid
	cuid        INT          NOT NULL,                -- Client Userid (The one subscribing)

	FOREIGN KEY (huid) REFERENCES account_info (uid) ON DELETE CASCADE,
	FOREIGN KEY (cuid) REFERENCES account_info (uid) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE events (
	eid         INT          NOT NULL AUTO_INCREMENT,
	uid         INT          NOT NULL,                -- Host Userid
	game        ENUM("rus",                           -- Rust
					 "mnc",                           -- Minecraft
					 "wrb",                           -- Mount and Blade: Warband
					 "ar3",                           -- Arma 3
					 "grm"                            -- Gary's Mod
				          )  NOT NULL,
	banner_img  VARCHAR(64),                          -- Will vary depending on storage algorithm and naming scheme
	title       VARCHAR(100) NOT NULL,
	description TEXT,
	start_time  INT          NOT NULL,                -- Start time in the unix timestamp (so can be converted in other timezones)
	server_addr VARCHAR(40)  NOT NULL,
	region      ENUM("aa",                            -- Australasia
					 "as",                            -- Asia
					 "na",                            -- North America
					 "eu"                             -- European Union
				         )   NOT NULL,
	voice_srvce VARCHAR(30)  NOT NULL,                -- Voice Service
	voice_srver VARCHAR(100),                         -- Voice server address
	target_plyr INT          NOT NULL,
	num_sub     INT          NOT NULL DEFAULT 0,      -- Keep in sync with event subscriptions table
	rating      INT          NOT NULL DEFAULT 0,      -- Aggregate rating /100 by users post game
	num_rated   INT          NOT NULL DEFAULT 0,      -- How many have reviewed
	cancelled   TINYINT(1)   NOT NULL DEFAULT 0,      -- 0 = on, 1 = cancelled

	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE,
	PRIMARY KEY (eid)
) ENGINE = INNODB;

CREATE TABLE event_subscriptions (
	eid         INT          NOT NULL,                -- Host Userid
	uid         INT          NOT NULL,                -- Client Userid (The one subscribing)

	FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE notifications (                          -- Whenever a change happens enter a notification row is needed
	nid         INT          NOT NULL,
	uid         INT,                                  -- Can be null but try not too (only when notification is strictly user or event)
	eid         INT,
	notify_type ENUM("evcr",                          -- Event Created (usually notifies subscribed users)
					 "e1hr",                          -- Event hour reminder
				 	 "e10m",                          -- Event 10 min reminder
				 	 "echg",                          -- Changes to an event
					 "tprh"                           -- Target players reached
				 		   ) NOT NULL,
	additional  VARCHAR(4),                           -- Additional info for the notify type, usually a key to a PHP index with strings
	pushed      TINYINT(1)   NOT NULL DEFAULT 0,      -- Has this notification been pushed to devices

	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE,
	FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
	PRIMARY KEY (nid)
) ENGINE = INNODB;

CREATE TABLE notifications_seen (
	nid         INT          NOT NULL,
	uid         INT          NOT NULL,

	FOREIGN KEY (nid) REFERENCES notifications (nid) ON DELETE CASCADE,
	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE
) ENGINE = INNODB;

-- CREATE TABLE session_keys (
--	did         INT          NOT NULL,
--	access_tken INT          NOT NULL,
--
--	FOREIGN KEY (nid) REFERENCES notifications (nid) ON DELETE CASCADE,
--	FOREIGN KEY (uid) REFERENCES account_info (uid) ON DELETE CASCADE
-- ) ENGINE = INNODB;

SELECT "Done" AS "INFO";