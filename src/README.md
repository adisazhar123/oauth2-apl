### Installation
1. Import src/apps/modules/oauth/data/db-structure.sql
2. Run `composer install` and Copy `.env.example` to `.env`
3. Fill `.env` variables 
4. Start webserver. Please use port 80 :/
5. Got to `HOST_URL/oauth/newclient` to register a new client. Copy the `client_id` and `client_secret` into `.env` variables
6.  Got to `HOST_URL`. For first timers, an **unauthorized** message will show. To remove it, press the **Log In** button.
7.  **Authorize** the client app. Once authorization is successfull, the request to the protected resource route will succeed, and list of friends (dummy data located in `src/app/modules/oauth/data/friends.php`) will show.

### TODO:
1. Refactor to accomodate SOLID.
2. Replace dummy data for 'real' data.