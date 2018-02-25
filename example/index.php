<?php
/*!
 * Import Service Class
 * 
 * @version     0.1
 * @author adonaicruz <adonai.cruz@gmail.com>
 * @license This software is licensed under the MIT license: http://opensource.org/licenses/MIT
 * 
 */
class SortingService {
	protected $data,$header;
	var $sort;
	 /**
     * Create instance and load data
     *
     * @param null|json|array   $data   Table data to be sorted
     * @return SS
     * @throws Exception
     *
     */
    function __construct() {
    	
        return $this;
    }
     /**
     * Load table data
     *
     * @param json|array   $data   Table data to be sorted
     * @param bolean       $header It says if the table has headers
     * @return array
     * @throws Exception
     *
     */
    function load($data,$header=true) {
        if(is_string($data)){
        	$data = json_decode($data);
        	if(json_last_error() !== JSON_ERROR_NONE){
        		throw new Exception('Invalid json data.');
        	}
        }
        if($header){
        	$this->header = $data[0];
        	$data = array_slice($data, 1);
        	if(!count($data)){
        		// throw new Exception('Vazio.');
        	}
        }
        $this->data = $data;
        return $this->data;
    }
    
    /**
     * Get table data
     *
     * @return array
     *
     */
    public function getData() {
    	return $this->data;
    }
    /**
     * Get table header
     *
     * @return array
     *
     */
    public function getHeader() {
    	return $this->header;
    }
    /**
     * Get table id
     *
     * @return array
     *
     */
    public function getId() {
    	$vId = array();
    	foreach($this->data as $data):
    		$vId[] = $data[0];
    	endforeach;
    	return $vId;
    }
    /**
     * Method to Sort Array
     *
     * @param  array   $sort   array('column'=>'order') - Column=[0,1,n], order=[asc,desc]
     * @return array
     *
     */
    public function sort($sort) {
    	if($sort === null){
    		throw new Exception('Sort param must be an array.');
    	}
    	if(is_array($sort)){
	    	$this->sort = $sort;
	    	usort($this->data, array($this, 'check'));
    	}
    	return $this->data;
    }
    /**
     * Helper to check the data order. Compare 2 rows [a,b] and check the position
     *
     * @return int
     *
     */
	protected function check($a, $b){
		foreach($this->sort as $column=>$order):
			if ($a[$column] == $b[$column]) {
				$return = 0;
			}else{
				if($order == "desc"){
					return ($a[$column] > $b[$column]) ? -1 : 1;
				}else{
					return ($a[$column] < $b[$column]) ? -1 : 1;
				}
			}
		endforeach;
		return $return;
		
	}
}