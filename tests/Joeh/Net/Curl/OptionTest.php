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

require_once dirname(__FILE__) . "/../../../config.php";
require_once VENDOR_PATH . "Joeh/Test/UnitTestCase.php";
require_once VENDOR_PATH . "Joeh/Net/Curl/Option.php";

class Joeh_Net_Curl_OptionTest extends Joeh_Test_UnitTestCase {
	
	private $curlOption;
	
	public function setUp() {
		$this->curlOption = new Joeh_Net_Curl_Option();
	}
	
	public function testUrl() {
		$this->stringOptionsTest("url", "http://www.w3haus.com.br");
	}

	public function testVerbose() {
		$this->booleanOptionsTests("verbose");
	}
	
	public function testInFileSize() {
		$this->integerOptionsTests("lowSpeedLimit", 1024000);
	}

	public function testNoProgress() {
		$this->booleanOptionsTests("noProgress");
	}

	public function testNobody() {
		$this->booleanOptionsTests("nobody");
	}
	
	public function testFailOnError() {
		$this->booleanOptionsTests("failOnError");
	}
	
	public function testUpload() {
		$this->booleanOptionsTests("upload");
	}
	
	public function testPost() {
		$this->booleanOptionsTests("post");
	}
	
	public function testFtpListOnly() {
		$this->booleanOptionsTests("ftpListOnly");
	}
	
	public function testFtpAppend() {
		$this->booleanOptionsTests("ftpAppend");
	}
	
	public function testNetRc() {
		$this->booleanOptionsTests("netRc");
	}
	
	public function testFollowLocation() {
		$this->booleanOptionsTests("followLocation");
	}
	
	public function testPut() {
		$this->booleanOptionsTests("put");
	}
	
	public function testTimeout() {
		$this->integerOptionsTests("lowSpeedLimit", 5);
	}
	
	public function testLowSpeedLimit() {
		$this->integerOptionsTests("lowSpeedLimit", 100000);
	}
	
	public function testLowSpeedTime() {
	    $this->integerOptionsTests("lowSpeedLimit", 10);
	}
	
	public function testResumeFrom() {
	    $this->integerOptionsTests("lowSpeedLimit", 512);
	}
	
	public function testCaInfo() {
		$this->stringOptionsTest("caInfo", "cainfo.file");
	}
	
	public function testSslVerifyPeer() {
	    $this->booleanOptionsTests("sslVerifyPeer");
	}
	
	public function testSslVersion() {
	    $this->integerOptionsTests("sslVersion", 2);
	    $this->integerOptionsTests("sslVersion", 3);
	}
	
	public function testSslVerifyHost() {
		$this->booleanOptionsTests("sslVerifyHost");
	}
	
	public function testTimeCondition() {
	    $this->integerOptionsTests("timeCondition", time());
	}
	
	public function testTimeValue() {
	    $this->integerOptionsTests("timeValue", time());
	}
	
	public function testUserPwd() {
		$this->stringOptionsTest("userPwd", "username:password");
	}
	
	public function testProxyUserPwd() {
		$this->stringOptionsTest("proxyUserPwd", "username:password");
	}
	
	public function testRange() {
		$this->stringOptionsTest("range", "100-200");
		$this->stringOptionsTest("range", "100-200,300-400");
	}
	
	public function testPostFields() {
		$this->stringOptionsTest("postFields", "name=joeh&age=23");
	}
	
	public function testReferer() {
		$this->stringOptionsTest("referer", "http://www.google.com.br/?s=php");
	}
	
	public function testUserAgent() {
		$this->stringOptionsTest("userAgent", "JoehBrowser 0.1");
	}
	
	public function testFtpPort() {
		$this->stringOptionsTest("ftpPort", "127.0.0.1");
		$this->stringOptionsTest("ftpPort", "my.server");
		$this->stringOptionsTest("ftpPort", "eth0");
		$this->stringOptionsTest("ftpPort", "-");
	}
	
	public function testCookie() {
		$this->stringOptionsTest("cookie", "mycookie");
	}
	
	public function testSslCert() {
		$this->stringOptionsTest("sslCert", "my.cert");
	}
	
	public function testSslCertPasswd() {
		$this->stringOptionsTest("sslCertPasswd", "mycertpasswd");
	}
	
	public function testCookieFile() {
		$this->stringOptionsTest("cookieFile", "/tmp/cookie.txt");
	}
	
	public function testCustomRequest() {
		$this->stringOptionsTest("customRequest", "PUT");
		$this->stringOptionsTest("customRequest", "DELETE");
	}
	
	public function testProxy() {
		$this->stringOptionsTest("proxy", "myproxy.com");
	}

	public function testInterface() {
		$this->stringOptionsTest("interface", "eth0");
		$this->stringOptionsTest("interface", "127.0.0.1");
		$this->stringOptionsTest("interface", "myserver.com");
	}
	
	public function testKrb4Level() {
	    $levels = array('clear', 'safe', 'confidential', 'private');
	    foreach($levels as $level) {
	    	$this->stringOptionsTest("krb4Level", $level);
	    }
	}

	public function testHttpHeader() {
		$header = array("Accept: text/html", "Content-type: text/html; charset=utf-8");

	    $this->curlOption->httpHeader($header);
	    $this->assertSame($header, $this->curlOption->httpHeader);
	}

	public function testQuote() {
	    $commands = array("PORT", "PASV", "TYPE A");

	    $this->curlOption->quote($commands);
	    $this->assertSame($commands, $this->curlOption->quote);
	}

	public function testPostQuote() {
	    $commands = array("PORT", "PASV", "TYPE A");

	    $this->curlOption->quote($commands);
	    $this->assertSame($commands, $this->curlOption->quote);
	}

	public function testFile() {
	    $fp = fopen(TMP_PATH . "file.out", "w");

	    $this->curlOption->file($fp);
	    $this->assertSame($fp, $this->curlOption->file);
	}

	public function testInFile() {
		$fp = fopen(TMP_PATH . "file.out", "r");

	   	$this->curlOption->inFile($fp);
	    $this->assertSame($fp, $this->curlOption->inFile);
	}
	
	public function testWriteHeader() {
		$callback = array($this, "writeHeaderCallback");

	    $this->curlOption->writeHeader($callback);
	    $this->assertSame($callback, $this->curlOption->writeHeader);
	}

	public function testStdError() {
	    $fp = fopen(TMP_PATH . "file.err", "w");

	    $this->curlOption->stdError($fp);
	    $this->assertSame($fp, $this->curlOption->stdError);
	}
	
	public function testIsset() {
		$this->assertFalse(isset($this->curlOption->url));
		$this->curlOption->url("http://www.google.com.br");
		$this->assertTrue(isset($this->curlOption->url));
	}
	
	public function testGetForExecute() {
		$this->curlOption->url("http://www.google.com.br");

		$this->assertSame(array(CURLOPT_URL => "http://www.google.com.br"), $this->curlOption->getForExecute());
	}

	##################
	## PRIVATE METHODS
	##################
	
	private function stringOptionsTest($option, $value) {
		$this->curlOption->$option($value);
		$this->assertSame($value, $this->curlOption->$option);
	}
	
	private function booleanOptionsTests($option) {
		$this->curlOption->$option(true);
		$this->assertTrue($this->curlOption->$option);
		
		$this->curlOption->$option(false);
		$this->assertFalse($this->curlOption->$option);
	}
	
	private function integerOptionsTests($option, $value) {
		$this->curlOption->$option($value);
		$this->assertSame($value, $this->curlOption->$option);
	}
}
?>