<?php
class Yql extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->library('yql_lib');
	}

	
	function index()
	{
	    echo '<ul>';
	    echo '<li><a href="search_twitter/@kulor">Search Twitter for "@kulor"</a></li>';
	    echo '<li><a href="search_flickr/kulor">Search Flickr for "kulor"</a></li>';
	    echo '<li><a href="search_yahoo/kulor">Search Yahoo for "kulor"</a></li>';
	    echo '<li><a href="search_wikipedia/open">Search Wikipedia for "open"</a></li>';
	    echo '</ul>';
        
	}

	
	function geo_test()
	{
	    echo '<pre>';
	    print_r($this->yql_lib->test_query());
	}

	
	function search_twitter($term = '@kulor')
	{
	    echo '<pre>';
	    $yql_query = 'select * from json where url="http://search.twitter.com/search.json?q=' . $term . '" and itemPath = "json.results"';
	    print_r($this->yql_lib->query($yql_query));
	}

	
	function search_flickr($term = 'kulor')
	{
	    echo '<pre>';
	    $yql_query = 'select * from flickr.photos.search where text="' . $term . '" limit 10';
	    print_r($this->yql_lib->query($yql_query));	    
	}

	
	function search_yahoo($term = 'kulor')
	{
	    echo '<pre>';
	    $yql_query = 'select title,abstract from search.web where query="' . $term . '"';
	    print_r($this->yql_lib->query($yql_query));
	}

	
	function search_wikipedia($term = 'open')
	{
	    echo '<pre>';
	    $yql_query = 'select * from xml where url="http://en.wikipedia.org/w/api.php?action=opensearch&search=' . $term . '&format=xml" and itemPath = "SearchSuggestion.Section.Item"';
	    print_r($this->yql_lib->query($yql_query));
	}
	
	function finance_topstories(){
	    $yql_query = 'select * from html where url="http://finance.yahoo.com/q?s=yhoo" and xpath=\'//div[@id="yfi_headlines"]/div[2]/ul/li/a\'';
	    $results['headlines']  = $this->yql_lib->query($yql_query);
	    $this->load->view('finance_stories', $results);
	    
	}
}