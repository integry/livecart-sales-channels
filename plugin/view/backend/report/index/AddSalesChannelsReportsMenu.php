<?php

class AddSalesChannelsReportsMenu extends ViewPlugin
{
	public function process($source)
	{
		if (preg_match('/^(?P<before>.*?)(?P<opening>\<ul\b[^\>]*\>)(?P<items>.*?)(?P<closing>\<\/ul\>)(?P<after>.*)$/si', $source, $match))
		{

			// pp($source);

			$source = $match['before'].
			$match['opening'].
			$match['items'].
			'
			<li id="menuSalesChannels">
				<a
					style="background-image: url(image/silk/connect.png);"
					href="{link controller=backend.saleschannelsreport}">{t _sales_channels}</a>
			</li>
			'.
			$match['closing'].
			$match['after'];
		}
		return $source;
	}
}
?>