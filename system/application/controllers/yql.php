<?php
class Yql extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->library('yql_lib');
	}

	
	function index()
	{
		$data['examples'][] = array('href' => '/yql_php/yql/geo_lookup/LHR', 'title' => 'Geo lookup for "LHR"');
		$data['examples'][] = array('href' => '/yql_php/yql/search_flickr/kulor', 'title' => 'Search Flickr for "kulor"');
		$data['examples'][] = array('href' => '/yql_php/yql/search_yahoo/kulor', 'title' => 'Search Yahoo for "kulor"');
		$data['examples'][] = array('href' => '/yql_php/yql/search_wikipedia/open', 'title' => 'Search Wikipedia for "open"');
		$data['examples'][] = array('href' => '/yql_php/yql/search_twitter/kulor', 'title' => 'Search Twitter for "kulor"');
		$data['examples'][] = array('href' => '/yql_php/yql/finance_topstories', 'title' => 'Finance Top stories');
        $this->load->view('index', $data);
	}

	
	function geo_lookup($location = 'LHR')
	{
		$yql_query = "select name,centroid,woeid from geo.places where text=\"" . $location . "\"";
		$results['query'] = $yql_query;
	    $results['search'] = $this->yql_lib->query($yql_query);
		$results['page_title'] = 'Geo Lookup';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
		$this->load->view('yql_geo_lookup', $results);
		$this->load->view('footer');
	}

	
	function search_twitter($term = 'kulor')
	{
	    $yql_query = 'select * from json where url="http://search.twitter.com/search.json?q=' . $term . '" and itemPath = "json.results"';
		$results['query'] = $yql_query;
	    $results['search'] = $this->yql_lib->query($yql_query);
		$results['page_title'] = 'Twitter search results';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
		$this->load->view('yql_search_twitter', $results);
		$this->load->view('footer');
	}

	
	function search_flickr($term = 'kulor')
	{
	    $yql_query = 'select * from flickr.photos.search where text="' . $term . '" limit 10';
		$results['query'] = $yql_query;
	    $results['search'] = $this->yql_lib->query($yql_query)->photo;
		$results['page_title'] = 'Flickr search results';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
		$this->load->view('yql_search_flickr', $results);
		$this->load->view('footer');
	}

	
	function search_yahoo($term = 'kulor')
	{
	    $yql_query = 'select * from search.web where query="' . $term . '"';
		$results['query'] = $yql_query;
	    $results['search'] = $this->yql_lib->query($yql_query)->result;
		$results['page_title'] = 'Yahoo search results';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
		$this->load->view('yql_search_yahoo', $results);
		$this->load->view('footer');
	}

	
	function search_wikipedia($term = 'open')
	{
	    $yql_query = 'select * from xml where url="http://en.wikipedia.org/w/api.php?action=opensearch&search=' . $term . '&format=xml" and itemPath = "SearchSuggestion.Section.Item"';
		$results['query'] = $yql_query;
	    $results['search'] = $this->yql_lib->query($yql_query)->Item;
		$results['page_title'] = 'Wikipedia search results';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
		$this->load->view('yql_search_wikipedia', $results);
		$this->load->view('footer');
	}
	
	function finance_topstories(){
	    $yql_query = 'select * from html where url="http://finance.yahoo.com/q?s=yhoo" and xpath=\'//div[@id="yfi_headlines"]/div[2]/ul/li/a\'';
		$results['query'] = $yql_query;
	    $results['search']  = $this->yql_lib->query($yql_query)->a;
		$results['page_title'] = 'Finance Topstories for "YHOO"';
		
		$this->load->view('header', $results);
		$this->load->view('query_output', $results);
	    $this->load->view('yql_finance_topstories', $results);
		$this->load->view('footer');
	}
}