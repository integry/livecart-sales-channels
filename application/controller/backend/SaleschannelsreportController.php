<?php

ClassLoader::import("application.controller.backend.ReportController");
ClassLoader::import("module.sales-channels.application.model.SalesChannelReport");

ClassLoader::import("module.sales-channels.application.model.SalesChannel");
ClassLoader::import("module.sales-channels.application.model.SalesChannelOrder");


class SaleschannelsreportController extends ReportController
{

	public function index()
	{
		$report = new SalesChannelReport();
		$this->initReport($report);
		$report->setChartType(Report::PIE);
		$report->setWithoutChannelLegend($this->translate('_without_sales_channel'));

		// $this->loadLanguageFile('backend/CustomerOrder');
		//$this->application->loadLanguageFiles();

		$type = $this->getOption('saleschannels', 'count');

		switch ($type)
		{
			case 'total':
				$report->getTotalAmount();
				break;
			case 'count':
				$report->getCount();
				break;
		}

		$response = $this->getChartResponse($report);
		$response->set('type', $type);
		return $response;
	}



	// todo: make ReportController private  methods  protected (now copy/paste)
	protected function getChartResponse(Report $report)
	{
		$response = new ActionResponse();
		if (Report::TABLE != $report->getChartType())
		{
			$response->set('chart', $report->getChartDataString());
		}
		else
		{
			$response->set('reportData', $report->getValues());
		}
		$response->set('chartType', $report->getChartType());
		return $response;
	}

	protected function initReport(Report $report)
	{
		$report->setApplication($this->application);
		$report->setLocale($this->locale);
		$report->setInterval($this->getInterval());

		$range = $this->getDateRange();
		$report->setChartType($this->getChartTypeByInterval($this->getInterval()));

		if (!empty($range[0]))
		{
			$report->setFrom($range[0]);
		}

		if (!empty($range[1]))
		{
			$report->setTo($range[1]);
		}
	}

	protected function getChartTypeByInterval($range)
	{
		switch ($range)
		{
			case 'day':
			case 'week':
			case 'month':
				return Report::LINE;

			default:
				return Report::BAR;
		}
	}

	protected function getInterval($default = 'day')
	{
		return $this->getOption('interval', $default);
	}

	protected function getOption($key, $defaultValue)
	{
		$options = json_decode($this->request->get('options'), true);
		return isset($options[$key]) ? $options[$key] : $defaultValue;
	}

	protected function getDateRange()
	{
		if ($this->request->get('date') && ('all' != $this->request->get('date')))
		{
			$res = array();
			foreach (explode(' | ', $this->request->get('date')) as $part)
			{
				$res[] = ('now' == $part) ? null : getDateFromString($part);
			}

			return $res;
		}
	}

}
?>