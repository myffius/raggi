<?php

	class RException extends ErrorException
	{
		public function __construct($message, $severity = null, $code = 0, $filename = __FILE__, $line = __LINE__, Exception $previous = null)
		{
			if ($severity === null)
				$severity = ErrorHandler::SEVERITY_ERROR;
			parent::__construct($message, $code, $severity, $filename, $line, $previous);
		}
	}
