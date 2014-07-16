<?php
include('lib/config.inc.php');
include('lib/db.inc.php');
include('lib/share.class.php');

// misc
$x = rand(1,9999);
$shareLink = urlencode($_SERVER['SCRIPT_URI']. '?' . $_SERVER['QUERY_STRING']);
$thumbLink = $_SERVER['SCRIPT_URI'].'/images/thumb.jpg';


// url code
$url = array();
foreach($_GET as $key=>$value){
	$url[] = $key;
}
$id = $url[0];


// initialize contest object
$s = new Share();
$step=1;
$msg='';


// get calendar for display
$leaderboardHTML = $s->getLeaderboard('short');


// vote page
if(isset($id) && $id!=0){
	if($entrant = $s->getUserEntry($id)){
		$voteMsg = $s->trackVote($entrant);
		$step=3;
		$html = $s->getEntryForm();
		$caption = 'Vote%20for%20'.$entrant['fname'];
	}
	else {
		header("Location: index.php");
	}
}


// entry page
else {
	$html = $s->getEntryForm();
}


// contest entry
if(isset($_POST['entryForm'])){
	if($s->doEntry($_POST)){
		$msg = '<p class="success"><i class="fa fa-star"></i> Thanks for your entry. Check your email for your unique URL and information on how to get started earning votes!</p>';
		$step = 2;
	}
	else { $msg = '<p class="error"><i class="fa fa-exclamation-circle"></i> It appears this email has already entered the contest. Please check your email for further instructions.</p>';}
}


//updated local page template
include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

//set variables for og tags and other meta data
$page_title = CONTEST_TITLE;
$page_description = $contest_description;
$keywords = $contest_keywords;
$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
include('CCOMRheader.template'); // do not modify this line
?>


<!-- stylesheets -->
<link rel="stylesheet" href="css/style.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" href="css/font-awesome.min.css?x=<?php echo $x; ?>" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Roboto+Slab:400,700' rel='stylesheet' type='text/css'>


<!-- pagecontainer -->
<div class="pageContainer">

	<!-- header -->
	<div class="header">
		<img src="images/header.jpg" />
	</div>

	<!-- content column -->
	<div class="lCol">

		<?php
			echo $msg;

			// user details
	    	if($step==3){ 
	    		
	    		echo $voteMsg;
	    		?>
	    		<div class="quotebox">
				<h3><?php echo ENTRY_LABEL; ?></h3>
				<blockquote>&quot;<?php echo $entrant['user_text']; ?></blockquote>
				<p>- <?php echo $entrant['fname'].' '.substr($entrant['fname'],0,1); ?>.</p>
				</div>
	    <?php } ?>

	    <h2>Wanna win a trip to Yuma?</h2>
	    <p>MIX 96.9 wants to treat you to the magic of both Disney Theme Parks. At <em>Disneyland<sup>&reg;</sup></em> Park, experience the return of Big Thunder Mountain Railroad with new surprises. Then, catch the Fantasyland Theater musical stage show starring Mickey Mouse.</p>
	    <p class="maintext">Plus, explore the reimagined Disney California Adventure<sup>&reg;</sup> Park, including the high-octane thrills of Cars Land and the nighttime spectacular World of Color! And don't forget all the food, fun and shopping of the Downtown Disney<sup>&reg;</sup> District. So get ready to see why the happiest place on earth keeps getting happier!</p> 
	  
	</div>

	<!-- sidebar column -->
	<div class="rCol white-bg">

		<!-- sharing buttons -->
	    <div id="shareit">
	    	Share this page:<br />
	    	<a href="https://www.facebook.com/dialog/feed?app_id=<?php echo FB_APP_ID; ?>&link=<?php echo $shareLink; ?>&picture=<?php echo $thumbLink; ?>&name=<?php echo $page_title; ?>&caption=<?php echo $caption; ?>&description=<?php echo $contest_description; ?>&redirect_uri=<?php echo $shareLink; ?>" target="_blank"><i class="fa fa-facebook-square fa-3x"></i></a>
	    	<a href="http://twitter.com/share?text=<?php echo $page_title; ?>&url=<?php echo $shareLink; ?>" target="_blank"><i class="fa fa-twitter-square fa-3x"></i></a>
	    </div>

	    <!-- prizes -->
		<div class="calendar">
			<h3>What can you win?</h3>
		    <?php
		    echo '<ul>';
		    foreach($contest_prizes as $prize){
				echo '<li>'.$prize.'</li>';		  
		    }
		    echo '</ul>';
		    ?>
		</div>

		<a href="<?php echo $contest_rules; ?>" class="button" target="_blank"><i class="fa fa-pencil"></i> Contest Rules</a>

	</div>

	<div class="clear"></div>

	<!-- content column -->
	<div class="lCol gray-bg">

    <?php
    	// form
    	if($step==1 || $step==3){
    		?>
			<h3><i class="fa fa-arrow-down"></i> Enter Below</h3>
    		<p class="maintext">What is your favorite <em>Disneyland<sup>&reg;</sup></em> Resort show or attraction? Enter below and tell us in 196 characters or less. When you do, you'll be given your very own MIX 96.9 Fan Page. Then, share the link with everyone you know and have them visit it daily. The contestant who has the most unique views of their Fan Page by 7:00 PM on June 6th will win a Vacation Package to the <em>Disneyland<sup>&reg;</sup></em> Resort. See official rules for details.</p>
    		<?php
    		echo $html;
    	}
	
    ?>

	</div>
    

	<!-- sidebar column -->
	<div class="rCol leaderboard">
      
	    <!-- box ad -->
	    <div class="adbox">
	        <div id="DARTad300x250"><script>DFP.pushAd({div:"DARTad300x250",size:"300x250",position:"3307"} );</script></div>
	    </div>

		<h3>Leaderboard</h3>
		<?php echo $leaderboardHTML; ?>
	    
	</div>

	<div class="clear"></div>

</div>
<!-- end pagecontainer -->

<script src="js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function() {
		$("#theForm").validate();
	});
</script>


<?php include('CCOMRfooter.template'); ?>