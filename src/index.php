<?php

include_once('cURL.php');

/**
 * Class cURL_Helper
 */
class cURL_Helper
{

    /**
     * To Call URL via cURL.
     */
    public function callURL()
    {
        $curl = new cURL();
        $url = 'URL_TO_LOAD';
        $curl->curlCall($url);
    }

    /**
     * To Login via cURL.
     */
    public function login()
    {
        $curl = new cURL();
        $url = 'LOGIN_URL';
        $url_to_graph = 'URL_TO_GRAPH'; // After Logged In.
        $uname = 'UNAME';
        $pass = 'PASS';
        $curl->curlLogin($url, $uname, $pass, $url_to_graph);
    }

    /**
     * To Trigger the Download.
     */
    public function download()
    {
        $curl = new cURL();
        $url = 'FILE_TO_DOWNLOAD';
        $destination = 'PATH_TO_STORE';
        $curl->downloadFile($url, $destination);
    }

    /**
     * To Get list of Site Info.
     */
    public function getInfo()
    {
        $curl = new cURL();
        $url = 'URL_TO_DOWNLOAD';
        $curl->getSiteInfo($url);
    }
}
