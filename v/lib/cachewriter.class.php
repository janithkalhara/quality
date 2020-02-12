<?php
 /*
  * Cache writer class 
  */

class CacheWriter{
	/*
	 * @param string $_cacheFile the url of the cache file
	 * @access protected
	 */
	private $_cacheFile;
	
	
	function __construct(){
		/*
		 * setting the url of the cache file
		 */
		$this->_cacheFile=MAIN_CACHE_FILE;
	}
	/*
	 * writing to cache
	 */
	function writeToCache(){
		
	
	}
	/*
	 * appending to cache.
	 * 
	 * @param string $tag the name tag of the cache portion
	 * @param any $c  the caching data 
	 */
	function appendTOCache($tag,$c){
		/*
		 * checking whether file is existing
		 */
		if(file_exists($this->_cacheFile)){
			/*
			 * setting the handler.
			 */
			$handler=fopen($this->_cacheFile, "a");
			/*
			 * indexing data with the tag name 
			 */
			$data=array("tag"=>$tag,'data'=>$c);
			/*
			 * serializing the data and writing it to the file .
			 */
			if(fwrite($handler, serialize($data))){
				
				return true;
				
			}else{
				
				return false;
			}
		}else{
			return false;
		}
		
		
	}
	/*
	 * getting the cached data
	 * 
	 * @param string $tag name of the data set to be re-taken
	 * @return any $data
	 */
	function getCache($tag){
		/*
		 * retrieving data and unseriealizing .
		 */
		$data=unserialize(file_get_contents($this->_cacheFile));
		
		if($data!=null){
			if(isset($data[$tag])){
				/*
				 * returns the data set indexed by the tag
				 */
				return $data[$tag];
			}else{
				return false;
			}
		}return false;
	}
	
}
