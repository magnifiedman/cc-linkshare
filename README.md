cc-linkshare
======================
traviswachendorf@clearchannel.com

* This app will be programmed in PHP 4.4.9 *

This is a contesting tool to let site users enter a contest. Once they enter, there is a unique page created for them. They then share the link to their unique page and every time someone visits their unique URL, they recieve a vote (1 per IP per day).

These files are meant to create:
- User contesting that allows submissions and records pageviews as votes


Server Requirements:
- MySQL Database

Other Requirements:
- System currently uses an IP database table to verify that users IP's are only from US, Canada and Mexico.
- If you wish to use this database table, email traviswachendorf@clearchannel.com to get the SQL dump sent to you.
- If you wish to not perform IP checking, you must edit the file -lib/share.class.php- and edit the -isGoodIP()- function

Installation Instructions
- 1. Create a database on your MYSQL Server
- 2. Import IP database table if you are using IP checking (you can get this file from traviswachendorf@clearchannel.com)
- 2. Set up database connection credentials and other contest details in -lib/config-sample.inc.php- file
- 4. Create Header image (images/header.jpg - 990px x 237px) and Thumb image (images/thumb.jpg - 200px x 200px) for contest
- 5. Tweak page text by editing -index.php- in 2 locations (main text and above form text)


