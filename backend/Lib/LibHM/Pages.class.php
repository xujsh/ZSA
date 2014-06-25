<?php
class Pages
{

	public $url;
	public $replace;
	public $allnum;
	public $limit;

	public function __construct($url,$replace,$page,$allnum,$limit)
	{
		$this->url = $url;
		$this->replace = $replace;
		$this->allnum = $allnum;
		$this->limit = $limit;
		$this->page = $page;
	}

	public static function page($url,$replace,$page,$allnum,$limit)
	{
		 
		$allpage = ceil($allnum/ $limit);


		
		if($allpage<=10)
		{
			$pages = "";

			for($i=1;$i<=$allpage;$i++)
			{
				$classstyle = "";

				if($i == $page)
				{
					$classstyle="cur";
				}
				$inurl = str_replace($replace,$i,$url);
				$pages.="<li><a href='".$inurl."'   class='page_m ".$classstyle." '>".$i."</a></li>";
			}
			$pages .="";

			 
		}
		else
		{
			$snum = $page<=3?1:($page-3+1);

			//$snum = $page+2 >$allpage?$allpage-$snum:$snum;

			if($snum > 1)
			{
				$inurl = str_replace($replace,$page-1,$url);
				$pages = "<li><a class='page_bg end '   href='".$inurl."' >上一页</a></li>";
			}
			else
				$pages = "";

			if($snum > 2)
			{
				$inurl = str_replace($replace,1,$url);
				$pages .= "<li><a   href='".$inurl."' class=' page_m'  >1</a>...</li>";
			}

			for($i =$snum;$i<$snum+10;$i++)
			{
				if($i > $allpage)
					break;

				$classstyle = "";

				if($i == $page)
				{
					$classstyle=" cur ";
				}

				$inurl = str_replace($replace,$i,$url);

				$pages.="<li><a  href='".$inurl."' class=' page_m ".$classstyle." ' >".$i."</a></li>";
			}

			if($page + 8  < $allpage)
			{
				$inurl = str_replace($replace,$allpage,$url);
				$pages .= "<li>...<a href='".$inurl."' class=' page_m'>".$allpage."</a></li>";
			}

			if($page + 8  == $allpage)
			{
				$inurl = str_replace($replace,$allpage,$url);
				$pages .= "<li><a href='".$inurl."' class=' page_m' >".$allpage."</a></li>";
			}
			 
			if($page <$allpage)
			{
				$inurl = str_replace($replace,$page+1,$url);
				$pages .= "<li><a   href='".$inurl."' class='page_bg' >下一页</a></li>";
				 
			}
			else
				$pages .="";

		}
		 
		return $pages;
	}

}

?>