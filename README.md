# Backend Code Test

![alt text](https://raw.githubusercontent.com/mrbandfriends-organisation/backend-code-test/master/screenshot.png?token=AAbIEkrM61l1PJ_eJfY1-Cq_MvOFHMgYks5bV0BswA%3D%3D)

## The Brief

Our (fictitious) client has requested we build them a Jobs board website. The site must have the following features:

1. Jobs listing page displaying Jobs retrieved from a 3rd party Jobs feed
2. Ability to click through to a Single Job page with more details about the Job
3. Allow website users to apply for a Job and upload their CV
4. Allow the client's team to view Job Applications (including the uploaded CV file) in the CMS

Another developer has already made a start on the project but it is not complete. They've utilised WordPress as the CMS, but we've been advised that there might be a few bugs with the implementation. We're also concerned that there _could_ be issues surrounding:

* Security 
* Performance
* Code organistion and/or maintainability
* [Code style](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)

In addition, the developer has advised that they haven't had time to complete the CV upload functionality.

Our client has also advised us that their Jobs feed API hasn't been setup yet. Luckily however, the developers of the API have provided a sample set of XML Job data that we can use as fixtures whilst developing our integration. This is available at `fixtures/jobs.xml`.

We now need you to take on the project, working through the brief above and completing all of the tasks outlined below. If there's any time left, you may also wish to extend or improve the functionality in any way you see fit.


## Setup

### Github Setup

1. Create a new repository on your Github account. We don't mind if this is public, but please do not include our brand name in the title of the repo.
2. Place the contents of the codetest `.zip` into the `master` branch and commit to the repo.
3. Create a branch from `master`. You can call this whatever you wish. You will work on this branch for the duration of the project.
4. Make an initial commit into this branch and publish to Github.
5. Create a Pull Request from your branch into `master`. 
6. Send us the link to your PR. We will keep an eye as you progress through the project.

### Project Setup

1. Setup your local PHP dev environment. The host for the site should be `http://backend-code-test.test`. This value is stored in the database so if you wish to use another url, then you will need to [run a search/replace on the database](https://developer.wordpress.org/cli/commands/search-replace/) once installed.
2. Create a database with the name `backendcodetest`. Import the database export file `db-export/export.sql` into this database.
3. Rename `wp-config-sample.php` to `wp-config.php` and fill out the DB connection details. 
4. Test WordPress is running at http://backend-code-test.test and that you can access the CMS admin dashboard ("WP Admin") at `http://backend-code-test.test/wp-admin/`. CMS login details are `un: developers / pass: mrbandfriends`.

## Orientation

* Theme and templates reside at `wp-content/themes/mrb-bct/`. 
* Custom functionality is encapsulated within a custom Plugin at `wp-content/plugins/mrb-jobs-feed/`. 

We're happy to answer any questions you might have about the layout of the project. We would encourage you however, to undertake some upfront research (Google it!) before submitting your queries.

## Tasks

Please complete as many of the tasks below as you can within the alloted time, prioritising as you see fit. In addition you should fix any obvious bugs and consider resolving the concerns listed in the "Brief" (above).

### Pre Interview

#### Jobs Listing
* Ensure all Jobs from the fixtures XML data are displayed on the listing page.
* Ensure the following information is present on each Job item:
  * Title
  * Job Type (eg: Perm, Part time...etc)
  * Location
  * Salary
  * Closing date
  * Description (we advise this is truncated at a sensible char limit)
* Ensure there is a means for a user to click through to view the Single Job page for that Job

#### Single Job

* Ensure the page correcly displays the data for the Job Id provided in the url.
* Ensure the following information is present on the page:
  * Title
  * Job Type (eg: Perm, Part time...etc)
  * Location
  * Salary
  * Closing date
  * Full Description
  * Benefits List (if available)
  * Industries
  * Link to full details (`DetailUrl`)


### Post Interview

#### Job Application Form

* Ensure the form submits correctly passing the necessary fields to the form endpoint within the Plugin.
* Add a "Covering Letter" field to allow the applicant to add a plain text covering letter to accompany their application.
* Examin the form submission for validity using whatever criteria you deem appropriate. Display errors for invalid submissions.
* Store the Job Application against the Job Id, for retrival later
  * you may choose to utilise WordPress "Posts" for this. The previous developer has already registered a `Job Application` Post Type for you. You may also wish to consider the following utility functions:
  	* [`wp_insert_post()`](https://developer.wordpress.org/reference/functions/wp_insert_post/)
    * [`update_post_meta()`](https://codex.wordpress.org/Function_Reference/update_post_meta)
  * alternatively you may opt to utilise another method of your choosing
  * whichever method you choose, you must record:
    * Name
    * Email
    * Covering Letter
    * CV upload _PDF_ file
    * Job Id
    * Job Title
 * You might like to consider SPAM protection...

#### Client Application Review Function

* Ensure that our client can view all submitted Job Applications
* The client should be able to see full details of the Application from the CMS including:
	* Name
	* Email
	* Covering Letter
	* CV upload _PDF_ file
	* Job Id
	* Job Title
* Use whatever method(s) you see fit to make the experience as simple for the client to use as possible. They are a large client so they will probably get a lot of submissions...

## Workflow & Assessment

Each phase of the project is formed off 2 sub phases:

1. Initial project work
2. Code review

We advise you spend no more than 3hrs on phase 1 of the project and no more than 4hrs on phase 2.

Once you've created your initial PR, send us over the link. We'll expect you to commit _regular_ incremental updates to this PR as you go. Please avoid large commits. Repos containing a single commit will not be accepted.

Once you're happy with the state of your project, drop us a line indicating that you're ready for a code review. From here a member of our team will engage with you over Github and enter into a code review phase. 

We'll ask questions about your code and discuss changes or options for improvement (where necessary). 

This process helps to de-risk the intial project submission for you by providing you with the opportunity to amend and revise your code in response to feedback. That said you should still look to present you best work in your initial submission.

If you can provide a url to a live hosted instance of your project then that would be helpful. It is not essential however.

At the end of the project, we will advise whether you have successfully progressed to interview.

### We value your time

We understand that this code test represents a commitment of time from you. We have lives too and as such we are committed to respecting your valuable free time.

Our culture does not value "working late". We look for good time management and efficiency from all our employees. We _do not_ want you to burn out whilst working on this project! Please raise any concerns with your Mr B & Friends representative at the earliest opportunity so we can discuss options with you.

We recognise that for some applicants, it might be difficult to complete the entire project in one sitting. As such we promise to work around your schedule as required to allow you to complete the initial project to the best of your ability. Once complete, the code review phase can proceed on an ad hoc basis with updates being made as required with a lower time commitment.

We recommend that for everyone's sake the _entire_ process should require not longer than 1 week in _duration_ (please note this does not mean you have to spend a week's worth of work!). If you feel you'd like to extend this please speak with your Mr B & Friends representative.

