# Introduction #

Instead of reading the "die" statement from a failed query, try the error function while debugging.


# Details #

Add your content here.  Format your content with:
  * Remove the "or die("statement")" portion of the query line.
  * Add the function "mysql\_error();" below the query.
  * You can now read the error message returned by the database which will be much more helpful in debugging.
  * Ensure that you replace the "or die()" portion of the original query when you are finished!