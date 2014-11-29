# Datamodellering & Databasesystemer - Oblig 1

## Background
What happened when I read the assignment was that I saw "... Oppgaven går ut på å lage en blog der enhver nettbruker kan legge inn et innlegg, og der alle
nettbrukere kan se alle innlegg som er lagt inn.".

This lead me to think "Oh, each user can add a post, but everyone can read it. Well, at the very least we need a User model then! Otherwise it would mean that everybody could also create posts, right? That's not what we want, is it?", and it kind of snowballed from there.

Since I have never written any MVC application from scratch, but only worked with them in existing applications, I thought it would be nice to try writing one from scratch -- 
it would improve my learning experience (after all, we do this to learn, right?) and it would be more of a challenge.

I hope it's not a problem that all code (and database tables and columns) are in English instead of Norwegian. I also apologize for not using the _exact_ names suggested, like "ForfatterNavn" which I have instead replaced with "first_name" and "last_name", 
and which are contained in the User table. Instead, each Post contains an Author ID, which is a foreign key stemming from the user who created the post, and can be found in the User table.

Since I've been working with PHP for quite a while, but recently fallen in love with Ruby on Rails, I tried to maintain a Rails-like filestructure (without the app/ directory).
I also thought it would be nice to learn how MVC was actually implemented from scratch, as opposed to only work with ready implementations. 


## What I know I should've done better
1. I should have made the database less of a god object and allowed each model to have more direct communication with the database. By this I mean:
..* Each model should have prepared the statements and run the queries on them.
..* Perhaps using a base model would have been wiser
..* The database class should have only contained a reference to the database connection and the necessary scripts
..* The database class should have contained fail-safe methods for creating tables if they did not exist, and adding default roles and users.
2. I should have let the base controller sanitize and process $_POST variables better and made sure these were passed as parameters to the child controllers actions instead
3. I should have implemented pagination (the backend code is there, I just forgot to add it to the "all" view for posts)
4. I should have used templates and let the views have been classes processing the data (but this felt like abstraction for the sake of abstraction ...)
5. The .htaccess file - I completely failed to write proper rewrite rules for mod_rewrite, so all routes are handled by the $_GET parameter "routes". This might be an easy fix though.
6. I should have implemented better error messages and try/catch'es
7. I should have implemented better checks for when a view/controller/action exists/does not exist
8. I should have added checks for Roles, and made sure administrators had actual administrator rights (right now, roles are pointless :/)
9. Roles should have had its own model (after all, there's a table for it)
10. I should have added the ability to remove posts
11. I should have added the ability to promote/demote a user's role.
12. I should not have followed the YAGNI principle and spent so much time on this

## Structure & Description
1. Models
  * All models are found in the models/ directory
  * Models are (like in rails) "objects of a table". Each model corresponds to a table of the same name (but in lowercase)
2. Controllers
  * All controllers are found in the controller/ directory
  * Controllers are named [Modelname]Controller (like PostController, UserController, and so on)
  * Controllers are require()'d after models.
  * The base controller is simply named Controller
  * The base controller provides redirect() functionality to derived child-controllers
  * The base controller processes the "route" $_GET variable and calls the action/view
3. Views
  * Views are found in the views/ directory
  * Views can be named anything, as long as they end with .view.php
  * Views only contain HTML, and the processing of $parameters (global array returned from the page's controller action with information required for the specific view)
4. Miscellaneous
  * If a stylesheet named [view].style.css is found in the assets/stylesheets/ directory, it will be included after all other stylesheets as to allow CSS overriding on a per-view basis
  * For neat and quick CSS/JS, Twitter Bootstrap is used
  * For layout in a lovely grid, Twitter Bootstrap's grid is used
  * For simple but sweet post formatting, TinyMCE for jQuery is loaded
  * All configuration variables (like password salt, site name, site slogan and so on) can be found in config.php
  * Database is a singleton class (I know this is a bad practice, but I dont want multiple instances of it... better suggestions are welcome!) and can only have one instance
  * Configuration only contains getters, and these are all static (as is all its variables)
  * Users may create and edit posts, but they may ONLY edit posts if they are the owners of the post in question. However, administrators should be able to edit any post (currently, they cant).
