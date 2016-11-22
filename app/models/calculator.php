<?php 
class calculator
{
	public $types; 

	public function __construct()
	{

	}

	public function index()
	{
		$out = "<div id=\"CalculatorPopup\" class=\"modal modal-trigger AuthorizationPopup\">";
		// $out .= "<input type=\"hidden\" id=\"loan-procent\" value=\"".strip_tags($this->procent)."\" />";
		$out .= "<div class=\"modal-content\">";
		$out .= "<div class=\"modal-action modal-close\"></div>";
		$out .= "<div class=\"AutorizationForm\">";
		$out .= "<div class=\"row\">";
		$out .= "<div class=\"form-group col-sm-10 padding_0\">";
		$out .= "<div class=\"col-sm-12\">
	      				<div class=\"form-group\">
	      					<label class=\"TitleLabel\">სესხის კალკულატორი</label>
	      					<br/><br/>
	      				</div>
	      			</div>";
		$out .= "</div>";
		$out .= "<input type=\"hidden\" id=\"loan-type\" class=\"loan-type\" name=\"loan-type\">";
		$out .= "<div class=\"input-field col-sm-6\">
		      	<div class=\"form-group\">					  
				<select onchange=\"fireChangeType(this.value)\"> 
				<option value=\"\" disabled selected>აირჩიეთ ტიპი</option>";
		if(count($this->types))
		{
			foreach ($this->types as $val) {
				$out .= "<option value=\"".strip_tags($val['description'])."\">".strip_tags($val['title'])."</option>";
			}
		}			      
		$out .= "</select>
					    <label>აირჩიეთ ტიპი</label>
				    </div>
		        </div>";
		$out .= "<div class=\"input-field col-sm-6\">
		      		<div class=\"form-group\">
		      			<input id=\"loan-money\" type=\"text\" class=\"\">
		      			<label for=\"loan-money\">თანხის რაოდენობა</label>
		      		</div>
		        </div>";
		$out .= "<div class=\"input-field col-sm-6\">
		      		<div class=\"form-group\">
		      			<input id=\"loan-period\" name=\"loan-period\" type=\"text\" class=\"\">
		      			<label for=\"loan-period\">ხანგრძლივობა (თვე)</label>
		      		</div>
		        </div>";
		$out .= "<div class=\"input-field col-sm-6\">
		      		<div class=\"form-group\"> 
		      			<span class=\"SpanText\" id=\"total-money\">ჯამური თანხა: <span></span></span>
		      			<span class=\"SpanText\" id=\"month-bill\">თვეში გადასახდელი თანხა: <span></span></span>
		      		</div>
		        </div>";
		$out .= "<div class=\"input-field col-sm-12 text-center\">
		      		<div class=\"form-group\">
		      			<div class=\"ButtonOrange waves-effect waves-light\" onclick=\"calculate()\">დათვლა</div>
		      		</div>
		        </div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		return $out;
	}
}