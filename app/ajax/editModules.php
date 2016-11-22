<?php 
class editModules
{
	public $out; 
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$idx = functions\request::index("POST","idx");
		$lang = functions\request::index("POST","lang");

		if($idx == "" || $lang=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('modules', array(
					'method'=>'selectById', 
					'idx'=>$idx, 
					'lang'=>$lang
			));
			$output = $Database->getter();


			$form = functions\makeForm::open(array(
				"action"=>"?",
				"method"=>"post",
				"id"=>"",
				"id"=>"",
			));

			$form .= functions\makeForm::label(array(
				"id"=>"dateLabel", 
				"for"=>"date", 
				"name"=>"თარიღი: ( დღე-თვე-წელი )",
				"require"=>""
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"დღე/თვე/წელი", 
				"id"=>"date", 
				"name"=>"date",
				"value"=>date("d-m-Y", $output['date'])
			));

		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"დასახელება", 
				"id"=>"title", 
				"name"=>"title",
				"value"=>$output['title']
			));


			$form .= functions\makeForm::label(array(
				"id"=>"longDescription", 
				"for"=>"pageText", 
				"name"=>"აღწერა",
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"pageText",
				"name"=>"pageText",
				"placeholder"=>"აღწერა",
				"value"=>$output['description']
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"ბმული", 
				"id"=>"link", 
				"name"=>"link",
				"value"=>$output['url']
			));

			$form .= functions\makeForm::close();

			
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				),
				"form" => $form,
				"attr" => "formModuleEdit('".$idx."','".$lang."')"
			);	
		}

		

		return $this->out;
	}
}