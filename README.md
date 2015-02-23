cc-linkshare
======================
traviswachendorf@iheartmedia.com

* This app will be programmed in PHP 4.4.9 *

This is a contesting tool to let site users enter a contest. Once they enter, there is a unique page created for them. They then share the link to their unique page and every time someone visits their unique URL, they recieve a vote (1 per IP per day).

These files are meant to create:
- User contesting that allows submissions and records pageviews as votes


Server Requirements:
- MySQL Database

Other Requirements:
- System currently uses an IP database table to verify that users IP's are only from US, Canada and Mexico.
- If you wish to not perform IP checking, you must edit the file -lib/share.class.php- and edit the -isGoodIP()- function

Installation Instructions
- 1. Create a database on your MYSQL Server
- 2. Import contest tables using -sql/tables-linkshare.sql- file *IP table is over 7MB, so be patient.
- 3. Set up database connection credentials and other contest details in -lib/config-sample.inc.php- file
- 4. Rename file -lib/config-sample.inc.php- to -lib/config.inc.php-
- 5. Create Header image (images/header.jpg - 990px x 237px) and Thumb image (images/thumb.jpg - 200px x 200px) for contest
- 6. Tweak page text by editing -index.php- in 2 locations (main text and above form text)

To create additional contests
- 1. Duplicate share contest folder
- 2. Rename and upload to server in '/common/share/''
- 3. Duplicate ls_CONTEST_NAME_entrants table
- 4. Duplicate ls_CONTEST_NAME_voters table
- 5. Edit 'lib/config.inc.php' to set new table names and contest details
- 6. Edit 'index.php' file to set page text


