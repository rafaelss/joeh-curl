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

require_once 'Joeh/Net/Curl/Response.php';
require_once 'Joeh/Net/Curl/Option.php';

class Joeh_Net_Curl {

    #####################
    ## PRIVATE ATTRIBUTES
    #####################

	private $handle;

	private $option;

    private $curlExec = true;

    private $curlExecLoops = 0;

    private $curlExecMaxLoops = 20;

    ################
    ## MAGIC METHODS
    ################

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

    #################
    ## PUBLIC METHODS
    #################

	public function getHandle() {
		return $this->handle;
	}

	public function getOptions() {
		return $this->option;
	}

	public function execute() {
        if(isset($this->option->followLocation)) {
            if(!@curl_setopt(CURLOPT_FOLLOWLOCATION, $this->option->followLocation)) {
                unset($this->option->followLocation);
                $this->curlExec = false;
            }
        }

		$handle = $this->getHandle();
		curl_setopt_array($handle, $this->option->getForExecute());
		$response = $this->exec($handle);
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

    private function exec($handle) {
        if($this->curlExec) {
            return curl_exec($handle);
        }

        if ($this->curlExecLoops++ >= $this->curlExecMaxLoops) {
            $this->curlExecLoops = 0;
            return false;
        }

        $data = curl_exec($handle);

        $debbbb = $data;
        list($header, $data) = explode(PHP_EOL . PHP_EOL, $data, 2);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($httpCode == 301 || $httpCode == 302) {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
            if (!$url) {
                $this->curlExecLoops = 0;
                return $data;
            }

            $lastUrl = parse_url(curl_getinfo($handle, CURLINFO_EFFECTIVE_URL));
            $newUrl = $url['scheme'] . '://' . $url['host'];

            if(!empty($url['path'])) {
                $newUrl .= $url['path'];
            }

            if(!empty($url['query'])) {
                $newUrl .= '?' . $url['query'];
            }

            curl_setopt($handle, CURLOPT_URL, $newUrl);
            return $this->exec($handle);
        }
        else {
            $this->curlExecLoops = 0;
            return $debbbb;
        }
    }
}
?>