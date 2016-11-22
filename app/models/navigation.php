<?php 
class navigation
{
	public function __construct()
	{

	}

	public function index()
	{
		$out = "<div class=\"navigation\" id=\"menu\">";
		$out .= "<li data-menuanchor=\"Home\" class=\"active\"><a class=\"MenuCloseClick\" href=\"#Home\">მთავარი</a></li>";
		$out .= "<li data-menuanchor=\"About\"><a class=\"MenuCloseClick\" href=\"#About\">ჩვენს შესახებ</a></li>";
		$out .= "<li data-menuanchor=\"Contact\"><a class=\"MenuCloseClick\" href=\"#Contact\">დაგვიკავშირდით</a></li>";
		$out .= "<li class=\"CalculatorHide\" data-menuanchor=\"Contact\"><a class=\"MenuCloseClick OpenModalClick\" href=\"#CalculatorPopup\">სესხის კალკულატორი</a></li>";
		$out .= "</div>";
		$out .= "<div class=\"nav_bg\">
				<div class=\"nav_bar\">
					<div class=\"c-hamburger c-hamburger--htx\">
					<span>toggle menu</span>
				</div>
			</div>
		</div>";
		return $out;
	}
}