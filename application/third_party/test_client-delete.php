<?php
require_once "HTTP/Request.php";

$url = "http://localhost/PHP-Exercises/CI/index.php";

$timeout = 2400;
$secret = "deadbeef";
$user = "bob";
$date = gmdate("d M Y H:i:s") . "Z";

$result = "";
$request_options = array("timeout", $timeout);
$req =& new HTTP_Request($url, $request_options);
$method = HTTP_REQUEST_METHOD_GET;

$req->addHeader("Accept", "application/json");
$req->addHeader("Date", $date);

$req->setMethod($method);
$req->addQueryString("resource", "widget_v1");
$req->addQueryString("id", "12345");

$url = $req->getUrl();

$signature = getClientAuthSignature($method, $url, $date, $user, $secret);
$req->addHeader("X-Authorization", $user . ":" . $signature);

$req->sendRequest();
$code = $req->getResponseCode();
$json = $req->getResponseBody();
print_r("The URL was [{$req->getURL()}].");
print_r("The response code was [{$code}].");
//pprint_r($req->getResponseHeader());
print_r($json);

    /**
     * getClientAuthSignature Function
     *
     * getClientAuthSignature($method, $url, $date, $user, $secret)
     *
     * $method : The HTTP request method, e.g. GET, POST, etc.
     * $url    : The request URL
     * $date   : The GMT date timestamp, e.g. 24 Mar 2011 19:46:50Z
     * $user   : The web service user ID, e.g. bob
     * $secret : The shared secret for the user
     *
     * Returns the authorization signature used by the web service.
     *
     * @access  public
     * @return  string
     */
    function getClientAuthSignature($method, $url, $date, $user, $secret) {

        $request_url = parse_url($url);
        $query_string = $request_url['query'];

        parse_str($query_string,$params);
        // sort the parameters
        ksort($params);

        // create the canonicalized query
        $canonicalized_query = array();
        foreach ($params as $param=>$value)
        {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param."=".$value;
        }
        $canonicalized_query = implode("&", $canonicalized_query);

        // create the string to sign
        $string_to_sign = $method."\n".$canonicalized_query."\n".$date;

        // calculate HMAC with SHA256 and base64-encoding
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret, True));

        // encode the signature for the request
        $signature = str_replace("%7E", "~", rawurlencode($signature));

        return $signature;
    }
?>