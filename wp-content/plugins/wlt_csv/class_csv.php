<?php

class WLT_CSV_import
{
  var $table_name; //where to import to
  var $file_name;  //where to import from
  var $use_csv_header; //use first line of file OR generated columns names
  var $field_separate_char; //character to separate fields
  var $field_enclose_char; //character to enclose fields, which contain separator char into content
  var $field_escape_char;  //char to escape special symbols
  var $error; //error message
  var $arr_csv_columns; //array of columns
  var $table_exists; //flag: does table for import exist
  var $encoding; //encoding table, used to parse the incoming file. Added in 1.5 version
  
  function WLT_CSV_import($file_name="")
  {
    $this->file_name = $file_name;
    $this->arr_csv_columns = array();
    $this->use_csv_header = false;
    $this->field_separate_char = ",";
    $this->field_enclose_char  = "\"";
    $this->field_escape_char   = "\\";
    $this->table_exists = false;
  }
  
  function countrows($table_and_query){ global $wpdb;
  
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_and_query"); 

	if(empty($total)){
	return 0;
	} 
    return $total;  
  
  }  
  function cleanup($table_name){ global $wpdb; 
  	$wpdb->query("DELETE  FROM ".$table_name." WHERE post_title = '' OR post_title IS NULL OR CHAR_LENGTH(post_title) <= 5");   
  
  }
  
  function import_old(){
  
  set_time_limit(0);
  
	// READ THE FILE
	$handle = fopen(mysql_escape_string($this->file_name), 'r');
	// GET TITLES
	$titles = fgetcsv($handle,1000,$delimiter);
	die(print_r($titles));
	  
  
  }
  function import()  { global $wpdb;
  
    if($this->table_name=="")
      $this->table_name = "temp_".date("d_m_Y_H_i_s");
   
    $this->table_exists = false;
    $this->create_import_table();
    
    if(empty($this->arr_csv_columns))
      $this->get_csv_header_fields();
    
    /* change start. Added in 1.5 version */
    if("" != $this->encoding && "default" != $this->encoding){
      $this->set_encoding();
	}
    /* change end */ 
 	
    if($this->table_exists)    {
	
	$wpdb->show_errors     = true;
        $wpdb->suppress_errors = false;
	
      $sql = "LOAD DATA LOCAL INFILE '".@mysql_escape_string($this->file_name).
             "' INTO TABLE `".$this->table_name.
             "` CHARACTER SET ".str_replace("-","",$this->encoding)." FIELDS TERMINATED BY '".@mysql_escape_string($this->field_separate_char).
             "' OPTIONALLY ENCLOSED BY '".@mysql_escape_string($this->field_enclose_char).
             "' ESCAPED BY '".@mysql_escape_string($this->field_escape_char).
             "' ".
             ($this->use_csv_header ? " IGNORE 1 LINES " : "")
             ."(`".implode("`,`", $this->arr_csv_columns)."`)";
    
	  	// RUN AND CHECK FOR ERRORS
	    if ($wpdb->query($sql) === FALSE) {
		  die('error=' . var_dump($wpdb->last_query) . ',' . var_dump($wpdb->error));
		}
	 
	 
    }
	$this->cleanup($this->table_name);
	
	// SAVE AN ENTRY FOR THE FILE NAME
	$csv_files = get_option("wlt_csv_filenames");
	if(!is_array($csv_files)){ $csv_files = array(); }
	$csv_files[$this->table_name] = array("name" => $_FILES['file_source']['name'], "location" => $this->file_name);
	update_option("wlt_csv_filenames", $csv_files);
	
	// RETURN
	return $this->table_name;
  }
  
