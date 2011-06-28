<?php

ClassLoader::import('module.sales-channels.application.model.SalesChannelOrder');
ClassLoader::import('module.sales-channels.application.model.SalesChannel');

class AppendSalesChannelAndReferer extends ModelPlugin
{
	public function process()
	{

		if (array_key_exists('SalesChannelData', $this->object))
		{
			return;
		}
		$this->object['SalesChannelData'] = false;

		$filter = new ARSelectFilter();
		$filter->joinTable('SalesChannel', 'SalesChannelOrder', 'ID', 'channelID');
		$filter->setCondition(
			new EqualsCond(new ARFieldHandle('SalesChannelOrder', 'orderID'), $this->object['ID'])
		);

		$rs = ActiveRecordModel::getRecordSet('SalesChannelOrder', $filter, true);
		if ($rs && $rs->size())
		{
			$channelOrder = $rs->shift();
			
			$this->object['SalesChannelData'] = array('SalesChannelOrder'=>$channelOrder->toArray());

			$channel = $channelOrder->channelID->get();
			if ($channel)
			{
				$this->object['SalesChannelData']['SalesChannel'] = $channel->toArray();
			}
		}
	}
}

?>