<?php

ClassLoader::import("application.model.report.Report");

/**
 * Generate sales reports
 *
 * @package application.model.report
 * @author	Integry Systems
 */
class SalesChannelReport extends Report
{
	public function __construct()
	{
		parent::__construct();


		$this->setChartType(Report::PIE);
	}
	public function  setWithoutChannelLegend($str)
	{
		$this->t_without_sales_channel = $str;
	}
	protected function getMainTable()
	{
		return 'SalesChannelOrder';
	}

	protected function getDateHandle()
	{
		return new ARFieldHandle('SalesChannelOrder', 'date');
	}

	public function getTotalAmount()
	{
		$this->getData('ROUND(SUM(CustomerOrder.totalAmount * ' . $this->getCurrencyMultiplier() . '), 2)');
	}

	public function getCount()
	{
		$this->getData('COUNT(*)');
	}

	protected function getQuery($countSql = null)
	{
		$q = parent::getQuery($countSql);
		$filter = $q->getFilter();
		$filter->joinTable('SalesChannel', 'SalesChannelOrder', 'ID', 'channelID');
		$filter->joinTable('CustomerOrder', 'SalesChannelOrder', 'ID', 'orderID');
		$filter->setGrouping(new ARFieldHandle('SalesChannel', 'ID'));

		$q->addField('IF(SalesChannel.name IS NOT NULL, SalesChannel.name, \''.$this->t_without_sales_channel.'\')', '', 'entry');

		return $q;
	}
}

?>