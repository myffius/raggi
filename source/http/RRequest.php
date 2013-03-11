<?php

	class RRequest extends RCore
	{
		protected $requestUri;
		protected $post;

		public function __construct()
		{
			$this->init($this->getRequestUri(), $_POST, $_COOKIE);
		}

		public function init($uri, $postData = array(), $cookies = array())
		{
			$this->setRequestUri($uri);
			$this->post = new RParamsCollection($postData);
		}

		public function getRequestUri()
		{
			if ($this->requestUri !== null)
				return $this->requestUri;

			// todo реализовать кроссерверное определение URI
			return $_SERVER['REQUEST_URI'];
		}

		private function setRequestUri($uri, $rewrite = false)
		{
			$this->requestUri = $uri;

			if ($rewrite)
				$rewrite = $rewrite;
			return $this;
		}
	}
