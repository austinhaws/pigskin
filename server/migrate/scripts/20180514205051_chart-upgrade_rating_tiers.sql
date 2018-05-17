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

-- // chart-upgrade rating tiers
-- Migration SQL that makes the change goes here.

UPDATE chart_detail SET filter = 3 WHERE chart_id = 6;
INSERT INTO chart_detail (chart_id, maximum, value, filter) VALUES
	(6, 1, 'A', 1),
	(6, 5, 'B', 1),
	(6, 15, 'C', 1),
	(6, 35, 'D', 1),
	(6, 60, 'E', 1),
	(6, 100, 'F', 1);

-- //@UNDO
-- SQL to undo the change goes here.


DELETE FROM chart_detail WHERE chart_id = 6 AND filter = 1;
UPDATE chart_detail SET filter = null WHERE chart_id = 6;