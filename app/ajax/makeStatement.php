<?php 
class makeStatement
{
	public $out; 
	
	public function index(){
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			), 
			"Success" => array(
				"Code"=>0,
				"Text"=>"",
				"Details"=>""
			)
		);
		$formData = functions\request::index("POST","formData");
		
		$params = array();
		parse_str($formData, $params);
		/*
		loan-name=test&loan-surname=test&loan-pid=test&loan-dob=test&loan-gender=test&loan-email=tes&loan-phone=test&loan-street=test&loan-home=tes&loan-flat=tes&loan-postal=tes&loan-income=tes&loan-otherloan=tes&loan-password=123&loan-repassword=123&checkbox1=on&checkbox2=on
		*/
		if(
			(!isset($params['loan-type']) || $params['loan-type']=="") || 
			(!isset($params['loan-name']) || $params['loan-name']=="") || 
			(!isset($params['loan-surname']) || $params['loan-surname']=="") || 
			(!isset($params['loan-pid']) || $params['loan-pid']=="") || 
			(!isset($params['loan-dob']) || $params['loan-dob']=="") || 
			(!isset($params['loan-gender']) || $params['loan-gender']=="") || 
			(!isset($params['loan-email']) || $params['loan-email']=="") || 
			(!isset($params['loan-phone']) || $params['loan-phone']=="") || 
			(!isset($params['loan-city']) || $params['loan-city']=="") || 
			(!isset($params['loan-street']) || $params['loan-street']=="") || 
			(!isset($params['loan-home']) || $params['loan-home']=="") || 
			(!isset($params['loan-flat']) || $params['loan-flat']=="") || 
			(!isset($params['loan-postal']) || $params['loan-postal']=="") || 
			(!isset($params['loan-income']) || $params['loan-income']=="") || 
			(!isset($params['loan-otherloan']) || $params['loan-otherloan']=="") || 
			(!isset($params['loan-password']) || $params['loan-password']=="") || 
			(!isset($params['loan-repassword']) || $params['loan-repassword']=="") 
		)
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if(!isset($params['checkbox1']) || !isset($params['checkbox2']) || $params['checkbox1']!="on" || $params['checkbox2']!="on")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"გთხოვთ დაეთანხმოთ წესებს და ისტორიის გადამოწმებას სს კრედიტინფო საქართველოს მონაცემთა ბაზაში !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if($params['loan-password']!=$params['loan-repassword'])
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"პაროლები არ ემთხვევა ერთმანეთს !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}
		else
		{
			$Database = new Database('statements', array(
					'method'=>'insert', 
					'loanType'=>$params['loan-type'], 
					'name'=>$params['loan-name'], 
					'surname'=>$params['loan-surname'], 
					'pid'=>$params['loan-pid'], 
					'dob'=>$params['loan-dob'], 
					'gender'=>$params['loan-gender'], 
					'email'=>$params['loan-email'], 
					'phone'=>$params['loan-phone'], 
					'city'=>$params['loan-city'], 
					'street'=>$params['loan-street'], 
					'home'=>$params['loan-home'], 
					'flat'=>$params['loan-flat'], 
					'postal'=>$params['loan-postal'], 
					'income'=>$params['loan-income'], 
					'otherloan'=>$params['loan-otherloan'], 
					'password'=>$params['loan-password']
			));
			$output = $Database->getter();

			if($output){
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>1, 
						"Text"=>"ოპერაცია შესრულდა წარმატებით !",
						"Details"=>""
					)
				);
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"ოპერაციის შესრულებისას დაფიქსირდა შეცდომა !",
						"Details"=>""
					)
				);
			}	
		}


		return $this->out;
	}
}