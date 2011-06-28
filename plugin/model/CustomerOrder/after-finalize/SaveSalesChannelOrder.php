<?php

ClassLoader::import('module.sales-channels.application.model.SalesChannel');
ClassLoader::import('module.sales-channels.application.model.SalesChannelOrder');

class SaveSalesChannelOrder extends ModelPlugin
{
	public function process()
	{
		$referer = array_key_exists('sales-channel-referer',$_COOKIE) ? $_COOKIE['sales-channel-referer'] : null;
		$keyword = array_key_exists('sales-channel-keyword', $_COOKIE) ? $_COOKIE['sales-channel-keyword'] : null;
		$channel = null;
		if($keyword)
		{
			// 1. find by keyword.  (uri -  ?ref=keyword)
			$channel = SalesChannel::findByKeyword($keyword);
		}
		if (!$channel && $referer)
		{
			// 2. find by $_SERVER['HTTP_REFERER']
			$channel = SalesChannel::findByReferer($referer);
		}
		if ($channel || $referer) // ignore not existing keywords?
		{
			$sco = SalesChannelOrder::getNewInstance($channel, $this->object, $keyword, $referer);
			$sco->save();
		}
	}
}
?>