<?php 
class addModuleForm
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

		$moduleSlug = functions\request::index("POST","moduleSlug");

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
			"value"=>date("d-m-Y")
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"დასახელება", 
			"id"=>"title", 
			"name"=>"title",
			"value"=>""
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
			"value"=>""
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"ბმული", 
			"id"=>"link", 
			"name"=>"link",
			"value"=>""
		));

		$form .= functions\makeForm::close();

		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"form" => $form,
			"attr" => "formModuleAdd('".$moduleSlug."')"
		);	

		return $this->out;
	}
}