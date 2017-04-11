<?php

// This file contains global variables to be used.

//login database
$loginDB = 'eorgLoginData' ;
	$UName = 'UserName';
	$UPasswd = 'PassWord';
	$FName = 'FullName' ;
	$Desig = 'Designations';
	$Sex = 'SEX';
// user database
$UserAppId = "ApplId";
$UserAppTy = "AppType";

//application database
	$AppId = 'ApplID';
	$stat = 'ApplStatus';
	$AppDate = 'ApplGenDate';

// Designation => user , database
$DesigDB = 'DesignationsData';
	$DesigD = 'Designation';
	$UNameD = 'UserName';

// User categories database
$catDB = 'UserCategoryData';
$levels = 'CategoryLevels';
$levelName = 'CategoryLevelName'; 

// application type database
$applnDB = 'ApplnDataBase';
$entries = 'entries';

// application path table and its entries
$applnPathTable = 'ApplnPathTable';
$groupId = 'GroupId';


// application count database
$applnCount = 'ApplicationCount';
	$applnTy = 'ApplicationType';
	$count = 'TotalNoOfApplications';
	$tillDate = 'UntilDate';

//table for post
$PostTable = "PostTable";
	//Colomn name for PostTable
	$NameOfThePost = "PostName";
	$CanAddUser ="AddUser";
	$CanDeleteUser = "DeleteUser";
	$CanAssignPost = "AssignPost";
	$CanHandlePost = "handlePost";
	$CanAcceptApplication = "AcceptAppl";
	$CanAccessDataBaseOfUser = "AccessDatabese";

// assign post table and its entries
$assignPostTable = 'AssignPostTable';
$postTitle = 'PostTitle';
$assignedUser = 'AssignedUser';


?>
