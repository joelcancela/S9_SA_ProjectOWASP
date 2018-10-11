<?php
/**
 * MINI-CMS PROJECT
 * ____________________________________
 * M2105 - DUT R&T - IUT de Caen
 * Année Universitaire : 2013-2014
 * ____________________________________
 *
 * @categories	Systems Administration, Education
 * @package		Mini-CMS
 * @author		Nikita ROUSSEAU
 * @author		Simon MESNAGE
 * @copyright	2014
 */

$TITLE = 'Admin Login';
$SUBTITLE = '';
$PAGE = 'login';

require( realpath(dirname(__FILE__)).'/conf.inc.php' );
require( PROJECT_DIR.'/includes/func.inc.php' );

/**
 * MySQL connection
 */
try {
	// Connect to MySQL
	$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASSWORD);

	// Set errormode to exceptions
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
	die();
}

/**
 * Retrive more configuration settings from the MySQL database
 */
try {
	$sth = $dbh->prepare("
			SELECT *
			FROM ".DBNAME.".".DBPREFIX."config
			;");

	$sth->execute();
	$settings = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach ($settings as $setting) {
			define( $setting['setting'], $setting['value'] );
	}

	unset($settings, $dbh);
}
catch (PDOException $e) {
	echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine();
	die();
}

/**
 * Authentication
 */
session_start();

if (isAdminLoggedIn() == TRUE)
{
	header( "Location: dashboard.php" );
	die();
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/header.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

if (!empty($_SESSION['lockout']) && ((time() - 60 * 10) < $_SESSION['lockout']))
{
?>
			<div class="alert alert-block">
				<h4 class="alert-heading"><?php echo 'Too Many Incorrect Login Attempts'; ?></h4>
			</div>
<?php
}
else
{
	if (isset($_SESSION['loginerror']))
	{
?>
			<div class="alert alert-warning alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Warning!</strong> Authentication failed !
			</div>
<?php
		unset($_SESSION['loginerror']);
	}
?>

			<div class="container">
				<div class="row vertical-offset-100">
					<div class="col-md-4 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Please sign in</h3>
							</div>
							<div class="panel-body">
								<form accept-charset="UTF-8" role="form" action="login.process.php" method="post">
								<input type="hidden" name="task" value="processlogin">
								<fieldset>
									<div style="margin-bottom: 15px" class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input id="login-username" type="text" class="form-control" name="username" value="<?php

	if (!empty($_COOKIE['rememberMe']))
	{
		echo htmlspecialchars($_COOKIE['rememberMe']);
	}

	?>" placeholder="username">
									</div>
									<div style="margin-bottom: 15px" class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input id="login-password" type="password" class="form-control" name="password" placeholder="password">
									</div>
									<div class="checkbox">
										<label>
											<input name="remember" type="checkbox" value="Remember Me" <?php

	if (!empty($_COOKIE['rememberMe']))
	{
		echo 'checked';
	}

	?>>&nbsp;Remember Me
										</label>
									</div>
									<input class="btn btn-lg btn-info btn-block" type="submit" value="Login">
								</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

require( STYLE_DIR.'/footer.inc.php' );

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>