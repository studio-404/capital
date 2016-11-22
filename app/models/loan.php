<?php 
class loan
{
	public $cities;
	public $agreement;
	public function __construct()
	{
		$selectInfoData = new Database('modules', array(
			"method"=>"selectInfoData",
			"lang"=>"ge"
		));
		$selectInfoData = $selectInfoData->getter();
		$this->agreement = strip_tags($selectInfoData['agreement'],'<a>');

		try{
			$dom = new DOMDocument();
			@$dom->loadHTML(mb_convert_encoding($this->agreement, 'HTML-ENTITIES', 'UTF-8'));
			$x = new DOMXPath($dom);

			foreach($x->query("//a") as $node)
			{   
				$node->setAttribute("target","_blank");
			}
			$this->agreement = $dom->saveHtml();
		}catch(Exception $e){}
	}

	public function index()
	{ 
		$out = "<div id=\"ApplicationModal\" class=\"modal ApplicationModal\">";
		$out .= "<form id=\"loanForm\" name=\"loanForm\">";
		$out .= "<input type=\"hidden\" id=\"loan-type\" name=\"loan-type\" value=\"\" />";
		
		$out .= "<div class=\"modal-content\">";
		$out .= "<div class=\"modal-action modal-close\"></div> ";
		$out .= "<div class=\"AutorizationForm\">";
		$out .= "<div class=\"row\">";
		
		$out .= "<div class=\"form-group col-sm-12 padding_0\">";
		$out .= "<div class=\"col-sm-4\">";
		$out .= "<label class=\"TitleLabel\">განაცხადის შევსება</label>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "<div class=\"col-sm-12\">";
		$out .= "<div class=\"modal-message-box\"></div>";
		$out .= "</div>";
		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-name\" name=\"loan-name\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-name\">სახელი</label>";
		$out .= "</div></div>";
		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-surname\" name=\"loan-surname\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-surname\">გვარი</label>";
		$out .= "</div></div>";
		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-pid\" name=\"loan-pid\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-pid\">პირადი ნომერი</label>";
		$out .= "</div></div>";
		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-dob\" name=\"loan-dob\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-dob\">დაბადების თარიღი</label>";
		$out .= "</div></div>";
		
		// $out .= "<div class=\"input-field col-sm-4\">";
		// $out .= "<div class=\"form-group\">";
		// $out .= "<input id=\"loan-gender\" name=\"loan-gender\" type=\"text\" class=\"\">";
		// $out .= "<label for=\"loan-gender\">სქესი</label>";
		// $out .= "</div></div>";


		$out .= "<div class=\"input-field col-sm-4\"><div class=\"form-group\">";
		$out .= "<select name=\"loan-gender\" id=\"loan-gender\">";
		$out .= "<option value=\"მამრობითი\">მამრობითი</option>";	
		$out .= "<option value=\"მდედრობითი\">მდედრობითი</option>";	
		$out .= "</select>";
		$out .= "<label>აირჩიეთ სქესი</label></div></div>";

		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-email\" name=\"loan-email\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-email\">ელ-ფოსტა</label>";
		$out .= "</div></div>";
		
		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-phone\" name=\"loan-phone\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-phone\">ტელეფონი</label>";
		$out .= "</div></div>";
		
		$out .= "<div class=\"input-field col-sm-4\"><div class=\"form-group\">";
		$out .= "<select name=\"loan-city\" id=\"loan-city\">";
		foreach ($this->cities as $val) {
			$out .= "<option value=\"".$val['id']."\">".$val['names']."</option>";
		}		
		$out .= "</select>";
		$out .= "<label>აირჩიეთ ქალაქი</label></div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-street\" name=\"loan-street\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-street\">ქუჩა</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-home\" name=\"loan-home\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-home\">სახლი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-flat\" name=\"loan-flat\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-flat\">ბინა</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-postal\" name=\"loan-postal\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-postal\">საფოსტო კოდი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-income\" name=\"loan-income\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-income\">ყოველთვიური შემოსავალი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-otherloan\" name=\"loan-otherloan\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-otherloan\">მიმდინარე სესხი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\" style=\"opacity:0\">
		      		<div class=\"form-group\">
		      			<input id=\"PersonalNumber\" type=\"text\" class=\"\">
		      			<label for=\"PersonalNumber\"></label>
		      		</div>
		        </div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-password\" name=\"loan-password\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-password\">პაროლი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-4\">";
		$out .= "<div class=\"form-group\">";
		$out .= "<input id=\"loan-repassword\" name=\"loan-repassword\" type=\"text\" class=\"\">";
		$out .= "<label for=\"loan-repassword\">გაიმეორე პაროლი</label>";
		$out .= "</div></div>";

		$out .= "<div class=\"input-field col-sm-9\">
		      		<div class=\"form-group\">
		      			<div class=\"ApplicationFooterText\">
		      				<input type=\"checkbox\" class=\"filled-in\" id=\"checkbox1\" name=\"checkbox1\" />
      						<label for=\"checkbox1\">გავეცანი და ვეთანხმები ".$this->agreement." პირობებს</label> 
		      				<input type=\"checkbox\" class=\"filled-in\" id=\"checkbox2\" name=\"checkbox2\" />
      						<label for=\"checkbox2\">საკრედიტო ისტორიის გადამოწმება სს კრედიტინფო საქართველოს მონაცემთა ბაზაში</abel>
		      			</div>
		      		</div>
		        </div>";

		$out .= "<div class=\"input-field col-sm-3\">
		       	<div class=\"form-group\">
		       	<div class=\"ButtonOrange waves-effect waves-light\" style=\"padding:0 20px;\" onclick=\"makeStatement()\">განაცხადის გაგზავნა</div>
		       	</div>
		    </div>";

		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</form>";
		$out .= "</div>";
		
		
		return $out;
	}
}