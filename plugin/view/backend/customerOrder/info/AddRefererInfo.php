<?php

class AddRefererInfo extends ViewPlugin
{
	public function process($source)
	{
		// before closing tag of <fieldset class="order_info">
		$source = preg_replace('/(\<fieldset\sclass\=\"order_info\">)(.*?)(<\/fieldset>)/si', '$1$2

		{if $order.SalesChannelData}

			{if $order.SalesChannelData.SalesChannel}
				<div class="{zebra} clearfix">
					<label class="param">{t _sales_channel}:</label>
					<label class="value">
						{$order.SalesChannelData.SalesChannel.name}
					</label>
				</div>
			{/if}

			{if $order.SalesChannelData.SalesChannelOrder.referer}
				<div class="{zebra} clearfix">
					<label class="param">{t _referer}:</label>
					<label class="value">
						{$order.SalesChannelData.SalesChannelOrder.referer}
					</label>
				</div>
			{/if}
		{/if}
		$3', $source);

		return $source;
	}
}
?>