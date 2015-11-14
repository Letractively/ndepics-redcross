# EPICS Meeting Minutes Feb 20, 2012 #

### 1) (10 min) Subversion recap and troubleshooting ###
  * Able to do some testing with the PHP, hope to work with the database this coming week
  * Getting up to speed with SVN
    * Henry's email outlines svn usage for unix (ubuntu or mac)

### 2) (15 min) Database Requirements for the Red Cross ###
-**Are any changes necessary?**

  * The amount of search options is verbose, maybe we should combine the various searches into the general search
    * Maybe combine them into "general" and "detailed" search

  * In the "Add organization page"
    * Add Fulton county to red cross units
    * Is the "initials" option at the bottom necessary?
    * A space for the NSS ID/Code (8 character alphanum code)

-**New Functionality?**

  * Search nearby function, by address or zipcode etc.
    * Either by distance or number
    * Using the Google API, **Matt**

-**Other thoughts**

  * Interns will upload the data and parse through to check correct records
    * For example, there is a listing for bean inc from florida? (a test record that needs to be deleted)
    * Tech support on our end might be required to "train" the interns

### 3) (15 min) PHP and database high-level talk ###
-**Systematic way of checking for bugs?**

  * When are we ready to go "beta"?
    * So that the customer can find bugs without unnecessary pain
    * Test plan?

  * Firefox plugin Selenium
    * Someone to do some research and report on it next week, **Chas**
    * website debugging tool

-**How is everything laid out and connected?**

  * Is the database being backed up?  Where?

### 4) (10 min) Mobile App Developments and catch-up ###

  * Currently setting up database
    * Or ... actually going to use whatever Dan had in place?

  * In two weeks, will have something to demo
    * In emulation

### 5) Closing remarks, assignments for next week ###

  * PHP & database programmers meet as a group to start working on it

  * Add these bugs laid out on the meeting to the issues in Google Code

  * When is a reasonable deadline for testing?
    * Before Spring Break?

  * Skip meeting next monday
    * And by the following monday (mar 5) have something ready to demo
      * And best case, something for the interns to use and begin to upload data to
      * 20 minutes database, 10 minutes mobile