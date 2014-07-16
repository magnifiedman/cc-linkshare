<?php
/**
 * CC Linkshare share object class
 */

class Share {

	function Share(){

	}

	
	/**
	 * Send autoresponder email
	 * @param  string $subject  email subject
	 * @param  string $bodyText email content
	 * @return boolean          
	 */
	function autoResponder($emailTo, $subject, $bodyText){

		// send email
		$header  ="MIME-Version: 1.0\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\n";
		$header .= "From: Clear Channel Contesting <" . EMAIL_FROM . ">\r\n";
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			  <html xmlns="http://www.w3.org/1999/xhtml">
			  <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			  <title>Untitled Document</title>
			  </head>
			  
			  <body>
			  <center>
			  <table cellpadding="0" cellspacing="0" border="0" bgcolor="#d1d1d1">
			  <tr>
			  <td>
			  <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#e6e6e6">
			  <tr>
			  <td>'. $bodyText .'</td>
			  </tr>
			  </table>
			  </td>
			  </tr>
			  </table>
			  <table width="600" cellpadding="8" cellspacing="0" border="0" bgcolor="#ffffff">
			  <tr>
			  <td align="center">&copy; '.date("Y").' Clear Channel Media &amp; Entertainment</td>
			  </tr>
			  </table>
			  </center>
			  </body>
			  </html>';

		// send email		
		mail(trim($emailTo), $subject, $message, $header);
		
	}


