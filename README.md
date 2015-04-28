# RSS-Feed-Manager
Simple web application for managing rss feeds.

## Task Specification

Write a small application using PHP that can perform the following operations:
 - Allow users to maintain a list of RSS feeds - add, remove, list. (the list must be persisted when the user is not running the application - eg in a database or other persistent storage).
 - Allow users to view the contents of an RSS feed (parse the contents and present it to the user).

Note: do not use an open source web framework (e.g. Symfony) for your submission.


##Install

You will need to run composer update within the project file (assuming that you have composer installed) in order to fetch any dependancies that the project has.

"composer install"

##Database Configuration

To begin you will need to adjust the database configuration file in "/config/db.ini". This will require the host, database name, username and password.

There is also a couple of basic setup scripts for the database in the /database directory. You will simply need to copy and past the sql code into your database command line to build and populate the database. There is sufficient data in the database to see working examples of rss feeds, atom feeds and invalid feeds.

##TODO

Unfortunately due to time constraints, not all features have been implemented and hence the list below would need implementing in order to fully complete the project. The current state of the application is after 4 days of work.

1. Ability to delete a feed.
2. User accounts that would allow multiple users to access their own list of feeds and independently maintain the list.
3. CSS formatting.
4. Form validation and subsequent feedback.
5. Further assessment of the security vulnerabilities that are possible when retriveing, storing and displaying data  from an external resource such as an RSS feed.

##Credits
Credit to the MagpieRSS package that could not be pulled in via composer and as such may not be as easily noticed. The package was very useful. See the follwoing site for more details about it: http://magpierss.sourceforge.net .
For all other packages used, please see composer.json.
