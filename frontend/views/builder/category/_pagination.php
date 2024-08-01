<?php
	if(isset($paginate))
	{
	    $pageCount = $paginate->getPageCount();

		if($pageCount > 1)
		{
			echo '<ul class="pagination">';
			    $currentPage = $paginate->getPage() + 1;
			    for($i=1; $i<=$pageCount; $i++)
			    {
				    $disabled = null;
				    $active = null;
				    if($currentPage == $i)
				    {
				    	$active = 'active';
				    	// $disabled = 'disabled';
				    }	
				    echo '<li class="page-item '.$disabled.' '.$active.'">';
				    echo '<a class="page-link" href="?page='.$i.'">'.$i.'</a>';
				    echo '</li>';
			    }
			echo '</ul>';
		}
	}
?>