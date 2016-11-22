<?php 
class editPageForm
{
	public $out; 
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';

		$output = array();
		$idx = functions\request::index("POST","idx");
		$lang = functions\request::index("POST","lang");

		if($idx == "" || $lang == "")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}
		else
		{
			$Database = new Database('page', array(
				'method'=>'selectById', 
				'idx'=>$idx,
				'lang'=>$lang 
			));
			$output = $Database->getter();

			$photos = new Database('photos', array(
				'method'=>'selectByParent', 
				'idx'=>$idx 
			));
			$pictures = $photos->getter();

			$form = functions\makeForm::open(array(
				"action"=>"?",
				"method"=>"post",
				"id"=>""
			));

			$form .= functions\makeForm::select(array(
				"id"=>"chooseNavType",
				"choose"=>"აირჩიეთ ნავიგაციის ტიპი",
				"options"=>array("მთავარი", "დამატებითი"), 
				"selected"=>$output['nav_type'],
				"disabled"=>"true"
			));

			$form .= functions\makeForm::select(array(
				"id"=>"choosePageType",
				"choose"=>"აირჩიეთ გვერდის ტიპი",
				"options"=>array(
					"text"=>"ტექსტური",
					"plugin"=>"პლაგინი"
				), 
				"selected"=>$output['type'],
				"disabled"=>"false"
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"დასახელება", 
				"id"=>"title", 
				"name"=>"title",
				"value"=>$output['title']
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"ბმული", 
				"id"=>"slug", 
				"name"=>"slug", 
				"value"=>$output['slug']
			));

			/*  ^^^^^^^^^^^^^^^ */
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"კლასი", 
				"id"=>"cssClass", 
				"name"=>"cssClass",
				"value"=>$output['cssclass']
			));

			$parentModuleOptions = new Database('modules', array(
				'method'=>'parentModuleOptions', 
				'lang'=>'ge'
			));

			$form .= functions\makeForm::select(array(
				"id"=>"attachModule",
				"choose"=>"მიამაგრე მოდული",
				"options"=>$parentModuleOptions->getter(),
				"selected"=>$output['usefull_type'],
				"disabled"=>"false"
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"გადამისამართება", 
				"id"=>"redirect", 
				"name"=>"redirect", 
				"value"=>$output['redirect']
			));

			$form .= functions\makeForm::label(array(
				"id"=>"shortDescription", 
				"for"=>"pageDescription", 
				"name"=>"მოკლე აღწერა",
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"pageDescription",
				"name"=>"pageDescription",
				"placeholder"=>"მოკლე აღწერა", 
				"value"=>$output['description']
			));

			$form .= functions\makeForm::label(array(
				"id"=>"longDescription", 
				"for"=>"pageText", 
				"name"=>"ვრცელი აღწერა",
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"pageText",
				"name"=>"pageText",
				"placeholder"=>"ვრცელი აღწერა", 
				"value"=>$output['text'] 
			));


			$form .= "<div class=\"row\" id=\"photoUploaderBox\" style=\"margin:0 -10px\">";
		
			if(count($pictures)){
				$i = 2;
				
				foreach($pictures as $picture) {
					$form .= "<div class=\"col s4 imageItem\" id=\"img".$i."\">
						<div class=\"card\">
				    		<div class=\"card-image waves-effect waves-block waves-light\">
				    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"".$picture['path']."\" />
				      			<img class=\"activator\" src=\"".Config::WEBSITE."image/loadimage?f=".Config::WEBSITE_.$picture["path"]."&w=215&h=173\" />
				    		</div>

				    		<div class=\"card-content\">
			                	<p>
			                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img".$i."')\" class=\"large material-icons\">mode_edit</a>
			                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img".$i."')\" class=\"large material-icons\">delete</a>
			                	</p>
			              	</div>

			    		</div>
			  		</div>";
			  		$i++;
				}
			}

			$form .= "<div class=\"col s4 imageItem\" id=\"img1\">
				<div class=\"card\">
		    		<div class=\"card-image waves-effect waves-block waves-light\">
		    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"\" />
		      			<img class=\"activator\" src=\"/public/img/noimage.png\" />
		    		</div>

		    		<div class=\"card-content\">
	                	<p>
	                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img1')\" class=\"large material-icons\">mode_edit</a>
	                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img1')\" class=\"large material-icons\">delete</a>
	                	</p>
	              	</div>

	    		</div>
	  		</div>";				

	  		$form .= "</div>";


			$form .= functions\makeForm::close();


			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				),
				"form" => $form,
				"attr" => "formPageEdit('".$idx."', '".$lang."')"
			);

		}

		

		return $this->out;
	}
}