<?php

/**
 * @file
 * Integration layer to communicate with the Twitter REST API 1.1.
 *
 * Original work my James Walker (@walkah).
 * Upgraded to 1.1 by Juampy (@juampy72).
 */

/**
 * Exception handling class.
 */
class WB_Rottentomatoes_Exception extends Exception {
  
}

/**
 * Primary Twitter API implementation class
 */
class WB_Rottentomatoes {

  /**
   * Performs a request.
   *
   * @throws WB_Rottentomatoes_Exception
   */
  protected function request($url, $params = array(), $method = 'GET') {
    $data = '';
    if (is_array($params) && count($params) > 0) {
      if ($method == 'GET') {
        $url .= '&' . http_build_query($params, '', '&');
      }
      else {
        $data = http_build_query($params, '', '&');
      }
    }
    $headers = array();
    $headers['Content-type'] = 'application/x-www-form-urlencoded';

    $response = $this->doRequest($url, $headers, $method, $data);
    if (!isset($response->error)) {
      return $response->data;
    }
    else {
      $error = $response->error;
      $data = $this->parse_response($response->data);
      if (isset($data['error'])) {
        $error = $data['error'];
      }
      throw new WB_Rottentomatoes_Exception($error);
    }
  }

  /**
   * Actually performs a request.
   *
   * This method can be easily overriden through inheritance.
   *
   * @param string $url
   *   The url of the endpoint.
   * @param array $headers
   *   Array of headers.
   * @param string $method
   *   The HTTP method to use (normally POST or GET).
   * @param array $data
   *   An array of parameters
   * @return
   *   stdClass response object.
   */
  protected function doRequest($url, $headers, $method, $data) {
    return drupal_http_request($url, array('headers' => $headers, 'method' => $method, 'data' => $data));
  }

  protected function parse_response($response) {
    // http://drupal.org/node/985544 - json_decode large integer issue
    $length = strlen(PHP_INT_MAX);
    $response = preg_replace('/"(id|in_reply_to_status_id)":(\d{' . $length . ',})/', '"\1":"\2"', $response);
    return json_decode($response, TRUE);
  }

  /**
   * Creates an API endpoint URL.
   *
   * @param string $format
   *   The format of the endpoint to be appended at the end of the path.
   * @return
   *   The complete path to the endpoint.
   */
  public function create_url($path) {
    $api_key = variable_get('wb_rotten_tomatoes_api_key');
    if (is_null($api_key)) {
      $error = "Please enter the API's key for rotten tomatoes";
      throw new WB_Rottentomatoes_Exception($error);
    }
    else {
      $url = variable_get('wb_rotten_tomatoes_api_url', WB_ROTTENTOMATOES_API_BASE_URL) . $path . '?apikey=' . $api_key;
    }
    return $url;
  }

  /*   * ***************************************** *//**
   * Utilities
   * ********************************************* */

  /**
   * Calls a Rotten Tomatoes API endpoint.
   */
  public function call($path, $params = array(), $method = 'GET') {
    $url = $this->create_url($path);
    dpm($url);
    try {
      $response = $this->request($url, $params, $method);
    }
    catch (WB_Rottentomatoes_Exception $e) {
      watchdog('WB_Rottentomatoes', '!message', array('!message' => $e->__toString()), WATCHDOG_ERROR);
      return FALSE;
    }

    if (!$response) {
      return FALSE;
    }

    return $this->parse_response($response);
  }

  /**
   * Search Movie By Title
   * To do: fix search keyword to have '+' instead of spaces.
   * @param
   *   string $search_keyword "the title of the movie".
   *   String $page_limit "count of results needed in a page".
   *   Ineteger $page "the page number to get results of".
   */
  public function search_movie_by_title($search_keyword, $page_limit = '30', $page = '1') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['q'] = $search_keyword;
    $params['page_limit'] = $page_limit;
    return $this->call('movies' . $format . '/', $params, 'GET');
  }

  /**
   * Search Movie By Rotten ID
   * @param
   *   String $rotten_id "The id of movie on rottentomatoes."
   */
  public function search_movie_by_rotten_id($rotten_id) {
    $format = variable_get('rottentomatoes_format', '.json');
    $params = '';
    return $this->call('movies/' . $rotten_id . $format, $params, 'GET');
  }

  /**
   * Search Movie By Type
   * Using for IMDB by default
   * @param
   *   String $id "IMDB ID of the movie"
   */
  public function search_movie_by_imdb_id($id, $type = 'imdb') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['type'] = $type;
    $params['id'] = $id;
    return $this->call('movie_alias/' . $format, $params, 'GET');
  }

  /**
   * Find Similar Movies by rotten id.
   * @params
   *   String $limit max value can be 5
   *   String $otten_id "The ID of movie on rottentomatoes".
   */
  public function similar_movies_by_rotten_id($rotten_id, $limit = '5') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['limit'] = $limit;
    return $this->call('movies/' . $rotten_id . '/similar' . $format, $params, 'GET');
  }

  /**
   * Find Upcoming Movies By Country.
   * @params
   *  $country has to be fixed(http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
   * 
   */
  public function upcoming_movies($page_limit = '16', $page = '1', $country = 'US') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['page_limit'] = $page_limit;
    $params['page'] = $page;
    $params['country'] = $country;
    return $this->call('lists/movies/upcoming' . $format, $params, 'GET');
  }

  /**
   * Find Top earning movies.
   * @params
   *   $country has to be fixed(http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
   *   String $limit "Count of results needed at a time."
   */
  public function top_earning_movies($country = 'US', $limit = '10') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['limit'] = $limit;
    $params['country'] = $country;
    return $this->call('lists/movies/box_office' . $format, $params, 'GET');
  }

  /**
   * Retrieves movies currently in theaters
   * @param
   *   $country has to be fixed(http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
   *   String $page_limit "count of results in a page".
   *   String $page "the page number to get results of".
   *   String $country "Country code according to ISO_3166-1_alpha-2"
   */
  public function find_movies_in_theatre($page_limit = '16', $page = '1', $country = 'US') {
    $format = variable_get('rottentomatoes_format', '.json');
    $params['limit'] = $page_limit;
    $params['page'] = $page;
    $params['country'] = $country;
    return $this->call('lists/movies/in_theaters' . $format, $params, 'GET');
  }

  /**
   * Get full cast for a movie.
   * @param
   *   String $rotten_id "the rotten if for the movie to get complete movie cast"
   * 
   */
  public function get_full_movie_cast($rotten_id) {
    $params = "";
    $format = variable_get('rottentomatoes_format', '.json');
    return $this->call('movies/' . $rotten_id . '/cast' . $format, $params, 'GET');
  }

}
