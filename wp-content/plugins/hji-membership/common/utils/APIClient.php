<?php

namespace hji\common\utils;


class APIClient
{
    private $site_url = null;
    private $licenseKey = null;

    protected $cacheTransport = false;

    public $api_base = "https://slipstream.homejunction.com";
    public $api_dev_base = "https://slipstream-test.homejunction.com";
    protected $is_staging = false;

    public $last_error_code = null;
    public $last_error_mess = null;
    public $last_token = null;
    public $last_token_expires = null;
    private $token_header = 'HJI-Slipstream-Token';
    private $productName = 'hji-wordpress';
    private $ch = null;
    private $debug_log;
    private $debug_mode = false;
    private $application_name = null;
    public $api_version = "v1";

    protected $authData = false;

    private $error_messages = array(
        '200' => 'Code: 200. Success.',
        '400' => 'Code: 400. Your request is invalid. Typically this is because you are missing a required parameter.',
        '401' => 'Code: 401. Invalid license key.',
        '403' => 'Code: 403. You attempted to access a restricted resource.',
        '404' => 'Code: 404. These aren\'t the droids you\'re looking for. Move along!',
        '500' => 'Code: 500. Internal server error.',
        '503' => 'Code: 503. Service unavailable.'
    );

    // pagination vars
    public $last_count = 0;
    public $page_size = 0;
    public $total_pages = 0;
    public $current_page = 0;


    function __construct($licenseKey)
    {
        $this->licenseKey = $licenseKey;

        // force dev API base if current site is hosted on a Staging HJ server

        if ($this->isStagingServer())
        {
            $this->api_base = $this->api_dev_base;
            $this->is_staging = true;
        }

        $Membership = \hji\membership\Membership::getInstance();
        $this->customerModel = $Membership->customerModel;
        $this->authData = isset($this->customerModel->license) ? $this->customerModel->license : false;

        // Set token data if it exists
        $this->setToken();

        $this->InitCurl();

        register_shutdown_function(array(&$this, 'debug_data'));
    }


    function setCacheTransport($object)
    {
        $this->cacheTransport = $object;
    }


    /**
     * Check if current server is a staging HJ server
     *
     * @return boolean
     */
    function isStagingServer()
    {
        if (stristr($_SERVER['HTTP_HOST'], 'staging.spatialmatch.com')
            || stristr($_SERVER['HTTP_HOST'], 'hjstaging.com') || $this->is_staging)
        {
            return true;
        }

        return false;
    }


    function InitCurl()
    {
        // initialize cURL for use later
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_HEADER, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    }


    function __destruct()
    {
        // clean cURL up
        if ($this->ch)
            curl_close($this->ch);
    }


    ////////////////////////////////////////////////////////////////////
    //  AUTH FUNCTIONS
    ////////////////////////////////////////////////////////////////////


    function authenticate($force = false)
    {
        if (!$this->licenseKey)
        {
            return;
        }

        if ($force || $this->isTokenExpired()
                || (isset($_GET['hjauth']) && $_GET['hjauth'] == 'force')
        )
        {
            $this->InitCurl();

            require_once('ipAddress.php');

            $params['licenseKey'] = $this->licenseKey;
            $params['product']    = $this->productName;
            $params['ipAddress']  = ipAddress::getIP();
            $params['customer']   = true;
            $params['markets']    = true;

            $result = $this->makeAPIRequest("GET", "/{$this->api_version}/api/authenticate", $params, array(), $auth = true, $force);

            if ($result === false)
            {
                $code    = $this->last_error_code;
                $message = $this->last_error_mess;
                //throw new Exception($message, $code);
            }

            return $result;
        }

    }


    function updateToken($tokenData)
    {
        $this->customerModel->update($tokenData);
        $this->setToken();
    }


    function setToken()
    {
        if (isset($this->authData->token) && isset($this->authData->expires))
        {
            $this->last_token = $this->authData->token;
            $this->last_token_expires = $this->authData->expires;
        }
    }


