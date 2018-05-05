setup web call urls for account
* \[ ] create: also create a team
* \[ ] select
*  X  modify
*  X  delete

Team Page
* list of players
  * shows
    * name
    * run
    * pass
    * special
    * injury
    * age
    * rating
  * sort by any column
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
  
* are setarting players getting bonuses? write unit tests for this
  
Login
* in top right show generated ID
* can click it to login with facebook/google or switch to a different user ID

setup web call for start page
* \[ ] if in draft then go to draft page with draft id

* \[ ] Main menu items
  * \[ ] Home
  * \[ ] Team
  * \[ ] Draft/Next Game - whatever is next thing to do for team
  

  
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


TO Run Unit Tests
* ./vendor/bin/phpunit