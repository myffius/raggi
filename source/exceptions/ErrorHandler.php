<?php

namespace raggi\exceptions;

use \raggi\base\BaseComponent;

class ErrorHandler extends BaseComponent
{
	const SEVERITY_ERROR   = 'error';
	const SEVERITY_NOTICE  = 'notice';
	const SEVERITY_WARNING = 'warning';
	const SEVERITY_INFO    = 'info';
}
