<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	//set defults
	private $ownerCheck = 0;
	private $userInfo = array();
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();

        //$this->load->library('Mobile_redirect');
        
        //$this->mobile_redirect->mobile_redirect();
        
        $this->load->library('user_account');
        
        $this->load->model('user_info_model');

        $this->load->model('item_model');
        
		//refuse unlogged in users
		$this->user_account->header_control(array('redirect_unlogged_url' =>base_url().'sign_in' , ));		
    }	
 

	public function index()
	{


		$pass_data = array(	'on_display'=>1
   						   );

		$model_data=$this->item_model->getItem($pass_data);
		   		//do some formating to the results
   		foreach ($model_data['data']['records'] as $key => $value) {

			$model_data['data']['records'][$key]['price']='MK'.$value['price'];
			$model_data['data']['records'][$key]['date']=date( "j M Y", strtotime($value['date']));

			#limit length 				
			if(strlen($value['item_name'])>23)
				$model_data['data']['records'][$key]['item_name']=$this->general_functions->wordTrimmer($value['item_name'],23,'&hellip;');

			if(strlen($value['item_description'])>108)
				$model_data['data']['records'][$key]['item_description']=$this->general_functions->wordTrimmer($value['item_description'],108,'&hellip;');

   		}

		$data['page_data']= array();	
		$data['page_data']['item']= $model_data;	
		
		//echo "<pre>";
		//print_r($data);
		$this->load->view('admin/browse_content',$data);

	}


	public function add_post()
	{


		/*########################################
          0. load classes
        #######################################*/		    

          $this->load->model('Type_model');
          $this->load->model('Category_model');
          $this->load->model('Location_model');
        
		/*########################################
          1. Get Data from Database using Models
        #######################################*/		    
   		
		$type =$this->Type_model->getType(); 
		$category =$this->Category_model->getCategory(); 
		$location =$this->Location_model->getLocation(); 


		$data['page_data']= array();
		$data['page_data']['type']= $type;	
		$data['page_data']['category']= $category;	
		$data['page_data']['location']= $location;	


		//echo "<pre>";
		//print_r($location);
		//return;
		$this->load->view('admin/add_post',$data);

	}


	public function draft()
	{


		$pass_data = array(	'on_display'=>0
   						   );

		$model_data=$this->item_model->getItem($pass_data);
		   		//do some formating to the results
   		foreach ($model_data['data']['records'] as $key => $value) {

			$model_data['data']['records'][$key]['price']='MK'.$value['price'];
			$model_data['data']['records'][$key]['date']=date( "j M Y", strtotime($value['date']));

			#limit length 				
			if(strlen($value['item_name'])>23)
				$model_data['data']['records'][$key]['item_name']=$this->general_functions->wordTrimmer($value['item_name'],23,'&hellip;');

			if(strlen($value['item_description'])>108)
				$model_data['data']['records'][$key]['item_description']=$this->general_functions->wordTrimmer($value['item_description'],108,'&hellip;');

   		}

		$data['page_data']= array();	
		$data['page_data']['item']= $model_data;	
		$this->load->view('admin/browse_content',$data);

	}

	public function add_property()
	{


		/*########################################
          0. load classes
        #######################################*/		    

          $this->load->model('CarModel_model');
          $this->load->model('Transmission_model');
          $this->load->model('Body_type_model');
          $this->load->model('Fuel_type_model');
          $this->load->model('Color_model');
          $this->load->model('Condition_model');
          $this->load->model('Location_model');
        
		/*########################################
          1. Get Data from Database using Models
        #######################################*/		    
   		
		$model =$this->CarModel_model->getCarModel(); 
		//$category =$this->Category_model->getCategory(); 
		$location =$this->Location_model->getLocation(); 
		$transmission =$this->Transmission_model->getTransmission(); 
		$body_type =$this->Body_type_model->getBody_type(); 
		$fuel_type =$this->Fuel_type_model->getFuel_type(); 
		$color =$this->Color_model->getColor(); 
		$condition =$this->Condition_model->getCondition(); 


		$data['page_data']= array();
		$data['page_data']['model']= $model;	
		$data['page_data']['transmission']= $transmission;	
		$data['page_data']['body_type']= $body_type;	
		$data['page_data']['fuel_type']= $fuel_type;	
		$data['page_data']['color']= $color;	
		$data['page_data']['condition']= $condition;	
		//$data['page_data']['category']= $category;	
		$data['page_data']['location']= $location;	


		//echo "<pre>";
		//print_r($location);
		//return;
		$this->load->view('admin/add_property',$data);

	}

	public function add_property_form($pdata=array())
	{



		//default valiables	
		$status=false;
		$fail_result=false;
		$addition_info='';
		$result_info="";
		$item_id = '';
		$result_array=array();
		$href='';
		
		//echo "string";
		//include libraries
		$this->load->library('form_validation');

		//validation configurations
		$validationRules['rule1']=array(
						        array(
						                'field' => 'name',
						                'label' => 'Name',
						                'rules' => 'required|max_length[30]',
						                'errors' => array(
								                        'required' => 'Name is required',
								                        'max_length' => 'Must not exceed 30 Characters',
						                				),	                
						        	),
						        array(
						                'field' => 'price',
						                'label' => 'Price',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'Price is required',
								                        'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'mileage',
						                'label' => 'mileage',
						                'rules' => 'numeric',
						                'errors' => array(
						                				'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'year_of_make',
						                'label' => 'year_of_make',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'Year of make is required',
								                        'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'door_count',
						                'label' => 'door_count',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'Number of doors is required',
								                        'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'engine_size',
						                'label' => 'engine_size',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'Engine Size is required',
								                        'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'description',
						                'label' => 'Description',
						                'rules' => 'max_length[2000]',
						                'errors' => array(
								                        'max_length' => 'Description must not be less than 2000 characters',
						                				),	 		                
						        	),
						        array(
						                'field' => 'summary',
						                'label' => 'Summary',
						                'rules' => 'max_length[500]',
						                'errors' => array(
								                        'max_length' => 'Summary must not be less than 500 characters',
						                				),	 		                
						        	),
						        array(
						                'field' => 'model',
						                'label' => 'model',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'fuel_type',
						                'label' => 'fuel_type',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'transmission',
						                'label' => 'transmission',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'body_type',
						                'label' => 'body_type',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'exColor',
						                'label' => 'exColor',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'inColor',
						                'label' => 'inColor',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'location',
						                'label' => 'Location',
						                'rules' => 'required',
						                'errors' => array(
						                				'required' => 'system_error',
						                				),	 		                
						        	),
						        array(
						                'field' => 'on_display',
						                'label' => 'on_display',
						                'rules' => 'numeric',
							            'errors' => array(
									                        'numeric' => 'system_error',
									                        
									                    ),
								    ),
						        array(
						                'field' => 'input1',
						                'label' => 'Image',
						                'rules' => 'exact_length[20]|alpha_numeric|required',
							            'errors' => array(
									                        'exact_length' => 'system_error',
									                        'alpha_numeric' => 'system_error', 
									                        'required' => 'Provide a feature image',		                
						        	),
								),
						    );


		for ($i=2; $i <13 ; $i++) { 
 			array_push($validationRules['rule1'],array(
							                'field' => 'input'.$i,
							                'label' => 'Photo',
							                'rules' => 'exact_length[20]|alpha_numeric',
							                'errors' => array(
									                        'exact_length' => 'system_error',
									                        'alpha_numeric' => 'system_error',
							            ),		                
							        	));
 		}	        			
		
   		

 		//validate
        $this->form_validation->set_rules($validationRules['rule1']);
  
	    if (!$fail_result && $this->form_validation->run() == FALSE)
        {
        	$fail_result=true;
   			$addition_info='validation error';
   			$result_info="Sorry An error Occurred";
   			// control the error messsages
   			$result_array= $this->form_validation->error_array(); 
			
   			//correct common errors first
			$commonErrors=false;
			foreach ($result_array as $key => $value) {
				if('system_error'!= $value)
					$commonErrors=true;
			}

			/*
			the logic is treat common errors first then for systems error prompt user to refresh the page 
			 */
			// control the error messsages
   			$errors = $this->form_validation->error_array();
   			// define them
   			if(!isset($errors['body_type']))$errors['body_type']='';
   			if(!isset($errors['fuel_type']))$errors['fuel_type']='';
   			if(!isset($errors['model']))$errors['model']='';
   			if(!isset($errors['inColor']))$errors['inColor']='';
   			if(!isset($errors['inColor']))$errors['inColor']='';
   			if(!isset($errors['exColor']))$errors['exColor']='';
   			if(!isset($errors['door_count']))$errors['door_count']='';
   			if(!isset($errors['condition']))$errors['condition']='';
   			if(!isset($errors['location']))$errors['location']='';
   			if(!isset($errors['transmission']))$errors['transmission']='';

   			if(($errors['body_type']=='system_error' || 
   				 $errors['fuel_type']=='system_error' || 
   				 $errors['model']=='system_error' || 
   				 $errors['condition']=='system_error' || 
   				 $errors['inColor']=='system_error' || 
   				 $errors['exColor']=='system_error' || 
   				 $errors['door_count']=='system_error' || 
   				 $errors['transmission']=='system_error') && !$commonErrors)
   			{
   				$addition_info='system error';	
   			}
   			
			for ($i=1; $i <5 ; $i++) { 
       			
       			if(isset($error['input'.$i]))
       			if($errors['input'.$i]=='system_error' && !$commonErrors)
       			{
       				$addition_info='system error';	
       			}					
	 		}     			
        }	  

	   // flesh load	
       if(!$fail_result)
       {

       		$pass_data = array(	'user_id' => $_SESSION['user_id'],
       							'name' => $this->input->post('name',true),
       							'price' => $this->input->post('price',true),
       							'location_id' => $this->input->post('location',true),
       							'front_pic' => $this->input->post('input1',true),
       							'on_display' => $this->input->post('on_display',true),
       							'description' => $this->input->post('description',true),
       							'model_id' => $this->input->post('model',true),
       							'transmission_id' => $this->input->post('transmission',true),
       							'body_type_id' => $this->input->post('body_type',true),
       							'fuel_type_id' => $this->input->post('fuel_type',true),
       							'exterior_color_id' => $this->input->post('exColor',true),
       							'interior_color_id' => $this->input->post('inColor',true),
       							'mileage' => $this->input->post('mileage',true),
       							'engine_size' => $this->input->post('engine_size',true),
       							'door_count' => $this->input->post('door_count',true),
       							'door_count' => $this->input->post('door_count',true),
       							'year_of_make' => $this->input->post('year_of_make',true),
       						);
       		$pass_data['addPic']=array();
       		for ($i=1; $i <13 ; $i++) { 
       		 	if($this->input->post('input'.$i,true)!='')
       			array_push($pass_data['addPic'],$this->input->post('input'.$i));
       		}

		   	$this->load->model('Item_model');
       		$model_data=$this->Item_model->addItem($pass_data);

       		$href=base_url();
       		$addition_info=$model_data['addition_info'];
       		$status=$model_data['status'];
       		$result_info=$model_data['data']['result_info'];
       		$item_id=$model_data['data']['item_id'];
       }       

       //check if is ajax call
       if($this->input->is_ajax_request())
       {
	       	$data['info']['status']=$status;
	       	$data['info']['data']=array(
	       								 'href'=>$href,
	       								 'addition_info'=>$addition_info,	
	       								 'result_array'=>$result_array,	
	       								 'result_info'=>$result_info,
	       								 'item_id'=>$item_id	
	       								);
	       	$data['print_as']='json';         
	        $this->load->view('ajaxCall/ajaxCall',$data);
       }
       elseif(1==0)
       {}
	}

	public function edit_property()
	{

		/*########################################
          0. load classes
        #######################################*/		    

        $this->load->model('item_model');
		$this->load->library('general_functions');
		$this->load->model('Type_model');
        $this->load->model('Category_model');
        $this->load->model('Location_model');
        
		
		/*########################################
          1. Get Data from Database using Models
        #######################################*/		   
        $type =$this->Type_model->getType(); 
		$category =$this->Category_model->getCategory(); 
		$location =$this->Location_model->getLocation(); 

   		$pass_data = array(	'item_id' => $this->uri->segment(2)
   						   );

   		$model_data=$this->item_model->getItem($pass_data);

   		$href=base_url();
   		$addition_info=$model_data['addition_info'];
   		$status=$model_data['status'];

   		//do some formating to the results
   		foreach ($model_data['data']['records'] as $key => $value) {

			$model_data['data']['records'][$key]['price']='MK'.$value['price'];
			$model_data['data']['records'][$key]['date']=date( "j M Y", strtotime($value['date']));
			foreach ($value['item_pic'] as $key2 => $value2) {
				# calculate image dimensions
				$width=600;$height =600;
				if (file_exists($value2['path'].'.jpg')) 
					list($width, $height, $type, $attr) = getimagesize($value2['path'].'.jpg');	
				else
					$model_data['data']['records'][$key]['item_pic'][$key2]['path'] = 'media/default/images/no_image';
					$model_data['data']['records'][$key]['item_pic'][$key2]['dimension'] = $width.'x'.$height;
			}
			#limit length 				
			if(strlen($value['item_name'])>23)
				$model_data['data']['records'][$key]['item_name']=$this->general_functions->wordTrimmer($value['item_name'],23,'&hellip;');

   		}

		/*########################################
          2. Send data to view
        #######################################*/		    

        $data['page_data']= array();	
        $data['page_data']['type']= $type;	
		$data['page_data']['category']= $category;	
		$data['page_data']['location']= $location;	
		$data['page_data']['item']= $model_data;

        //echo "<pre>";
		//print_r($model_data);
		//return;
         //check if is ajax call
         // We added an ajax call because the item images got called by jquery after the page is already loaded
       if($this->input->is_ajax_request())
       {
        $data['info']=array();         
        $data['info']['item']= $model_data;        
        $data['print_as']='json';         
        $this->load->view('ajaxCall/ajaxCall',$data);  
       }
       else
       { 
		$this->load->view('admin/edit_property',$data);
       }
	}

	public function edit_property_form($pdata=array())
	{



		//default valiables	
		$status=false;
		$fail_result=false;
		$addition_info='';
		$result_info="";
		$item_id = '';
		$result_array=array();
		$href='';
		
		//echo "string";
		//include libraries
		$this->load->library('form_validation');

		//validation configurations
		$validationRules['rule1']=array(
						        array(
						                'field' => 'name',
						                'label' => 'Name',
						                'rules' => 'max_length[30]',
						                'errors' => array(
								                        'required' => 'Name is required',
								                        'max_length' => 'Must not exceed 30 Characters',
						                				),	                
						        	),
						        array(
						                'field' => 'price',
						                'label' => 'Price',
						                'rules' => 'numeric',
						                'errors' => array(
						                				'required' => 'Price is required',
								                        'numeric' => 'Provide number only',
						                				),
						            ),
						        array(
						                'field' => 'description',
						                'label' => 'Description',
						                'rules' => 'max_length[2000]',
						                'errors' => array(
								                        'max_length' => 'Description must not be less than 2000 characters',
						                				),	 		                
						        	),
						        array(
						                'field' => 'summary',
						                'label' => 'Summary',
						                'rules' => 'max_length[500]',
						                'errors' => array(
								                        'max_length' => 'Summary must not be less than 500 characters',
						                				),	 		                
						        	),
						        array(
						                'field' => 'category',
						                'label' => 'Category',
						                'rules' => '',
						                'errors' => array(
						                			
						                				),	 		                
						        	),
						        array(
						                'field' => 'location',
						                'label' => 'Location',
						                'rules' => '',
						                'errors' => array(
						                			
						                				),	 		                
						        	),
						        array(
						                'field' => 'type',
						                'label' => 'Type',
						                'rules' => '',
						                'errors' => array(
						                			
						                				),	 		                
						        	),
						        array(
						                'field' => 'input1',
						                'label' => 'Image',
						                'rules' => 'exact_length[20]|alpha_numeric',
							            'errors' => array(
									                        'exact_length' => 'system_error',
									                        'alpha_numeric' => 'system_error', 
									                        
									                    ),
								    ),
						        array(
						                'field' => 'on_display',
						                'label' => 'on_display',
						                'rules' => 'numeric',
							            'errors' => array(
									                        'numeric' => 'system_error',
									                        
									                    ),
								    ),
						        array(
						                'field' => 'i_ref',
						                'label' => 'i_ref',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'system_error',
						                				'numeric' => '1system_error',
						                				),	 		                
						        	),
						    );


		for ($i=2; $i <13 ; $i++) { 
 			array_push($validationRules['rule1'],array(
							                'field' => 'input'.$i,
							                'label' => 'Photo',
							                'rules' => 'exact_length[20]|alpha_numeric',
							                'errors' => array(
									                        'exact_length' => 'system_error',
									                        'alpha_numeric' => 'system_error',
							            ),		                
							        	));
 		}	        					
   	



 		//validate
        $this->form_validation->set_rules($validationRules['rule1']);
  
	    if (!$fail_result && $this->form_validation->run() == FALSE)
        {
        	$fail_result=true;
   			$addition_info='validation error';
   			$result_info="Sorry An error Occurred";
   			// control the error messsages
   			$result_array= $this->form_validation->error_array(); 
			
   			//correct common errors first
			$commonErrors=false;
			foreach ($result_array as $key => $value) {
				if('system_error'!= $value)
					$commonErrors=true;
			}

			/*
			the logic is treat common errors first then for systems error prompt user to refresh the page 
			 */
			// control the error messsages
   			$errors = $this->form_validation->error_array();
   			// define them
   			if(!isset($errors['type']))$errors['type']='';
   			if(!isset($errors['location']))$errors['location']='';
   			if(!isset($errors['category']))$errors['category']='';

   			if(($errors['type']=='system_error' || $errors['location']=='system_error' || $errors['category']=='system_error') && !$commonErrors)
   			{
   				$addition_info='system error';	
   			}
   			
			for ($i=1; $i <5 ; $i++) { 
       			
       			if(isset($error['input'.$i]))
       			if($errors['input'.$i]=='system_error' && !$commonErrors)
       			{
       				$addition_info='system error';	
       			}					
	 		}     			
        }	  

	   // flesh load	
       if(!$fail_result)
       {


       		$pass_data = array(	'user_id' => $_SESSION['user_id'],
       							'item_id' => $this->input->post('i_ref',true),
       							'name' => $this->input->post('name',true),
       							'price' => $this->input->post('price',true),
       							'category_id' => $this->input->post('category',true),
       							'location_id' => $this->input->post('location',true),
       							'type_id' => $this->input->post('type',true),
       							'front_pic' => $this->input->post('input1',true),
       							'description' => $this->input->post('description',true),
       							'on_display' => $this->input->post('on_display',true),
       							'summary' => $this->input->post('summary',true),
       						);

       		$pass_data['addPic']=array();
       		for ($i=1; $i <13 ; $i++) { 
       		 	if($this->input->post('input'.$i,true)!='')
       			array_push($pass_data['addPic'],$this->input->post('input'.$i));
       		}

       		$pass_data['deletePic']=array();
       		for ($i=1; $i <14 ; $i++) { 
       			if($this->input->post('dlt'.$i,true)!='')
       			array_push($pass_data['deletePic'],$this->input->post('dlt'.$i,true));
       		}

		   	$this->load->model('Item_model');
       		$model_data=$this->Item_model->editItem($pass_data);

       		$href=base_url();
       		$addition_info=$model_data['addition_info'];
       		$status=$model_data['status'];
       		$result_info=$model_data['data']['result_info'];
       		//$item_id=$model_data['data']['item_id'];
       }


       //check if is ajax call
       if($this->input->is_ajax_request())
       {
	       	$data['info']['status']=$status;
	       	$data['info']['data']=array(
	       								 'href'=>$href,
	       								 'addition_info'=>$addition_info,	
	       								 'result_array'=>$result_array,	
	       								 'result_info'=>$result_info,
	       								 'item_id'=>$item_id	
	       								);
	       	$data['print_as']='json';         
	        $this->load->view('ajaxCall/ajaxCall',$data);
       }
       elseif(1==0)
       {}
	}	

	public function single_request()
	{

		/*########################################
          0. load classes
        #######################################*/		    

        $this->load->model('item_request_model');
		$this->load->library('general_functions');
		$this->load->model('Type_model');
        $this->load->model('Category_model');
        $this->load->model('Location_model');
        
		
		/*########################################
          1. Get Data from Database using Models
        #######################################*/		   
        $type =$this->Type_model->getType(); 
		$category =$this->Category_model->getCategory(); 
		$location =$this->Location_model->getLocation(); 

   		$pass_data = array(	'item_id' => $this->uri->segment(2)
   						   );

   		$model_data=$this->item_request_model->getItem($pass_data);

   		$href=base_url();
   		$addition_info=$model_data['addition_info'];
   		$status=$model_data['status'];

   		//do some formating to the results
   		foreach ($model_data['data']['records'] as $key => $value) {

			$model_data['data']['records'][$key]['price']='MK'.$value['price'];
			$model_data['data']['records'][$key]['date']=date( "j M Y", strtotime($value['date']));
			foreach ($value['item_pic'] as $key2 => $value2) {
				# calculate image dimensions
				$width=600;$height =600;
				if (file_exists($value2['path'].'.jpg')) 
					list($width, $height, $type, $attr) = getimagesize($value2['path'].'.jpg');	
				else
					$model_data['data']['records'][$key]['item_pic'][$key2]['path'] = 'media/default/images/no_image';
					$model_data['data']['records'][$key]['item_pic'][$key2]['dimension'] = $width.'x'.$height;
			}
			#limit length 				
			if(strlen($value['item_name'])>23)
				$model_data['data']['records'][$key]['item_name']=$this->general_functions->wordTrimmer($value['item_name'],23,'&hellip;');

   		}

		/*########################################
          2. Send data to view
        #######################################*/		    

        $data['page_data']= array();	
        $data['page_data']['type']= $type;	
		$data['page_data']['category']= $category;	
		$data['page_data']['location']= $location;	
		$data['page_data']['item']= $model_data;

        //echo "<pre>";
		//print_r($model_data);
		//return;
         //check if is ajax call
         // We added an ajax call because the item images got called by jquery after the page is already loaded
       if($this->input->is_ajax_request())
       {
        $data['info']=array();         
        $data['info']['item']= $model_data;        
        $data['print_as']='json';         
        $this->load->view('ajaxCall/ajaxCall',$data);  
       }
       else
       { 
		$this->load->view('admin/single_request',$data);
       }

	}


	public function view_requests()
	{

		/*########################################
          0. load classes
        #######################################*/		    

        $this->load->model('item_request_model');
		$this->load->library('general_functions');
		
		
		/*########################################
          1. Get Data from Database using Models
        #######################################*/		   
        
   		$pass_data = array(	
   						   );

   		$model_data=$this->item_request_model->getItem($pass_data);

   		$href=base_url();
   		$addition_info=$model_data['addition_info'];
   		$status=$model_data['status'];

   		//do some formating to the results
   		foreach ($model_data['data']['records'] as $key => $value) {


   			if(!empty($value['price']))
			$model_data['data']['records'][$key]['price']='MK'.$value['price'];
			else
			$model_data['data']['records'][$key]['price']='---';	

			$model_data['data']['records'][$key]['date']=date( "j M Y", strtotime($value['date']));

			#limit length 				
			if(strlen($value['item_name'])>23)
				$model_data['data']['records'][$key]['item_name']=$this->general_functions->wordTrimmer($value['item_name'],23,'&hellip;');

   		}

		/*########################################
          2. Send data to view
        #######################################*/		    

        $data['page_data']= array();	
        $data['page_data']['item']= $model_data;

        //echo "<pre>";
		//print_r($model_data);
		//return;
         //check if is ajax call
         // We added an ajax call because the item images got called by jquery after the page is already loaded
       if($this->input->is_ajax_request())
       {
        $data['info']=array();         
        $data['info']['item']= $model_data;        
        $data['print_as']='json';         
        $this->load->view('ajaxCall/ajaxCall',$data);  
       }
       else
       { 
		$this->load->view('admin/view_requests',$data);
       }

	}
	public function delete_property_form($pdata=array())
	{



		//default valiables	
		$status=false;
		$fail_result=false;
		$addition_info='';
		$result_info="";
		$item_id = '';
		$result_array=array();
		$href='';
		
		//echo "string";
		//include libraries
		$this->load->library('form_validation');

		//validation configurations
		$validationRules['rule1']=array(
						        array(
						                'field' => 'i_ref',
						                'label' => 'i_ref',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'system_error',
						                				'numeric' => '1system_error',
						                				),	 		                
						        	),
						    );


 		//validate
        $this->form_validation->set_rules($validationRules['rule1']);
  
	    if (!$fail_result && $this->form_validation->run() == FALSE)
        {
        	$fail_result=true;
   			$addition_info='validation error';
   			$result_info="Sorry An error Occurred";
   			// control the error messsages
   			$result_array= $this->form_validation->error_array(); 
			
   			//correct common errors first
			$commonErrors=false;
			foreach ($result_array as $key => $value) {
				if('system_error'!= $value)
					$commonErrors=true;
			}

			/*
			the logic is treat common errors first then for systems error prompt user to refresh the page 
			 */
			// control the error messsages
   			$errors = $this->form_validation->error_array();
   			// define them
   			if(!isset($errors['type']))$errors['type']='';
   			if(!isset($errors['location']))$errors['location']='';
   			if(!isset($errors['category']))$errors['category']='';

   			if(($errors['type']=='system_error' || $errors['location']=='system_error' || $errors['category']=='system_error') && !$commonErrors)
   			{
   				$addition_info='system error';	
   			}
   			
			for ($i=1; $i <5 ; $i++) { 
       			
       			if(isset($error['input'.$i]))
       			if($errors['input'.$i]=='system_error' && !$commonErrors)
       			{
       				$addition_info='system error';	
       			}					
	 		}     			
        }	  

	   // flesh load	
       if(!$fail_result)
       {


       		$pass_data = array(	'user_id' => $_SESSION['user_id'],
       							'item_id' => $this->input->post('i_ref',true),
       						);

		   	$this->load->model('Item_model');
       		$model_data=$this->Item_model->deleteItemPermanently($pass_data);

       		$href=base_url();
       		$addition_info=$model_data['addition_info'];
       		$status=$model_data['status'];
       		$result_info=$model_data['data']['result_info'];
       		//$item_id=$model_data['data']['item_id'];
       }


       //check if is ajax call
       if($this->input->is_ajax_request())
       {
	       	$data['info']['status']=$status;
	       	$data['info']['data']=array(
	       								 'href'=>$href,
	       								 'addition_info'=>$addition_info,	
	       								 'result_array'=>$result_array,	
	       								 'result_info'=>$result_info,
	       								 'item_id'=>$item_id	
	       								);
	       	$data['print_as']='json';         
	        $this->load->view('ajaxCall/ajaxCall',$data);
       }
       elseif(1==0)
       {}
	}	

	public function delete_request_form($pdata=array())
	{



		//default valiables	
		$status=false;
		$fail_result=false;
		$addition_info='';
		$result_info="";
		$item_id = '';
		$result_array=array();
		$href='';
		
		//echo "string";
		//include libraries
		$this->load->library('form_validation');

		//validation configurations
		$validationRules['rule1']=array(
						        array(
						                'field' => 'i_ref',
						                'label' => 'i_ref',
						                'rules' => 'required|numeric',
						                'errors' => array(
						                				'required' => 'system_error',
						                				'numeric' => '1system_error',
						                				),	 		                
						        	),
						    );


 		//validate
        $this->form_validation->set_rules($validationRules['rule1']);
  
	    if (!$fail_result && $this->form_validation->run() == FALSE)
        {
        	$fail_result=true;
   			$addition_info='validation error';
   			$result_info="Sorry An error Occurred";
   			// control the error messsages
   			$result_array= $this->form_validation->error_array(); 
			
   			//correct common errors first
			$commonErrors=false;
			foreach ($result_array as $key => $value) {
				if('system_error'!= $value)
					$commonErrors=true;
			}

			/*
			the logic is treat common errors first then for systems error prompt user to refresh the page 
			 */
			// control the error messsages
   			$errors = $this->form_validation->error_array();
   			// define them
   			if(!isset($errors['type']))$errors['type']='';
   			if(!isset($errors['location']))$errors['location']='';
   			if(!isset($errors['category']))$errors['category']='';

   			if(($errors['type']=='system_error' || $errors['location']=='system_error' || $errors['category']=='system_error') && !$commonErrors)
   			{
   				$addition_info='system error';	
   			}
   			
			for ($i=1; $i <5 ; $i++) { 
       			
       			if(isset($error['input'.$i]))
       			if($errors['input'.$i]=='system_error' && !$commonErrors)
       			{
       				$addition_info='system error';	
       			}					
	 		}     			
        }	  

	   // flesh load	
       if(!$fail_result)
       {


       		$pass_data = array(	'user_id' => $_SESSION['user_id'],
       							'item_id' => $this->input->post('i_ref',true),
       						);

		   	$this->load->model('Item_request_model');
       		$model_data=$this->Item_request_model->deleteItemPermanently($pass_data);

       		$href=base_url();
       		$addition_info=$model_data['addition_info'];
       		$status=$model_data['status'];
       		$result_info=$model_data['data']['result_info'];
       		//$item_id=$model_data['data']['item_id'];
       }


       //check if is ajax call
       if($this->input->is_ajax_request())
       {
	       	$data['info']['status']=$status;
	       	$data['info']['data']=array(
	       								 'href'=>$href,
	       								 'addition_info'=>$addition_info,	
	       								 'result_array'=>$result_array,	
	       								 'result_info'=>$result_info,
	       								 'item_id'=>$item_id	
	       								);
	       	$data['print_as']='json';         
	        $this->load->view('ajaxCall/ajaxCall',$data);
       }
       elseif(1==0)
       {}
	}	

}
