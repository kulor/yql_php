<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        
// include OAuth lib
require("OAuth.php");

class yql_lib{
    function __construct(){
        // define your consumer key   
        $this->consumerKey = "";

        // define your consumer key secret   
        $this->consumerSecret = "";

        // Don't have an app set up yet?     
        // Sign up for one here:     
        // https://developer.yahoo.com/dashboard/createKey.html
    }
    
    public function test_query(){
        // make sample request to YQL    
        $data = $this->query("select name,centroid,woeid from geo.places where text=\"YVR\"");
        return $data;
    }


    public function query($query)
    {    
        // define the base URL to the YQL web-service    
        $base_url = "http://query.yahooapis.com/v1/yql";

        // create arguments to sign.
        $args = array();
        $args["q"] = $query;   
        $args["format"] = "json"; // Nice and easy for us to parse

        // passing the key and secret strings to define our consumer.
        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);

        // build and sign the request
        $request = OAuthRequest::from_consumer_and_token($consumer, NULL, "GET", $base_url, $args);     
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);   

        // finally create the URL   
        $url = sprintf("%s?%s", $base_url, $this->oauth_http_build_query($args));

        // and the OAuth Authorization header   
        // $headers = array($request->to_header()); // Default does not contain the realm. But we need it
        $headers = array($request->to_header('yahooapis.com'));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rsp = curl_exec($ch);

        $data = json_decode($rsp);

        // since we requested JSON we'll decode it    
        // and return the data as a PHP object    
        if(isset($data->query)){
            // print the result.
            $results = $data->query->results;
            return $results;
        } else {
            return false;
        }
    }


    private function oauth_http_build_query($parameters) {  
        $strings = array();  
        foreach($parameters as $name => $value) {
            // Convert a url key=value to array values
            $strings[] = sprintf("%s=%s", rawurlencode($name), rawurlencode($value));  
        }  
        $query = implode("&", $strings);
        return $query;
    }
}