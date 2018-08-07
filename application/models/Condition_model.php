<?php
class Condition_model extends CI_Model {

    //default variables
    private $addition_info="";
    private $status = false;
    private $result_info="An Error Occurred, Try Again"; 
    private $fail_result=false;

    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }


	#--------------------------------------------------
    private function reset_defaults()
    {
             $this->addition_info="";
             $this->status = false;
             $this->result_info="An Error Occurred, Try Again"; 
             $this->fail_result=false;
    } 

	public function getCondition($filters=array())
	{
	        //reset variables
			$this->reset_defaults();

	        // set defaults
	        $this->addition_info="";
	        $this->status = false;
			$count=0;
			$result=array();
			$total_records=false;		 
			$get_total_records=false;
			$filteringCondition=' AND ';
			$from=0;$take=20;		 
 
			if(isset($filters['from']))
			{ 	
				$from=$filters['from'];
				unset($filters['from']);
			}

			if(isset($filters['take']))
			{ 	
				$take=$filters['take'];
				unset($filters['take']);
			}

			if(isset($filters['get_total_records']))
			{ 	
				$get_total_records=$filters['get_total_records'];
				unset($filters['get_total_records']);
			}	

			if(isset($filters['filtering_condition']))
			{ 	
				$filteringCondition=$filters['filtering_condition'];
				unset($filters['filtering_condition']);
			}	

		
			$WhereSubQueryArry=array();		

			array_push($WhereSubQueryArry,'(`id` IS NOT NULL) ');			

			$n=1;
			foreach($filters as $key => $value)
			{  
			  
				if(is_array($value))
				{
					$valueFormated=$value;
				}
				else
				{
					$valueFormated=array($value);
				}

		   
           		$miniWhereSubQueryArry=array();			   
			   	foreach($valueFormated as $key2 => $value2)
			   	{
					if($key==='condition_id' || ($key==='condition_id'.$n) )
					{
						array_push($miniWhereSubQueryArry,'`id`=:id'.$n ); 
						$n++;
					}elseif($key==='condition_name' || ($key==='condition_name'.$n) )
					{
						array_push($miniWhereSubQueryArry,'`name`=:name'.$n ); 
						$n++;
					}elseif($key==='invalid' || ($key==='invalid'.$n))
					{
						array_push($WhereSubQueryArry,'1=0' ); 
					}else
					{
						array_push($WhereSubQueryArry,'1=0' ); 
					}		   
			   	}
		   
			   	if(!empty($miniWhereSubQueryArry))
			   	{ 
					$miniWheresubQuery= '('.implode(' OR ',$miniWhereSubQueryArry).')';	
					array_push($WhereSubQueryArry,$miniWheresubQuery ); 
			   	}
			}
				
			$WheresubQuery="";
			$filteringCondition=' '.$filteringCondition.' ';
			if(!empty($WhereSubQueryArry))
			$WheresubQuery='WHERE '.implode($filteringCondition,$WhereSubQueryArry);			 
		 
			$get_total_recordsQuery="";
			if($get_total_records)
			{
			  $get_total_recordsQuery='SQL_CALC_FOUND_ROWS';
			}
		
			 
			$dbquery1 =  $this->db->conn_id->prepare("									
														SELECT ".$get_total_recordsQuery." * 
														FROM `condition` 
														 	".$WheresubQuery."

														GROUP BY `id`
														ORDER BY `rank` DESC											
														LIMIT :from,:take
													");
					
				$n=1;	
				foreach($filters as $key => $value)
				{
					if(is_array($value))
				 	{
						$valueFormated=$value;
				 	}
					 else
				 	{
					   $valueFormated=array($value);
					}

				   	foreach($valueFormated as $key2 => $value2)
				   	{					   
						if($key==='condition_id' || ($key==='condition_id'.$n) ) 
						{$dbquery1->bindValue(":id".$n,$value2); 	$n++;}
						
						if($key==='condition_name' || ($key==='condition_name'.$n) ) 
						{$dbquery1->bindValue(":name".$n,$value2); $n++; }
						
									
				   	}
					
			  	}		 
				 
				$dbquery1->bindValue(':from', (int)$from, PDO::PARAM_INT);
				$dbquery1->bindValue(':take', (int)$take, PDO::PARAM_INT);
				
				if($dbquery1->execute())
			   	{
					$this->status = true;
					$this->result_info="success";
					$sql_result = $dbquery1->fetchAll();
					$count=count($sql_result);
					  
					//echo '<pre>';
					//print_r($sql_result);
					  
					if($get_total_records)
					{
						$dbqueryCount =  $this->db->conn_id->query('SELECT FOUND_ROWS()');
					 	$total_records = (int) $dbqueryCount->fetchColumn();
					}				  
					  
					if(count($sql_result)>0)
					{
					    foreach( $sql_result as $key => $value)
						{
						
							//do some format
							$result[$key]=array(									
												"condition_id"=>$value['id'],
												"condition_name"=>$value['name'],
												"condition_rank"=>$value['rank'],
												);
						}
					}
					  
				}       
				else
				{
					$this->status=false;
					//echo '<pre>';
					//print_r($valueFormated);
					//print_r($dbquery1);
					//print_r($dbquery1->errorInfo());
					$this->result_info="Try again, an error Occurred";
					//$this->addition_info = $dbquery1->errorInfo();
					$this->addition_info = 'error_100_1';
				} 
	        		   
	        	return $info = array("status"=>$this->status,
	                            "data"=> array('records'=> $result,
											   'count'=>$count,
											   'total_records'=>$total_records,
											   'result_info'=>$this->result_info,
											   ),
	                            "addition_info"=>$this->addition_info);	   	       
	}
    
}

?>