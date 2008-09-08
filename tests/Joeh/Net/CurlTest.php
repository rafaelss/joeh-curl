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

require_once dirname(__FILE__) . "/../../config.php";
require_once VENDOR_PATH . "Joeh/Test/UnitTestCase.php";
require_once VENDOR_PATH . "Joeh/Net/Curl.php";

class Joeh_Net_CurlTest extends Joeh_Test_UnitTestCase {


	/**
	 * @var Joeh_Net_Curl $curl
	 */
	private $curl;

	public function setUp() {
		$this->curl = new Joeh_Net_Curl("http://www.google.com");
	}

	public function tearDown() {
		$this->curl = null;
	}

	public function testInit() {
		$this->assertType("resource", $this->curl->getHandle());
		$this->assertSame("http://www.google.com", $this->curl->getOptions()->url);

		$curl = new Joeh_Net_Curl();
		$this->assertType("resource", $curl->getHandle());
		$this->assertNull($curl->getOptions()->url);
	}

	public function testExecute() {
        $response = $this->curl->execute();
		$this->assertType("Joeh_Net_Curl_Response", $response);
		$this->assertTrue($response->hasHeader());
        $this->assertSame(302, $response->statusCode());
	}

    public function testExecuteWithFollowLocationAndOpenBaseDir() {
        $response = $this->curl
            ->followLocation(true)
            ->execute();

        $this->assertType("Joeh_Net_Curl_Response", $response);
        $this->assertTrue($response->hasHeader());
        $this->assertSame(200, $response->statusCode());
    }

	public function testUndefinedOption() {
		$this->setExpectedException("Joeh_Net_Curl_Exception", "Invalid option - invalidOption");
		$this->curl->invalidOption("invalid value");
	}
}
?>