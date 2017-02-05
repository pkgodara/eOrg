<?php

/*
 * Verify installed version of PHP.
 */

class PHPVersionCheck {

	#The number of eOrg version used.
	var $eorgVersion = '1.0';

	#Minimum PHP version required.
	var $minVersionPHP = '5.4.0';

	#entry point.
	var $entryPoint = null;

	function setEntryPoint( $entryPoint ) {
		$this -> entryPoint = $entryPoint;
	}

	#Return version of PHP installed.

	function getPHPVersion() {
		return PHP_VERSION;
	}

	#check for required version of PHP and display error.

	function checkPHPVersion() {
		if( version_compare( $this->getPHPVersion() , $this->minVersionPHP ) < 0 )
		{
			#PHP version less than required. Print error page.
			$shortInfo = "eOrg $this->eorgVersion requires at least PHP version "
				."$this->minVersionPHP , But you are using PHP {$this->getPHPVersion() }.";

			$this->triggerError( 'Unsupported PHP Version',$shortInfo );

		}
	}

	#Output error to end-user
	function triggerError( $title , $shortInfo ) {
		$finalOutput = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>eOrg {$this->eorgVersion}</title>
</head>

<body>
	<h1>WELCOME!</h1>
	<h2>$title</h2>
	<p>$shortInfo</p>
</body>
</html>
HTML;

		echo "$finalOutput\n";
		die(1);
	}
}


function checkEntryPoint( $entryPoint ) {
	$PHPVersionCheck = new PHPVersionCheck();
	$PHPVersionCheck->setEntryPoint( $entryPoint );
	$PHPVersionCheck->checkPHPVersion();
}

?>
