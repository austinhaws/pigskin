\[ ] change segemented button to be a tab control since that's what it's really doing and material UI has one 

lineups don't matter until after the draft since don't have enough players to change lineup
so next thing to do is Draft!
- \[ ] DB structure to track a draft
- \[ ] what if multiple players? just computers for first level
- \[ ] each step of draft is a new view component?


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


TO Run Unit Tests
* ./vendor/bin/phpunit
