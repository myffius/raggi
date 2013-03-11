<?php

	$config = 'application/config/main.php';
	
	$request = new RRequest();
	$app = new RApplication();
	$app->configure($config);
	$app->processRequest($request);
	$response = $app->getResponse();
	$response->send();

