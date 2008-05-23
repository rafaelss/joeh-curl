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

/**
 * @see Joeh_String
 */
require_once "Joeh/String.php";

class Joeh_Net_Curl_Response {

	private $hasHeader = false;

	private $hasBody = false;
	
	private $httpVersion;
	
	private $statusCode;
	
	private $statusDescription;

	private $headers = array();
	
	private $body;

	public function __construct($response) {
		$this->processHeader($response);
	}

	public function __call($name, $arguments) {
		if(isset($this->headers[$name])) {
			return $this->headers[$name];
		}
		return null;
	}
	
	public function hasHeader() {
		return $this->hasHeader;
	}

	public function hasBody() {
		return $this->hasBody;
	}

	public function httpVersion() {
		return $this->httpVersion;
	}
	
	public function statusCode() {
		return $this->statusCode;
	}
	
	public function statusDescription() {
		return $this->statusDescription;
	}
	
	public function body() {
		return $this->body;
	}

	##################
	## PRIVATE METHODS
	##################

	private function processHeader($response) {
		if(strpos($response, "HTTP/1.") === false) {
			return;
		}

		$this->hasHeader = true;
		$headers = split("\r\n", trim($response, "\r\n"));
		foreach($headers as $header) {
			if(empty($header)) {
				break;
			}

			if(preg_match("/HTTP\/(1.[0-9]+) ([0-9]{3}) (.*)/s", $header, $match)) {
				$this->httpVersion = $match[1];
				$this->statusCode = (int)$match[2];
				$this->statusDescription = $match[3];
			}
			else {
				$indexOf = strpos($header, ":");
				$name = Joeh_String::camelize(substr($header, 0, $indexOf));
				$value = substr($header, $indexOf+2);
				$this->headers[$name] = $value;
			}
		}

		$start = key($headers);
		if($start > 0) {
			$count = count($headers);
			$body = null;
			for($i = $start; $i < $count; $i++) {
				$body .= $headers[$i];
			}

			if($body !== null) {
				$this->hasBody = true; 
				$this->body = $body;
			}
		}
	}
}
?>