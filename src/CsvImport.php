<?php

/*!
 * CSV Import Service Class
 * 
 * @version     0.1
 * @author adonaicruz <adonai.cruz@gmail.com>
 * @license This software is licensed under the MIT license: http://opensource.org/licenses/MIT
 * 
 */
class CsvImport {
	protected $data,$header;
	var $path;
	var $handle;
	 /**
     * Create instance and load data
     *
     * @param null|json|array   $data   Table data to be sorted
     * @return SS
     * @throws Exception
     *
     */
    function __construct($file) {
    	$this->load($file);
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
    function load($file) {
        if(is_string($file)):
            $this->path = realpath($file);
        elseif (is_array($file) && $file['tmp_name']) :
            $this->path = realpath($file['tmp_name']);
        endif;
        // if ($header) {
        //     $this->header = $data[0];
        // 	$data = array_slice($data, 1);
        // 	if(!count($data)){
        //         throw new Exception('Vazio.');
        // 	}
        // }
        $this->handle = fopen ($this->path, 'r' );
        if (($this->handle) === FALSE) :
            throw new Exception('Arquivo Inválido.');
        endif;
        return $this;
    }
    
    /**
     * get row data
     */
    public function getRow() {
        return fgetcsv( $this->handle, 0, ';' );
    }

    /**
     * set Outuput data
     */
    public function setOutput($file = 'php://output') {
        $this->fileOutput = fopen($file, 'w');
    	return $this->fileOutput;
    }
    
    public function output($row) {
        fputcsv($this->fileOutput, $row, ';');
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
    
}