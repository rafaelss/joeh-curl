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
require_once VENDOR_PATH . "Joeh/Net/Curl/Response.php";

class Joeh_Net_Curl_ResponseTest extends Joeh_Test_UnitTestCase {

	/**
	 * @var Joeh_Net_Curl_Response $response
	 */
	private $response;

	public function setUp() {
		if($this->getName() != "testInit") {
			$this->response = $this->init();
		}
	}

	public function testInit() {
		$response = $this->init();
		$this->assertTrue($response->hasHeader());
		$this->assertTrue($response->hasBody());
	}

	public function testHttpVersion() {
		$this->assertSame("1.1", $this->response->httpVersion());
	}

	public function testStatusCode() {
		$this->assertSame(302, $this->response->statusCode());
	}

	public function testLocation() {
		$this->assertSame("http://www.google.com.br/", $this->response->location());
	}

	public function testContentType() {
		$this->assertSame("text/html; charset=UTF-8", $this->response->contentType());
	}

	public function testBody() {
		$this->assertNotNull($this->response->body());
	}

	/**
	 * @return Joeh_Net_Curl_Response
	 */
	private function init() {
		$ch = curl_init("http://www.google.com");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_NOBODY, true);
		$response = curl_exec($ch);
		curl_close($ch);

		return new Joeh_Net_Curl_Response($response);
	}
}
?>