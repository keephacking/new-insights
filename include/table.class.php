<?php 
require_once 'database.class.php';
class table extends database
{
	protected $table_id = null;
	protected $table= null;
    
	public $num_rows=NULL;
	public $result=NULL;
	public $affected_rows=NULL;

	function __construct($table=null,$table_id=null) {
		$this->table=$table;
		$this->table_id=$table_id;
	}
	function _prepare($query){
		$this->result=parent::$link->prepare($query);
		return $this->result;
	}
	function set($table=null,$table_id=null){
		$this->table_id = $table_id;
		$this->table    = $table;
	}
	function get(){
		echo $this->table;
		echo "<br>".$this->table_id;
	}
	public function sql_query($query)
	{
		$this->result         = parent::$link->query($query);
		@$this->num_rows      = $this->result->num_rows;
		@$this->affected_rows = parent::$link->affected_rows;
		if($this->result)
			return true;
			else return false;
	}
	function load_vars()
	{
        if($this->select()){
        	if($this->num_rows>0){
				$row = $this->load_datas();
		        if(is_array($row)){
					foreach($row as $key=>$value)
					{
						$this->$key = $value;
					}
					return true;
		        }else {echo "<h1>Error in loading datas</h1>";die();}
	        }else return false;
            }else {echo "<h1>Error in select query</h1>";}        
	}
	public function load_datas()
	{
		$data=false;
		if($this->num_rows > 0 && $this->result)
		{
			$data = $this->result->fetch_array(MYSQL_ASSOC);
		}

		return $data;
	}

	/*function store($data){
		$sql = $this->build_query('store',$data);
		$this->sql_query($sql);
	}*/
	function insert($data){
		$sql     = null;
		$keys    = "";
		$values  = "";
		$sql    .= "Insert into {$this->table}";
			
		foreach ($data as $key => $value){
		
			$keys .="{$key},";
			$values .= "'{$value}',";
		}
		$sql .= "(".substr($keys,0,-1).")Values(" . substr($values,0,-1).")";
		$this->sql_query($sql);
	}
	function update($data){
		$sql     = null;
		$sql .= "Update {$this->table} set ";
		foreach ($data as $key=>$value){
			$sql .="{$key} = '{$value}',";
		}
		$sql = substr($sql,0,-1)."where id = {$this->table_id}";
		$this->sql_query($sql);
		if($this->result) return TRUE;
		else return false;
	}
    function select(){
    	
    	$sql = "select * from {$this->table} where id ='{$this->table_id}'";
    	$result=$this->sql_query($sql);
    	return $result;
    }
    function delete(){
    	$sql = "DELETE FROM {$this->table} WHERE id = '{$this->table_id}'";
    	$this->sql_query($sql);
    }
 
	/*protected function build_query($task,$data=null){
		$sql=null;
		if($task == 'store')
		{
			if($this->table_id = ' '){
				$keys    = "";
				$values  = "";
				$sql .= "Insert into {$this->table}";
					
				foreach ($data as $key => $value){
						
					$keys .="{$key},";
					$values .= "'{$value}',";
				}

				$sql .= "(".substr($keys,0,-1).")Values(" . substr($values,0,-1).")";
			}
			else {
				$sql .= "Update {$this->table} set ";
				foreach ($data as $key=>$value){
					$sql .="{$key} = '{$value}',";
				}
				$sql = substr($sql,0,-1)."where id = {$this->table_id}";

			}

		}
		elseif ($task == 'load')
		{
			$sql = "select * from {$this->table} where id ='{$this->table_id}'";
		}

		elseif ($task == 'delete')
		{
			$sql = "DELETE FROM {$this->table} WHERE id = '{$this->table_id}'";
		}

		return $sql;

	}*/
}




?>