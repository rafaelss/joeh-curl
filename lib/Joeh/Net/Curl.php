<?php
/*
The MIT License

Copyright (c) 2008 Rafael S. Souza

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

require_once "Joeh/Net/Curl/Response.php";
require_once "Joeh/Net/Curl/Option.php";

class Joeh_Net_Curl {

	private $handle;
	
	private $option;

	public function __construct($url = null) {
		$this->init();
		$this->option = new Joeh_Net_Curl_Option($this->getHandle());
		$this->option->url($url);
	}

	public function __destruct() {
		curl_close($this->getHandle());
	}

	public function __call($option, $arguments) {
		call_user_func_array(array($this->option, $option), $arguments);
		return $this;
	}

	public function getHandle() {
		return $this->handle;
	}

	public function getOptions() {
		return $this->option;
	}

	public function execute() {
		$handle = $this->getHandle();
		curl_setopt_array($handle, $this->option->getForExecute());
		$response = curl_exec($handle);
		return new Joeh_Net_Curl_Response($response);
	}

	##################
	## PRIVATE METHODS
	##################

	private function init() {
		$this->handle = curl_init();
		curl_setopt($this->handle, CURLOPT_HEADER, true);
		curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
	}
}
?>