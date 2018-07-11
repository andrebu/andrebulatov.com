<?php
$blogCatIds = get_inc_categories("cat_exclude_");
$blogCatArray = explode(',',$blogCatIds);
$blogCatArray[count($blogCatArray)] = 1;
$cat = intval( get_query_var('cat') );
if(is_category())
{
	if(in_array($cat,$blogCatArray))
	{
		include(TEMPLATEPATH . '/blog_listing.php');
	}else
	{
		include(TEMPLATEPATH . '/product_listing.php');
	}
}else
{
	include(TEMPLATEPATH . '/tags.php');
}
?>
