function deleteVote(id)
{
	jQuery.ajax({
		type: "POST",
		url: "?page=ServerControl&id=123",
		data: "deleteVote=" + id,
		success: function(req)
		{
			if (req == "1")
			{
				jQuery("#votelist > li").each(function(n,item)
				{
					if (item.id==id)
					{
						//jQuery(item).effect("fade", {}, 500, function(){
						//jQuery(item).remove();
						//});
						jQuery(item).hide(500, function()
						{
							jQuery(item).remove();
						});
					}
				});
			}
		}
	});
}