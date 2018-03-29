<?php

use JonnyW\PhantomJs\Client;

class CheckStatus
{
    public static function search() {
		
		//Copy and Paste IP range with line break (note: this IP range belongs to FaceBook)
        $str = "31.13.24.0/21
		31.13.64.0/19
		31.13.64.0/24
		31.13.69.0/24
		31.13.70.0/24
		31.13.71.0/24
		31.13.72.0/24
		31.13.73.0/24
		31.13.75.0/24
		31.13.76.0/24
		31.13.77.0/24
		31.13.78.0/24
		31.13.79.0/24
		31.13.80.0/24
		66.220.144.0/20
		66.220.144.0/21
		66.220.149.11/16
		66.220.152.0/21
		66.220.158.11/16
		66.220.159.0/24
		69.63.176.0/21
		69.63.176.0/24
		69.63.184.0/21
		69.171.224.0/19
		69.171.224.0/20
		69.171.224.37/16
		69.171.229.11/16
		69.171.239.0/24
		69.171.240.0/20
		69.171.242.11/16
		69.171.255.0/24
		74.119.76.0/22
		173.252.64.0/19
		173.252.70.0/24
		173.252.96.0/19
		204.15.20.0/22
		69.63.176.0/20
		173.252.64.0/18
		103.4.96.0/22
		31.13.64.0/18
		31.13.65.0/24
		31.13.67.0/24
		31.13.68.0/24
		31.13.74.0/24
		31.13.96.0/19
		31.13.66.0/24
		69.63.178.0/24
		31.13.82.0/24
		31.13.83.0/24
		31.13.84.0/24
		31.13.85.0/24
		31.13.87.0/24
		31.13.88.0/24
		31.13.89.0/24
		31.13.90.0/24
		31.13.91.0/24
		31.13.92.0/24
		31.13.93.0/24
		31.13.94.0/24
		31.13.95.0/24
		69.171.253.0/24
		69.63.186.0/24
		69.63.176.0/20 
		45.64.40.0/22
		129.134.0.0/16
		157.240.0.0/16
		179.60.192.0/22
		185.60.216.0/22";

        //Create array from IP addresses
        $ip = explode("\n", $str);
        $fun = function($n)
        {
            return explode("/", $n)[0];
        };
        $ip = array_map($fun, $ip);

        //Create every possible IP address
        $fun2 = function ($n) {
            $ary = array();
            $ip = explode(".",$n);
            for ($x = 11; $x <= 255; $x++) {
                $ary[] = $ip[0].".".$ip[1].".".$ip[2].".".$x;
            }
            return $ary;
        };
        $ip = array_map($fun2, $ip);
        $ip = array_reduce($ip, 'array_merge', array());
        foreach ($ip as $i){
            $state = self::test("http://".$i."/");
            echo $i . "--------" . $state . "\n";
        }
    }

    // Using PhantomJS validate every IP
    public static function test($url) {
        $client = Client::getInstance();
        $client->getEngine()->setPath( base_path() . '\bin\phantomjs.exe');
        $request = $client->getMessageFactory()->createRequest($url, 'GET');
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);
        // Get status code
        return $response->getStatus();
    }
}
