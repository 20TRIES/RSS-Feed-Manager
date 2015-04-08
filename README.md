# RSS-Feed-Manager
Simple web application for managing rss feeds.

##Install

You will need to run composer update within the project file (assuming that you have composer installed) in order to fetch any dependancies that the project has.

"composer instal"

##Database Configuration

To begin you will need to adjust the database configuration file in "/config/db.ini". This will require the host, database name, username and password.

There is also a couple of basic setup scripts for the database in the /database directory. You will simply need to copy and past the sql code into your database command line to build and populate the database. There is sufficient data in the database to see working examples of rss feeds, atom feeds and invalid feeds.

##TODO

Unfortunately due to time constraints, not all features have been implemented and hence the list below would need implementing in order to fully complete the project. The current state of the application is after 4 days of work.

1. Ability to delete a feed.
2. User accounts that would allow mucltiple users to access their own list of feeds and independently maintain the list.
3. CSS formatting.
4. Form validation and subsequent feedback.
