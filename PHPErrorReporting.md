# Introduction #

The code below will help you avoid blank PHP pages if there is an error on your page.  These lines are necessary to display errors on the OneEach server.  If you are having problems with a query, see [MySQLErrorReporting](MySQLErrorReporting.md)


# Details #

Insert the following code at the start of the PHP section.
```
<?php

error_reporting(E_ALL);

ini_set ('display_errors', '1');

{... code ...}

?>
```

We will probably want to remove these lines in the release version, but they can be very helpful during testing.