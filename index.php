<?php

	$config = 'application/config/main.php';
	
	$request = RRequest::createFromGlobal();
	$app = new RApplication();
	$app->configure($config);
	$app->processRequest($request);
	$response = $app()->getResponse()
	$response->send();
