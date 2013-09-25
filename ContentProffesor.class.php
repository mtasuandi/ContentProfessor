<?php
/**
 * Content Professor API PHP Wrapper
 * @author 	: M Teguh A Suandi
 * @email 	: teguh.andro@gmail.com
 * @license : http://creativecommons.org/licenses/by/3.0/
 */

class ContentProfessor
{
	private function _isCurlEnabled()
	{
	    return function_exists('curl_version');
	}

	private function _spinRequest($method, $format, $params)
	{
		$endpoint 	= 'http://www.contentprofessor.com/member_free/api/';
		$apiurl 	= $endpoint.$method.'?format='.$format.'&'.http_build_query($params);
		
		if($this->_isCurlEnabled())
		{
			$options = array( 
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_HEADER         => false,
		        CURLOPT_FOLLOWLOCATION => true, 
		        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36',
		        CURLOPT_AUTOREFERER    => true, 
		        CURLOPT_CONNECTTIMEOUT => 120, 
		        CURLOPT_TIMEOUT        => 120, 
		        CURLOPT_MAXREDIRS      => 10,
		        CURLOPT_SSL_VERIFYPEER => false 
		    );

			$ch      = curl_init($apiurl); 
		    curl_setopt_array($ch, $options);
		    $content = curl_exec($ch);
		    curl_close($ch);
		}
		else
		{
			$options = array(
				'http'		=> array(
				'method'	=> "GET",
				'header'	=> "Accept-language: en\r\n" .
			        "Cookie: biztech=indonesia\r\n" . 
			        "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36"
				)
			);
			$context 	= stream_context_create($options);
			$content 	= file_get_contents($apiurl, false, $context);
		}
	    return $content;
	}

	public function test_api($text)
	{
		$method 	= 'test_api';
		$format 	= 'json';
		$params 	= array('text' => $text);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function get_session($login, $password)
	{
		$method 	= 'get_session';
		$format 	= 'json';
		$params 	= array('login' => $login, 'password' => $password);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function clear_session($session)
	{
		$method 	= 'clear_session';
		$format 	= 'json';
		$params 	= array('session' => $session);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function get_limit($session, $limitmethod)
	{
		$method 	= 'get_limit';
		$format 	= 'json';
		$params 	= array('session' => $session, 'method' => $limitmethod);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function include_synonyms($session, $text, $limit)
	{
		$method 	= 'include_synonyms';
		$format 	= 'json';
		$params 	= array(
			'session' 				=> $session, 
			'text' 					=> $text,
			'language'				=> 'en',
			'limit' 				=> $limit,
			'quality'				=> 'ok',
			'removal_on'			=> 1,
			'synonym_set'			=> 'global',
			'min_words_count'		=> 1,
			'max_words_count'		=> 7,
			'excludes_on'			=> 1,
			'exclude_stop_words'	=> 1,
			'protected_terms'		=> ''
			);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function get_synonyms($session, $phrase, $limit)
	{
		$method 	= 'get_synonyms';
		$format 	= 'json';
		$params 	= array(
			'session' 				=> $session, 
			'phrase' 				=> $phrase,
			'language'				=> 'en',
			'limit' 				=> $limit,
			'quality'				=> 'ok',
			'removal_on'			=> 1,
			'synonym_set'			=> 'global'
			);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function get_projects_ids($session)
	{
		$method 	= 'get_projects_ids';
		$format 	= 'json';
		$params 	= array('session' => $session);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}

	public function get_project($session, $projectid)
	{
		$method 	= 'get_project';
		$format 	= 'json';
		$params 	= array('session' => $session, 'id' => $projectid);
		$apicall 	= $this->_spinRequest($method, $format, $params);
		return json_decode($apicall);
	}
}
?>
