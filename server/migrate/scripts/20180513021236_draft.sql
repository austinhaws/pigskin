--
--    Copyright 2010-2016 the original author or authors.
--
--    Licensed under the Apache License, Version 2.0 (the "License");
--    you may not use this file except in compliance with the License.
--    You may obtain a copy of the License at
--
--       http://www.apache.org/licenses/LICENSE-2.0
--
--    Unless required by applicable law or agreed to in writing, software
--    distributed under the License is distributed on an "AS IS" BASIS,
--    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
--    See the License for the specific language governing permissions and
--    limitations under the License.
--

-- // draft
-- Migration SQL that makes the change goes here.

CREATE TABLE draft (
	id int(11) NOT NULL AUTO_INCREMENT,
	available_players TEXT,
	draft_sequence TEXT,
	state NVARCHAR(10),
	PRIMARY KEY (`id`),
	UNIQUE KEY `draft_id_uindex` (`id`)
);

CREATE TABLE draft_x_team (
	id int(11) NOT NULL AUTO_INCREMENT,
	draft_id int,
	team_id int,
	PRIMARY KEY (`id`),
	UNIQUE KEY `draftteam_id_uindex` (`id`),
	CONSTRAINT draftteam_draft_fk FOREIGN KEY (draft_id) REFERENCES draft (id),
	CONSTRAINT draftteam_team_fk FOREIGN KEY (team_id) REFERENCES team (id)
);

-- //@UNDO
-- SQL to undo the change goes here.

DROP TABLE draft_x_team;
DROP TABLE draft;
