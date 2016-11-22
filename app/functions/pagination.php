<?php 
namespace functions;

class pagination
{
	public function index($total, $itemPerPage)
	{
		$pages = ceil($total / $itemPerPage);

		$out = '<ul class="pagination margin-top-40">';
		
		$back = (isset($_GET['pn']) && $_GET['pn']>1) ? '?pn='.($_GET['pn']-1) : '?pn=1';
		$out .= sprintf('<li><a href="%s"><i class="material-icons">chevron_left</i></a></li>', $back);
		
		for($i = 1; $i<=$pages; $i++)
		{
			$pn_get = (isset($_GET['pn']) && $_GET['pn']>0) ? $_GET['pn'] : 1;
			$active = ($i==$pn_get) ? ' active' : '';			
			$pn = '?pn='.$i;			
			$out .= sprintf('<li class="waves-effect%s"><a href="%s">%d</a></li>', $active, $pn, $i);
		}
		
		$next = (isset($_GET['pn']) && $_GET['pn']<$pages) ? '?pn='.($_GET['pn']+1) : '?pn='.$pages;
		$out .= sprintf('<li><a href="%s"><i class="material-icons">chevron_right</i></a></li>', $next);
		
		$out .= '</ul>';
		return $out;
	}
}