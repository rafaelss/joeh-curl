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
 * @see Joeh_Net_Curl_Exception
 */
require_once "Joeh/Net/Curl/Exception.php";

class Joeh_Net_Curl_Option {

	private $methods = array(
		"inFileSize" => CURLOPT_INFILESIZE,
		"verbose" => CURLOPT_VERBOSE,
		/* "header" => CURLOPT_HEADER, */
		"headerFunction" => CURLOPT_HEADERFUNCTION,
		"noProgress" => CURLOPT_NOPROGRESS,
		"nobody" => CURLOPT_NOBODY,
		"failOnError" => CURLOPT_FAILONERROR,
		"upload" => CURLOPT_UPLOAD,
		"post" => CURLOPT_POST,
		"ftpListOnly" => CURLOPT_FTPLISTONLY,
		"ftpAppend" => CURLOPT_FTPAPPEND,
		"netRc" => CURLOPT_NETRC,
		"followLocation" => CURLOPT_FOLLOWLOCATION,
		"put" => CURLOPT_PUT,
		/* "mute" => CURLOPT_MUTE, */
		"timeout" => CURLOPT_TIMEOUT,
		"lowSpeedLimit" => CURLOPT_LOW_SPEED_LIMIT,
		"lowSpeedTime" => CURLOPT_LOW_SPEED_TIME,
		"resumeFrom" => CURLOPT_RESUME_FROM,
		"caInfo" => CURLOPT_CAINFO,
		"sslVerifyPeer" => CURLOPT_SSL_VERIFYPEER,
		"sslVersion" => CURLOPT_SSLVERSION,
		"sslVerifyHost" => CURLOPT_SSL_VERIFYHOST,
		"timeCondition" => CURLOPT_TIMECONDITION,
		"timeValue" => CURLOPT_TIMEVALUE,
		/* "returnTransfer" => CURLOPT_RETURNTRANSFER, */
		"url" => CURLOPT_URL,
		"userPwd" => CURLOPT_USERPWD,
		"proxyUserPwd" => CURLOPT_PROXYUSERPWD,
		"range" => CURLOPT_RANGE,
		"postFields" => CURLOPT_POSTFIELDS,
		"referer" => CURLOPT_REFERER,
		"userAgent" => CURLOPT_USERAGENT,
		"ftpPort" => CURLOPT_FTPPORT,
		"cookie" => CURLOPT_COOKIE,
		"sslCert" => CURLOPT_SSLCERT,
		"sslCertPasswd" => CURLOPT_SSLCERTPASSWD,
		"cookieFile" => CURLOPT_COOKIEFILE,
		"customRequest" => CURLOPT_CUSTOMREQUEST,
		"proxy" => CURLOPT_PROXY,
		"interface" => CURLOPT_INTERFACE,
		"krb4Level" => CURLOPT_KRB4LEVEL,
		"httpHeader" => CURLOPT_HTTPHEADER,
		"quote" => CURLOPT_QUOTE,
		"postQuote" => CURLOPT_POSTQUOTE,
		"file" => CURLOPT_FILE,
		"inFile" => CURLOPT_INFILE,
		"writeHeader" => CURLOPT_WRITEHEADER,
		"stdError" => CURLOPT_STDERR
	);

	private $options = array();

	public function __call($option, $arguments) {
		if(!isset($this->methods[$option])) {
			throw new Joeh_Net_Curl_Exception("Invalid option - {$option}");
		}

		$option = $this->methods[$option];
		$this->options[$option] = $arguments[0];
	}

	public function __get($option) {
		$option = $this->methods[$option];
		return $this->options[$option];
	}

	public function __isset($option) {
		$option = $this->methods[$option];
		return isset($this->options[$option]);
	}

    public function __unset($option) {
		$option = $this->methods[$option];
		unset($this->options[$option]);
    }

	public function getForExecute() {
		return $this->options;
	}

    /*
	public function set($option, $value) {
		curl_setopt($this->curl->getHandle(), $option, $value);
	}

	private function url() {
		return $this->getInfo(CURLINFO_EFFECTIVE_URL);
	}

	private function verbose() {
		return $this->getInfo(CURLOPT_AUTOREFERER);
	}

	private function getInfo($info) {
		$handle = $this->curl->getHandle();
		return curl_getinfo($handle, $info);
	}
	*/
}
?>