  //returns array of CSV file columns
  function get_csv_header_fields()
  {
    $this->arr_csv_columns = array();
    $fpointer = fopen($this->file_name, "r");
    if ($fpointer)
    {
      $arr = fgetcsv($fpointer, 10*1024, $this->field_separate_char);
      if(is_array($arr) && !empty($arr))
      {
        if($this->use_csv_header)
        {
          foreach($arr as $val)
            if(trim($val)!="")
              $this->arr_csv_columns[] = $val;
        }
        else
        {
          $i = 1;
          foreach($arr as $val)
            if(trim($val)!="")
              $this->arr_csv_columns[] = "column".$i++;
        }
      }
      unset($arr);
      fclose($fpointer);
    }
    else
      $this->error = "file cannot be opened: ".(""==$this->file_name ? "[empty]" : @mysql_escape_string($this->file_name));
    return $this->arr_csv_columns;
  }
  
  function create_import_table() { global $wpdb;
  
    $sql = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (";
    
    if(empty($this->arr_csv_columns))
      $this->get_csv_header_fields();
    
    if(!empty($this->arr_csv_columns))
    {
      $arr = array();
      for($i=0; $i<sizeof($this->arr_csv_columns); $i++)
          $arr[] = "`".$this->arr_csv_columns[$i]."` TEXT";
      $sql .= implode(",", $arr);
      $sql .= ")";
	  
	   $res = $wpdb->query($sql);

      $this->error = mysql_error();
      $this->table_exists = ""==mysql_error();
    }
 	
  }
  
  /* change start. Added in 1.5 version */
  //returns recordset with all encoding tables names, supported by your database
  function get_encodings()  { global $wpdb;
  
    $rez = array();
    $sql = "SHOW CHARACTER SET";
    $res = $wpdb->query($sql);
    if(mysql_num_rows($res) > 0)
    {
      while ($row = mysql_fetch_assoc ($res))
      {
        $rez[$row["Charset"]] = ("" != $row["Description"] ? $row["Description"] : $row["Charset"]); //some MySQL databases return empty Description field
      }
    }
    return $rez;
  }
  
  //defines the encoding of the server to parse to file
  function set_encoding($encoding="")  { global $wpdb;
    if("" == $encoding)
      $encoding = $this->encoding;
    $sql = "SET SESSION character_set_database = " . $encoding; //'character_set_database' MySQL server variable is [also] to parse file with rigth encoding
	$res = $wpdb->query($sql);
    return mysql_error();
  }
  /* change end */

}

// holds soem methods used for handling errors.
class data_export_error_handling {
	
	// mimics the errors from php, also shows the correct line numbers.
	protected function custom_error($msg){
		if (ini_get('display_errors') && error_reporting() > 0){
			$info		= next(debug_backtrace());
			$prepend	= ini_get('error_prepend_string');
			$append		= ini_get('error_append_string');
			
			if (empty($prepend) === false) echo $prepend;
			
			echo "Warning: {$msg} in {$info['file']} on line {$info['line']}";
			
			if (empty($append) === false) echo $append;
		}
	}
	
}
class data_export_helper extends data_export_error_handling {
	
	// holds the data to be exported.
	private $data				= null;
	
	// holds the value of the constant chosen from the below (defaults to csv).
	private $export_mode		= 4;
	
	// the available modes, because json may not be available.
	private $available_modes	= null;
	
	// these determine the export type.
	const EXPORT_AS_XML			= 0;
	const EXPORT_AS_JSON		= 1;
	const EXPORT_AS_SERIALIZE	= 2;
	const EXPORT_AS_CSV			= 3;
	const EXPORT_AS_EXCEL		= 4;
	
	// loads the data.
	public function __construct($data){
		if (is_object($data)){
			$this->data = get_object_vars($data);
		}else if (is_array($data)){
			$this->data = $data;
		}else{
			$this->custom_error('data_export_helper::__construct(): The supplied argument must be either an object or an array.');
		}
		
		$this->available_modes = array();
			
		$this->available_modes[] = self::EXPORT_AS_XML;
		
		if (is_callable('json_encode')){
			$this->available_modes[] = self::EXPORT_AS_JSON;
		}
		
		$this->available_modes[] = self::EXPORT_AS_SERIALIZE;
		$this->available_modes[] = self::EXPORT_AS_CSV;
		$this->available_modes[] = self::EXPORT_AS_EXCEL;
	}
	