    function isTokenExpired()
    {
        $timestamp = time();

        if ($this->last_token_expires == null || $timestamp > $this->last_token_expires)
        {
            return true;
        }

        return false;
    }


    function setDebugMode($mode = false)
    {
        $this->debug_mode = $mode;
        
        // enable logging if we're in debug mode
        
        if ($this->debug_mode == true)
        {
            $this->debug_log = fopen("debug.log", 'a');
            curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
            curl_setopt($this->ch, CURLOPT_STDERR, $this->debug_log);
        }
    }


    function setDeveloperMode($enable = false)
    {
        if ($enable)
        {
            $this->api_base   = $this->api_dev_base;
            $this->site_url   = 'staging.spatialmatch.com';
            $this->is_staging = true;

            return true;
        }
        else
        {
            return false;
        }
    }


    function getErrors()
    {
        if ($this->last_error_code && $this->last_error_mess)
        {
            return $this->last_error_code . ' - ' . $this->last_error_mess;
        }
        else
        {
            return false;
        }
    }


    ////////////////////////////////////////////////////////////////////
    //  SEARCH/LISTING FUNCTIONS
    ////////////////////////////////////////////////////////////////////


    /**
     * Returns listings that match search parameters
     *
     * @param $args
     * @return bool
     */
    function searchListings($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/listings/search", $args, array(), $auth = false);

        if (!isset($result['listings']))
        {
            return false;
        }

        return $result;
    }

    /**
     * Returns all listings for the currently selected market
     * 1st step for a full IDX app.
     *
     * @param [type] $args [description]
     * @return bool
     */
    function getListings($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/listings/get", $args, array(), $auth = false);

        if (!isset($result['listings']))
        {
            return false;
        }

        return $result['listings'];
    }


