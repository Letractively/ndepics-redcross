# Meeting Minutes October 22 #
## Ongoing work ##
  * DB Paper - Henry, Jonathan, Chas
  * Red Cross App Paper- Matt, Chas, Dan
  * Haiti App - Ryan, Aaron
  * Haiti App **Server** - **Chas**, Mike, Conor, Dolff, Johnathan, Henry

## Haiti App ##
> One problem is leaving a work in progress and coming back.
    * Where would we save? External SD Card or on the phone itself?
    * Recommendation for SQL Lite... You don't want the extra overhead to parse a file you've written yourself.
    * One question to ponder is whether it makes sense to submit partial reports or just submit at the end.
> What happens if either side of the connection is dropped?
    * We think on the sending side, the database will return a response saying it has succeeded.
    * Henry is suggesting rejecting a submission if not all fields are filled.
    * Look into whether it is possible to get a partially filled database.
What web server can we use?
    * GoDaddy...

The app developers should sit down with the server developers to give them the needed variable names.

How many pictures should the server developers be expecting? Minimum of 4 pictures & many text fields.
  * Things get a bit different as we start recording a variable number of pictures.
  * Need to think about database design.
  * We should be able to store any variable number of pictures as per what Johnathan was mentioning.

When should the app be ready for database developers to look at it? Coding begins this week.

What basics do we need going forward for the database?
  * HTML5 can supposedly upload directly through SQL.

We should introduce something that will let the costumer exactly what is in the database and what still resides on the phone.

Basically 2 types of PHP programs.
  * One type runs when something is posted.
  * One type lets the user see what is there.

The way the Red Cross DB worked was storing the pictures in the image file and keeping the name in the DB.
  * Saving blobs becomes inefficient. Saving references to pictures is much more efficient.


---

# Next week #
  * **Have the Haiti App developers bring list of variable names, datatypes (strings/integers/float values) we should expect.**
  * DB Paper to be sent out and worked on.
  * **DB Paper team to come with an outline on what is to be worked on.**
  * **Grad students should be able to send their work to Chas to be forwarded to DB team.**