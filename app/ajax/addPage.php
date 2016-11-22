<?php
class addPage
{
	public $out; 
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$chooseNavType = functions\request::index("POST","chooseNavType");
		$choosePageType = functions\request::index("POST","choosePageType");
		$title = functions\request::index("POST","title");
		$slug = functions\request::index("POST","slug");
		$cssClass = functions\request::index("POST","cssClass");
		$attachModule = functions\request::index("POST","attachModule");
		$redirect = functions\request::index("POST","redirect");
		$pageDescription = functions\request::index("POST","pageDescription");
		$pageText = functions\request::index("POST","pageText");
		$serialPhotos = unserialize(functions\request::index("POST","serialPhotos"));

		if($chooseNavType=="" || $choosePageType=="" || $title=="" || $slug=="" || $pageDescription=="" || $pageText=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('page', array(
					'method'=>'add', 
					'chooseNavType'=>$chooseNavType, 
					'choosePageType'=>$choosePageType, 
					'title'=>$title, 
					'slug'=>$slug, 
					'cssclass'=>$cssClass, 
					'usefull_type'=>$attachModule, 
					'redirect'=>$redirect, 
					'pageDescription'=>$pageDescription, 
					'pageText'=>$pageText, 
					'serialPhotos'=>$serialPhotos
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