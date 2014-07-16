<?php
/* CC Linkshare Contesting Configuration File
 * Original Creation Date 07.2014
 * Wherein we define some constants for the system
 */

	
	// error reporting and timezone setup
		error_reporting(E_ERROR);
		ini_set('display_errors', 1);
		putenv('TZ=America/Phoenix');

	// site paths
		define('BASE_URL',''); // use for cc
		define('ROOT_PATH',''); // use for cc

	// database connection - local development
		/*define('DB_HOST','localhost');
		define('DB_USER','root');
		define('DB_PASS','root');
		define('DB_NAME','devdb');*/


	// database connection - production
		define('DB_HOST','');
		define('DB_USER','');
		define('DB_PASS','');
		define('DB_NAME','');
		

	// ads, facebook share
	// creage new case for each market station
		define('AD_MARKET','PHOENIX-AZ');

		switch($_SERVER['HTTP_HOST']){

			// Localhost
			case 'localhost':
			define('AD_STATION','localhost');
			define('AD_FORMAT','LOCALHOST');
			break;

			// 104.7 KISSFM
			case 'www.1047kissfm.com':
			define('FB_APP_ID','118663364875290');
			define('AD_STATION','kzzp-fm');
			define('AD_FORMAT','CHRPOP');
			break;

			
		}

	

	// database tables
	// fill constants with your specific values
		define('ENTRANT_TABLE',YOUR_ENTRANT_TABLE_NAME_HERE);
		define('VOTER_TABLE',YOUR_VOTER_TABLE_NAME_HERE);

		define('CONTEST_TITLE',CONTEST_TITLE);
		define('EMAIL_FROM',YOUR_EMAIL_ADDRESS_FOR_AUTORESPONDER);
		
		define('ENTRY_LABEL','Why is your grandma the best ever?');

		$contest_keywords = 'contest,linkshare';
		$contest_description = 'Description here.';
		$contest_rules = 'test.pdf';
		$contest_prizes = array(
			'A 5-Day stay at Grandma\'s House',
			'Airfare to and from Yuma, AZ',
			'$1,000 worth of Hanes undershirts'
			);

	