<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is used in error pages
	'adminEmail'=>'ducky.d.patito@gmail.com',
	'adminEmailPwd'=>'patitopatit',
	'mailer' => "smtp",
	'mailHost' => "ssl://smtp.gmail.com",
	'mailPort' => 465,
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentsCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'company'=>'TuerCo',
);