	// gets an array of available export modes.
	public function get_available_export_modes(&$result){
		$result = $this->available_modes;
		
		return true;
	}
	
	// sets the export mode to one of the given constants.
	public function set_mode($mode){
		if (in_array($mode, $this->available_modes) === false){
			$this->custom_error('data_export_helper::set_mode(): The selected export mode is not available.');
			return false;
		}
		
		$this->export_mode = $mode;
		return true;
	}
	
	// exports the data as xml.
	private function export_as_xml(){
		$xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		$xml .= "<document>\n";
		
		foreach ($this->data as $data){
			if (is_array($data)){
				$xml .= "\t<entry>\n";
				
				foreach ($data as $key => $val){
					while (is_array($val)){
						$val = $val[0];
					}
					
					$key = htmlspecialchars($key);
					$val = htmlspecialchars($val);
					
					$xml .= "\t\t<{$key}>{$val}</{$key}>\n";
				}
				
				$xml .= "\t</entry>\n";
			}else{
				$data = htmlspecialchars($data);
				$xml .= "\t<entry>{$data}</entry>\n";
			}
		}
		
		$xml .= '</document>';
		
		return $xml;
	}
	
	// exports the data as a json encoded string.
	private function export_as_json(){
		return json_encode($this->data);
	}
	
	// exports the data as serialized string.
	private function export_as_serialize(){
		return serialize($this->data);
	}
	
	// exports the data as csv.
	private function export_as_csv(){
		$headings = array_keys($this->data[0]);
		
		foreach ($headings as &$heading){
			$heading = str_replace('"', '""', trim($heading));
		}
		
		$csv = '"' . implode('","', $headings) . "\"\r\n";
		
		foreach ($this->data as $data){
			$data = (is_array($data)) ? array_values($data) : array($data);
			
			foreach ($data as &$entry){
				while (is_array($entry)){
					$entry = $entry[0];
				}
				
				if (is_numeric($entry) === false){
					$entry = '"' . str_replace('"', '""', trim($entry)) . '"';
				}
			}
			
			$csv .= implode(',', $data) . "\r\n";
		}
		
		return $csv;
	}
	
	// exports the data as excel xls format.
	private function export_as_excel(){
		$xls = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		
		$xls_data = array(array_keys($this->data[0]));
		
		foreach ($this->data as $data){
			$xls_data[] = (is_array($data)) ? array_values($data) : array($data);
		}
 
		foreach ($xls_data as $row => $data){
			foreach ($data as $col => $entry){
				if (is_numeric($entry)){
					$xls .= pack("sssss", 0x203, 14, $row, $col, 0x0);
					$xls .= pack("d", $entry);
				}else{
					$len = strlen($entry);
					
					$xls .= pack("ssssss", 0x204, 8 + $len, $row, $col, 0x0, $len);
					$xls .= $entry;
				}
			}
		}
		
		$xls .= pack("ss", 0x0A, 0x00);
		
		return $xls;
	}
	
	// calls the appropriate method to export the data.
	public function export(&$result){
		if (empty($this->data)){
			$this->custom_error('data_export_helper::export(): Data array cannot be empty.');
			return false;
		}
		
		if ($this->export_mode === self::EXPORT_AS_XML){
			$result = $this->export_as_xml();
		}else if ($this->export_mode === self::EXPORT_AS_JSON){
			$result = $this->export_as_json();
		}else if ($this->export_mode === self::EXPORT_AS_SERIALIZE){
			$result = $this->export_as_serialize();
		}else if ($this->export_mode === self::EXPORT_AS_CSV){
			$result = $this->export_as_csv();
		}else if ($this->export_mode === self::EXPORT_AS_EXCEL){
			$result = $this->export_as_excel();
		}else{
			$result = null;
			return false;
		}
		
		return true;
	}
}

?>