\[ ] Use camelCase in DB fields... so stupid to always convert between objects and snake


## Draft
\[ ] objects coming from DB should have their field converted to camel case and child object arrays filled as objects; and then going back to DB, childs should be changed to json; would Eloquent make this better? Probably be better to have a BaseModel that then has an abstract function for knowing which child fields need json conversion and their class, as well as public functions that convert to/from camel/snake case.

### checklist for work
- \[√] team DB
	- \[√] add cpu/stage columns to team
	- \[√] Update team creation to set cpu/stage fields
	- \[√] unit test team changes
- \[√] DB Table for Draft object
	- \[√] create table
- \[ ] server layers work
	- \[ ] create DAO - Create, Read, Update (no delete)
	- \[ ] create service
		- \[ ] create 
	- \[X] get/create draft for team id
	- \[ ] pick player in draft web service call
	- \[ ] routes for webservice calls
	- \[ ] unittest webservice calls
- \[ ] js webservice hookup
	- \[ ] get/create draft
	- \[ ] pick player
	- \[ ] calculate player
- \[ ] js service creation
	- \[ ] pass through to webservice calls
- \[ ] draft page (not all draft picks picked - remember to show all computer picks with timer before going to next page)
	- \[ ] order & available players
	- \[ ] teams viewing
- \[ ] post draft page (all draft picks picked and have shown all computer draft picks)
	- \[ ] team picks lists
	- \[ ] calculate draft pick scores
	- \[ ] done draft button

### Draft Sequence
- create computer teams to be involved
- setup draft DB object
	- determine draft order
	- generate players to pick from
- execute draft order
	- computers pick
		- after each computer pick, record who they picked and put in sequence array
		- in ui can then show picks after every couple of seconds so it looks like it's being done in real time
	- player picks
- repeat until all draft rounds complete

### Draft DB
- Draft DB table
	- id
	- availablePlayers (json)
	- draft sequence (json): [{teamGuid: , playerPickedGuid: false}, {teamGuid: , playerPickedGuid: false}, ...] in order of picks, repeated for # of rounds of draft
- draft_x_team DB table: joining to get teams involved with the draft
	- draft sequence has this info, repeated and in json, so it's going to be easier to just create a join table
- add "cpu" flag to team record
- add "stage" flag to team and default to "draft"
	
### Draft WebService
- /draft/{accountGuid}/{teamId} : gets/creates the current draft; check that the team is in "draft" state before creating
- /draft/pick : perform a player pick and pick all computer picks until the next player
	- post fields: account guid, team guid, draft player guid
	- verifies the account is part of that draft
	- add the chosen player to the team's roster
	- remove the player from the draft's available players roster
	- add picked player to player sequence in draft
	- perform computer picks until next player pick
	- update draft DB object
	- return updated draft object
- /draft/calculatePlayer : calcualtes scores based on rating for a new drafted player
	- post fields: accountGuid, teamGuid, playerGuid
	- calculates scores for that player based on its rating and returns the results
- /draft/complete
	- post fields: accountGuid, teamGuid
	- verifies all players have been calculated
	- sets account's state to season

### Draft View
- menu at top to pick which team to view so can view what other teams have or go back to draft
	- if viewing a team, then the draft 1/2 page views go away and see just the team list (make team list component shareable with team page?)
	- when showing scores, if player doesn't have scores yet then put an "N/A" in the column as these will be determined after the draft
- 1/2 page width: draft picking sequence
	- teams in order of picks
	- if team has picked then show the name pos and rank of the player picked
- 1/2 page width: list of players (no scores nor injury)
	- columns
		- name
		- position
		- age
		- rating
		- star checkbox option icon image for remembering players
		- button to pick if it's your turn to pick
	- sortable
	- tabs for offense/defense/kick/starred
- timer runs in background and shows the next pick every few seconds until it is the player's turn and then the timer turns off and waits for the player to pick

### Post Draft View
- menu at top for teams, default to yours, option for all
- shows team players picked and in what order
	- name, position, age, rating
	- button next to player to compute scores (for your team)
	- other teams show scores of taken players
	- button press then calls the server to compute base scores for the player based on their rating
- draft not finished until all player scores computed
	
	
	
## End Result
Have an engine to acquire new players from the draft which can also be leveraged in the future for PvP drafting.
	
	
	
	
	
#
\[ ] after draft is done then its time to focus on playing a season
\[ ] then post season
\[ ] then retirement and player advancement
\[ ] then back to draft
#

Draft football menu item is available if draft is in progress
when goes to season then draft becomes season

lineups don't matter until after the draft since don't have enough players to change lineup

need a way to have javascript enums match php enums?
- in jest tests, export php enums and load them and test that they match the javascript ones
- by manually typing javascript enums then autocomplete will work

Team Page
* list of players
  * \[√] shows
    * name
    * run
    * pass
    * kick
    * injury
    * age
    * rating
  * \[√] sort by any column
  * lineups menu
  * each lineup allows only certain players: have to have
    * offense
      * at least one WR
      * at least one HB
      * any # FB
      * any # TE
      * 5 linemen
      * 1 QB
      * 11 total players
    * defense
      * at least one DL
      * at least one LB
      * at least two CB
      * at least one S
      * 11 total players  
  * above the players list have the lineups menu
  * to right have a red "delete lineup" button and a green "add lineup" button
  * must always have at least one offense and one defense lineup (start with one of each and can't delete if would break this rule)
  * when team created, select first of each position type to form lineups just for defaults
  * put a question mark tooltip next to player list so it's obvious the rules 
  
  
Login
* in top right show generated ID
* can click it to login with facebook/google or switch to a different user ID

setup web call for start page
* \[ ] if in draft then go to draft page with draft id
  
* \[ ] Home page shows news items
  * \[ ] if not logged in then show message that they have to remember they're ID to access their team from somewhere else or they can log in with google/facebook
  
Use google material! yes... do it...

Go to draft
* what is draft sequence
	* determine draft order
	* generate players with grades
	* perform draft
	* calculate final player scores
* draft page
	* shows draft order in a box with which teams in initiative order
	* shows players list with filters at top and sort order menu
	* have "star" option to remember players you want to take
	
	
later
* can join a league to play league games and to have leagues play against other leagues to get league points and awards
* like dragon city, have lots of things to go do and always gaining new things so there's always progress
* playing against other players does not have both players online at same time, you just end up playing their team controlled by a computer. teams have a ranking based on their win/loss and you play against teams that have a similar win/loss as you.

at higher levels then can join leagues. like in dragon city, have different ways to fight/compete: against computer, against leagues, against ranked opponents. 
also have mini games to get advancement.
each of these things has a certain # of times you can do it per hour or whatever.
always earn something for having played.

Can build up training facility to get bonuses and play cards and improvements and fan support and expand to new markets like oversees.

The "F" draft is mostly F players with a few Es and a couple Ds.
Can join higher level drafts, but have to have your team at that higher rank through ranked play and those drafts are with other live players.

Leagues have a Free Agents pool. When teams release players to make room for new players, the released players go to the Free Agent pool and are available to be picked up by anyone else in the League. This forces leagues to help the new comers get better guys.

have gems to buy upgrades
earn coins/badges/honors/upgrades by grinding

it would be cool to eventually have players have a history of their seasons and who they played with so you can see where they've been and what they've become. 

Like Returnes, put exclamation points on what to do next and missions to do next. There should always be exclamation points so there is always something next to do. Daily and weekly missions.

TO Run Unit Tests
* ./vendor/bin/phpunit
To Run composer
composer update