<?php 
class modelesView
{
	public $data;
	public $string;

	public function index(){
		$out = '';
		if(count($this->data)) : 
			foreach ($this->data as $val) {
				$visibility = ($val['visibility']==0) ? 'visibility' : 'visibility_off';
				$out .= sprintf("<tr>
					<td>%d</td>
					<td class=\"tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"%s\">%s</td>
					<td>
					<a href=\"javascript:void(0)\" onclick=\"changeModuleVisibility(%d,%d)\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ხილვადობის შეცვლა\">%s</i></a>

					<a href=\"javascript:void(0)\" onclick=\"editModules('%s','%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i></a>


					<a href=\"javascript:void(0)\" onclick=\"askRemoveModule('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i></a>
					</td>
					</tr>",
					$val['idx'],
					$val['title'], 
					$this->string->cut($val['title'],45),
					$val['visibility'],
					$val['idx'],
					$visibility,
					$val['idx'],
					$val['lang'], 
					$val['idx']
				);
			}
		endif;
		return $out;
	}
}