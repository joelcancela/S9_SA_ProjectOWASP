<?php
/**
 * OWASP - Open Web Application Security Project
 * ____________________________________
 * Copyright 2018
 *
 * ____________________________________
 *
 * @categories	Security Project
 * @package		Mini-CMS
 * @author		Nikita ROUSSEAU
 * @author		Joël CANCELA
 * @author		Francois MELKONIAN
 * @copyright	2018
 */

###################################################################################################
/**
 * AUTH FUNCTIONS
 */
###################################################################################################

/**
 * Validating a User
 */
function validateAdmin()
{
    session_regenerate_id(true);
	$_SESSION['isLoggedIn'] = TRUE;
}

/**
 * Checking if a User is Logged In
 */
function isLoggedIn()
{
	if (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === TRUE))
	{
		return TRUE;
	}
	return FALSE;
}

/**
 * Logging Out
 */
function logout()
{
    $_SESSION = array();
	session_destroy();
    session_regenerate_id(true);
}

###################################################################################################
/**
 * MISC FUNCTIONS
 */
###################################################################################################

/**
 * Header Tab Generation
 * 
 * @param string $view
 * @param string $icon
 */
function generateNavigationLi($view = '', $icon = '') {
	$view = strtolower($view);

	?><a href="dashboard.php?view=<?php echo urlencode($view); ?>"><span class="glyphicon <?php echo htmlspecialchars($icon, ENT_QUOTES); ?>"></span>&nbsp;<?php echo htmlspecialchars(ucfirst($view), ENT_QUOTES); ?></a><?php

}

/**
 * My Triple MD5 Function
 * 
 * @param string $string
 * @param string $salt
 */
function tripleMd5($string = '', $salt = 'AgPu_o5x--ZER!') {
	return md5(md5(md5($string . $salt) . $salt) . $salt);
}
