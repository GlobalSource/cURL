<?php

/**
 * Class cURL
 *
 * List of cURL Utils to Boost-up the Access.
 */
class cURL
{
    /**
     * cURL constructor.
     */
    public function __construct()
    {
        // To Verify that the cURL library is available or not.
        if (!$this->check()) die("Sorry, you don't have cURL library to access this package.");
    }

    /**
     * Basic level of cURL check.
     *
     * @return bool
     */
    public function check()
    {
        return function_exists('curl_version');
    }

    /**
     * To Call Specif URL and return the Data.
     *
     * @param bool $return_transfer to Specify, transfer status is needed or not.
     * @param bool $header to specify, the header of response is needed or not.
     * @param string $url the path to call.
     */
    public function curlCall($url, $return_transfer = true, $header = false)
    {
        // Init cURL.
        $curlSession = curl_init();
        // Set URL to Call.
        curl_setopt($curlSession, CURLOPT_URL, $url);
        // Set Return Transfer Status, like status response.
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, $return_transfer);
        // To Specify, whether the header is required or not.
        curl_setopt($curlSession, CURLOPT_HEADER, $header);
        // Init Execution of cURL.
        $out = curl_exec($curlSession);
        // After Completing the Operation, Close the Connection.
        curl_close($curlSession);

        echo $out;
    }

    /**
     * Simple login Remote with cURL
     *
     * [ WARNING: CSRF Verification need manual changes. ]
     *
     * @param string $url to login.
     * @param string $uname Username of a Account.
     * @param string $pass Password of a Account.
     */
    public function curlLogin($url, $uname, $pass, $url_to_graph)
    {
        $uname = trim($uname);
        $pass = trim($pass);

        // NOTE: CSRF is not constant, access your csrf dynamically.
        $csrf = 'YOUR_CSRF_TOKEN_GOES_HERE';

        // Place to Store Cookie.
        $cookie = 'cookie.txt';

        // This Post Data contents may change.
        $postData = 'username=' . $uname . '&password=' . $pass . '&_csrf=' . $csrf;

        // Init cURL Session.
        $curlSession = curl_init();

        curl_setopt($curlSession, CURLOPT_HEADER, false);
        curl_setopt($curlSession, CURLOPT_NOBODY, false);
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($curlSession, CURLOPT_COOKIEJAR, $cookie);

        curl_setopt($curlSession, CURLOPT_COOKIE, "cookiename=0");
        curl_setopt($curlSession, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlSession, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, 0);

        curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlSession, CURLOPT_POST, 1);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postData);
        curl_exec($curlSession);

        // After Logged-In going to access the site.
        curl_setopt($curlSession, CURLOPT_URL, $url_to_graph);

        // Start Execution.
        $html = curl_exec($curlSession);

        // Close the cURL session.
        curl_close($curlSession);
        echo $html;
    }


    /**
     * To Download file via cURL.
     *
     * @param string $file path to download.
     * @param string $destination path to store.
     */
    public static function downloadFile($file, $destination)
    {

        // Initialize the cURL session
        $ch = curl_init();

        //Set the URL of the page or file to download.
        curl_setopt($ch, CURLOPT_URL, $file);

        // Create a new file
        $fp = fopen($destination, 'w');

        // Ask cURL to write the contents to a file
        curl_setopt($ch, CURLOPT_FILE, $fp);

        // Execute the cURL session
        curl_exec($ch);

        // Close cURL session and file
        curl_close($ch);

        // Close File Connection.
        fclose($fp);

    }

    /**
     * To Retrieve the list of Site Info.
     *
     * @param string $url to Fetch the Info.
     * @return array mixed Info.
     */
    public function getSiteInfo($url)
    {
        $curlSession = curl_init($url);
        curl_exec($curlSession);
        $info = curl_getinfo($curlSession);
        return $info;
    }


}