    function searchSales($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/sales/search", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getSales($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/sales/get", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function geocode($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/address/geocode", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function standardize($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/address/standardize", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function updateLog($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/analytics/log", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function createUser($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/create", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getUser($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/get", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function updateUser($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/update", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function searchUsers($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/search", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function deleteUser($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/delete", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function addFavorite($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/favorites/add", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getFavorites($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/favorites/get", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function removeFavorite($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/favorites/remove", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Adds user's saved search
     */
    function addSearch($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/searches/add", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Returns user's saved searches
     */
    function getSearches($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/searches/get", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Deletes user's specified saved search.
     */
    function removeSearch($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/users/searches/remove", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Returns a specified school
     */
    function getSchool($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/schools/get", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Searches schools
     */
    function searchSchools($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/schools/search", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /**
     * Returns automated valuation model (AVM) for a property.
     */
    function getAVM($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/avm", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function searchSessions($args)
    {
        if (!isset($args['product']))
        {
            $args['product'] = $this->productName;
        }

        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/analytics/sessions/search", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getAgents($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/mls/agents/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function searchAgents($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/mls/agents/search", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }

    function getOffices($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/mls/offices/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function searchOffices($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/mls/offices/search", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function lookupAreas($args)
    {
//        $acceptedParams = array(
//            'keyword',
//            'type',
//            'state',
//            'limit',
//            'sortField',
//            'sortOrder'
//        );
//
//        $args = $this->_validateParams($args, $acceptedParams);

        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/lookup", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getNeighborhoods($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/neighborhoods/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function searchNeighborhoods($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/neighborhoods/search", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getStates($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/states/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getPlaces($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/places/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getCounties($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/counties/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getZipCodes($args)
    {
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/areas/zipcodes/get", $args, array(), $auth = false);
        if ($result === false)
        {
            return false;
        }

        return $result;
    }

    /******************* Not Yet Available In SlipStream API ****************/
    /************************************************************************/
    /************************************************************************/


    function updateAgents($args, $data)
    {
        $data   = "data={$data}";
        $result = $this->makeAPIRequest("POST", "/{$this->api_version}/agents", $args, $data, $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function updateOffices($args, $data)
    {
        $data   = "data={$data}";
        $result = $this->makeAPIRequest("POST", "/{$this->api_version}/offices", $args, $data, $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    function getMetaData($args)
    {
        if ($this->cacheTransport && $cache = $this->cacheTransport->getCache('marketsMeta'))
        {
            return $cache;
        }

        $meta = array();

        foreach((array)$args as $market)
        {
            $json = file_get_contents('http://app.spatialmatch.com/maps/metadata/mls/' . $market . '/rules.json');

            $result = json_decode($json, true);

            if (JSON_ERROR_NONE == json_last_error())
            {
                $meta[$market] = $result;
            }
        }

        if (!empty($meta))
        {
            if ($this->cacheTransport)
            {
                $this->cacheTransport->setCache('marketsMeta', $meta, 24);
            }

            return $meta;
        }

        return false;

        // API v2
        $result = $this->makeAPIRequest("GET", "/{$this->api_version}/metadata", $args, array(), $auth = false);

        if ($result === false)
        {
            return false;
        }

        return $result;
    }


    /*
     * Makes the API call to the flexmls API.
     *
     * @param string $method HTTP method to use when making the call.  GET, POST, etc.
     * @param string $uri HTTP request URI to hit with the request
     * @param array $args array of key/value pairs of parameters.  added to request depending on HTTP method
     * @param array $caching array of caching settings. 'enabled' is true/false. 'minutes' defines how long if enabled
     * @return mixed Returns array of parsed JSON results if successful.  Returns false if API call fails
     */

    function makeAPIRequest($method, $uri, $args = array(), $data = array(), $is_auth_request = false, $a_retry = false)
    {
        $success = false;

        // check if token is active

        if (!$is_auth_request && !$this->isTokenExpired())
        {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER,
                array("{$this->token_header}: {$this->last_token}"));
        }


        if (!is_array($args))
        {
            $args = array();
        }

        $http_parameters = http_build_query($args);

        $post_body = "";

        if ($method == "POST" && count($data) > 0)
        {
            // the request is to post some JSON data back to the API (like adding a contact)
            $post_body = $data;
        }

        // start putting the URL parts together

        $full_url = $this->api_base . $uri;

        if (!empty($http_parameters))
        {
            $full_url .= '?' . $http_parameters;
        }

        if ($this->debug_mode)
        {
            echo $full_url . "\n\n";
        }

        $request_headers = "";

        curl_setopt($this->ch, CURLOPT_URL, $full_url);


        if ($method == "POST")
        {
            // put the built parameter key/values as the body of the POST request

            $request_headers .= "Content-Type: application/json\r\n";
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_body);
        }
        elseif ($method == "DELETE")
        {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_body);
            curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
            //curl_setopt($this->ch, CURLOPT_HEADER, 0);
        }
        else
        {
            curl_setopt($this->ch, CURLOPT_POST, 0);
            curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($this->ch);

        $info = curl_getinfo($this->ch);

        // Was connection successful

        if ('200' == $info['http_code'])
        {
            $success               = true;
            $this->last_error_code = false;
            $this->last_error_mess = false;
        }
        else
        {
//            $this->last_error_code = $info['http_code'];
//            $this->last_error_mess = $this->error_messages[$info['http_code']];
        }

        @list($header, $response_body) = explode("\r\n\r\n", $response, 2);

        // for debugging

        $this->debug_data[] = array(
            'webservice'      => $uri,
            'token'           => $this->last_token,
            'info'            => $info,
            'error'           => curl_error($this->ch),
            'post_body'       => $post_body,
            'response_header' => $header,
            'response'        => $response_body,
            'session_used'    => (isset($_SESSION['hji-cookie'])) ? $_SESSION['hji-cookie'] : 'NONE',
        );
        $_SESSION['requests'][] = array(
            'webservice'      => $uri,
            'token'           => $this->last_token,
            'info'            => $info,
            'error'           => curl_error($this->ch),
            'post_body'       => $post_body,
            'response_header' => $header,
            'response'        => $response_body,
            'session_used'    => (isset($_SESSION['hji-cookie'])) ? $_SESSION['hji-cookie'] : 'NONE',
        );

        if ($this->debug_mode == true)
        {
            fwrite($this->debug_log, $response_body . "\n");
        }

        if ($this->debug_mode)
        {
            echo $response_body . "\n\n";
        }

        // Start handling the response

        $response_body = json_decode(utf8_encode($response_body), true);

        if (isset($response_body['success']) && $response_body['success'] === true)
        {
            $success = true;
            $result = $response_body['result'];
        }
        else if($response_body['success'] === false)
        {
            $success               = false;
            $this->last_error_code = $info['http_code'];

            // If API has its own message, use it.
            // if not - use a generic one.

            if (isset($response_body['error']['message']))
            {
                $this->last_error_mess = $response_body['error']['message'];
            }
            else
            {
                $this->last_error_mess =  curl_error($this->ch);
                $this->last_error_code =  curl_errno($this->ch);
            }
        }
        else
        {
            $this->last_error_mess =  curl_error($this->ch);
            $this->last_error_code =  curl_errno($this->ch);
        }


        // if session with cookie is not set,
        // start processing header to set a cookie

        if ($is_auth_request && $success)
        {
            $this->updateToken($response_body['result']);
        }

        // end processing header to set a cookie

        if (isset($result['paging']))
        {
            $this->current_page = isset($result['paging']['number']) ? $result['paging']['number'] : 0;
            $this->page_size    = isset($result['paging']['size']) ? $result['paging']['size'] : 0;
            $this->total_pages  = isset($result['paging']['count']) ? $result['paging']['count'] : 0;
        }

        $this->last_count  = isset($result['total']) ? $result['total'] : 0;

        if ($success == true)
        {
            return $result;
        }
        else if (($a_retry == false) && ($is_auth_request == false) && (($info['http_code'] == '403') || ($info['http_code'] == '404') || ($info['http_code'] == '500')))
        {
            $this->authenticate(true);
            $return = $this->makeAPIRequest($method, $uri, $args, $data, $is_auth_request, $a_retry = true);

            return $return;
        }
        else
        {
            return false;
        }

    }


    /*
     * Take a value and clean it so it can be used as a parameter value in what's sent to the API.
     *
     * @param string $var Regular string of text to be cleaned
     * @return string Cleaned string
     */

    function clean_comma_list($var)
    {

        $return = "";

        if (strpos($var, ',') !== false)
        {
            // $var contains a comma so break it apart into a list...
            $list = explode(",", $var);
            // trim the extra spaces and weird characters from the beginning and end of each item in the list...
            $list = array_map('trim', $list);
            // and put it back together as a comma-separated string to be returned
            $return = implode(",", $list);
        }
        else
        {
            // trim the extra spaces and weird characters from the beginning and end of the string to be returned
            $return = trim($var);
        }

        return $return;
    }


    function exception_handler($exception)
    {
        echo "Uncaught exception: ", $exception->getMessage(), "\n";
    }


    /**
     * Outputs API request info for debugging purposes
     */
    function debug_data()
    {
        if (isset($this->debug_data) && isset($_GET['hjdebug']))
        {

            print '<textarea style="width: 600px; height: 600px">';
            print_r($this->debug_data);
            print '</textarea>';
        }
    }


    function _validateParams($args, $acceptedParams)
    {
        $tmp = $args;

        foreach ($tmp as $k => $v)
        {
            if (!in_array($k, $acceptedParams))
            {
                unset($args[$k]);
            }
        }

        return $args;
    }
}