	/**
	 * Contest Entry
	 * @param  array $vars submitted form data
	 * @return boolean     
	 */
	function doEntry($vars){
		$q = mysql_query("SELECT count(id) FROM " . ENTRANT_TABLE . "
			WHERE email = '". $vars['email'] . "'
			");
		if(mysql_result($q,0,'count(id)')>0){ return false; }
		else {
			$q = sprintf("INSERT into " . ENTRANT_TABLE . "
				(date_entered,fname,lname,email,phone,user_text,misc_1,misc_2,misc_3)
				VALUES (NOW(),'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
				",
				mysql_real_escape_string($vars['fname']),
				mysql_real_escape_string($vars['lname']),
				mysql_real_escape_string($vars['email']),
				mysql_real_escape_string($vars['phone']),
				mysql_real_escape_string($vars['user_text']),
				mysql_real_escape_string($vars['misc_1']),
				mysql_real_escape_string($vars['misc_2']),
				mysql_real_escape_string($vars['misc_3']));
			$r = mysql_query($q);
			$entrantID = mysql_insert_id();

			// send email to entrant
			$bodyText = '<p style="margin:20px; line-height:1.5em;"><strong>Congratulations!</strong></p>';
			$bodyText .= '<p style="margin:20px; line-height:1.5em;">Now that you have entered &quot;' . CONTEST_TITLE . '&quot;, it\'s time to start sharing your page and getting out the vote!</p>';
			$bodyText .= '<p style="margin:20px; line-height:1.5em;">In case you aren\'t sure how the contest works, here\'s a rundown:<br /><br />';
			$bodyText .= '&middot; Every time one of your friends or family clicks your unique contest URL, a vote is registered for you.<br />';
			$bodyText .= '&middot; Votes may be placed daily.<br />';
			$bodyText .= '&middot; Even if you click your link more than once a day, only one vote will be counted for that day.</p>';
			$bodyText .= '<p style="margin:20px; line-height:1.5em;"><strong>Your unique URL: <a href="">'.$_SERVER['SCRIPT_URI']. '?' . $entrantID . '</a></strong></p>';
			$bodyText .= '<p style="margin:20px; line-height:1.5em;">Now it\'s time to get to work!</p>';
			

			$this->autoResponder($vars['email'], 'Thanks For Your Entry into ' . CONTEST_TITLE ,$bodyText);
			return true;

		}
	}


	/**
	 * Get entry form HTML - index page
	 * @return string html
	 */
	function getEntryForm(){
		
		$html = '<form action="" method="post" id="theForm"><input type="hidden" name="entryForm" value="y" />';
		$html .= '<p><label>Your First Name:</label><input type="text" class="required" name="fname" /></p>';
		$html .= '<p><label>Your Last Name:</label><input type="text" class="required" name="lname" /></p>';
		$html .= '<p><label>Email Address:</label><input type="text" class="email required" name="email" /></p>';
		$html .= '<p><label>Phone:</label><input type="text" class="required" name="phone" /></p>';
		$html .= '<p><label>'. ENTRY_LABEL .'</label><textarea name="user_text" class="required"></textarea></p>';
		$html .= '<p><label></label><input type="submit" class="button" name="submit" value="Enter Now" /></p>';
		$html .= '</form>';
		return $html;

	}


	/**
	 * Get the users entry text - user page
	 * @param  integer $entrantID id of entrant
	 * @return boolean        
	 */
	function getUserEntry($entrantID){
		$q = mysql_query("SELECT * from " . ENTRANT_TABLE . "
			WHERE id = '". (int)$entrantID."'
			");
		if(mysql_num_rows($q)>0){ 
			$user = mysql_fetch_assoc($q);
			return $user;
		}
		else { return false; }

	}


	/**
	 * Gets users IP address
	 * @return string ip address
	 */
	function getUserIP() {
		$ip = '';
		
		if (isset($_SERVER)){
			//if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){ $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
			//if (isset($_SERVER["HTTP_CLIENT_IP"])) { $ip = $_SERVER["HTTP_CLIENT_IP"]; }
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		
		else {
			//if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) { $ip = getenv( 'HTTP_X_FORWARDED_FOR' ); }
			//if ( getenv( 'HTTP_CLIENT_IP' ) ) { $ip = getenv( 'HTTP_CLIENT_IP' ); }
			$ip = getenv( 'REMOTE_ADDR' );
		}

		return $ip;
	}


	/**
	 * Check location of user IP
	 * @param  string $ipAddress Users ip address
	 * @return boolean           
	 */
	function isGoodIP($ipAddress){
		$ip = ip2long($ipAddress);
		$q = mysql_query("SELECT country_short
			FROM ip_db 
			WHERE num_2 > '" . $ip . "'
			ORDER BY num_2 asc limit 0,1
			");
		$row = mysql_fetch_assoc($q);
		if($row['country_short']=='CA' || $row['country_short']=='MX'){
			return true;	
		}
		else {
			return false;
		}
		
	}


	/**
	 * Tracks the pageview/vote
	 * @param  array $entrant entrant details
	 * @return string        success or error message
	 */
	function trackVote($entrant){
		$ip = $this->getUserIP();
		if($this->isGoodIP($ip)){
			$q = mysql_query("SELECT id FROM " . VOTER_TABLE . "
				WHERE ip_address = '". $ip ."'
				");
			if(mysql_num_rows($q)>0){
				$voteMsg = '<p class="vote-error"><i class="fa fa-thumbs-down"></i> Sorry, vote could not be registered. It appears this IP address has already voted today. Please come back tomorrow!</p>';
			}
			else {
				$q = mysql_query("INSERT into " . VOTER_TABLE . "
					(date_entered,ip_address)
					values (NOW(),'".$ip."')
					");
				$q2 = mysql_query("UPDATE " . ENTRANT_TABLE . "
					set votes=votes+1
					WHERE id = '". $entrant['id'] . "'
					");
				$voteMsg = '<p class="vote-success"><i class="fa fa-thumbs-up"></i> Thanks! You just helped <strong>'. $entrant['fname'].' '.substr($entrant['lname'],0,1). '.</strong></p>';
			
			}
		}
		else {
			$voteMsg = '<p class="vote-error"><i class="fa fa-thumbs-down"></i> Sorry, vote could not be registered. It appears this IP address is located out of the approved voting region.</p>';
		}
		
		//$voteMsg = '<p class="vote-error"><i class="fa fa-thumbs-down"></i> Sorry, vote could not be registered. It appears you are voting from outside of our approved regions.</p>';
		return $voteMsg;
	}


	/**
	 * Returns leaderboard HTML
	 * @param  string $size number of leaders to return
	 * @return boolean
	 */
	function getLeaderboard($size){
		switch($size){
			case 'short':
			$limit = 10;
			break;

			case 'long':
			$limit = 20;
			break;
		}

		$q = mysql_query("SELECT fname,lname FROM " . ENTRANT_TABLE . "
			ORDER BY votes DESC
			LIMIT 0,". $limit );
		if(mysql_num_rows($q)>0){
			$html = '';
			$i=1;
			while($entrant = mysql_fetch_assoc($q)){
				$html .= '<div class="leader-tile"><i class="fa fa-user fa-2x"></i><p>'.$entrant['fname'].' '. substr($entrant['lname'],0,1). '.<br /><span>'.$i.'</span></p></div>';
				$i++;
			}
			$html .= '<div class="clear"></div>';
			
		}
		else {
			$html = '<p>* No current entrants.</p>';
		}
		return $html;


	}

}