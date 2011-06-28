<?php

ClassLoader::import('application.model.ActiveRecordModel');

/**
 * @author Integry Systems <http://integry.com>
 */
class SalesChannelOrder extends ActiveRecordModel
{
	/**
	 * Define Filter schema
	 */
	public static function defineSchema()
	{
		$schema = self::getSchemaInstance(__CLASS__);
		$schema->setName(__CLASS__);
		$schema->registerField(new ARPrimaryKeyField("ID", ARInteger::instance()));
		$schema->registerField(new ARForeignKeyField("orderID", "CustomerOrder", "ID", "CustomerOrder", ARInteger::instance()));
		$schema->registerField(new ARForeignKeyField("channelID", "SalesChannel", "ID", "SalesChannel", ARInteger::instance()));
		$schema->registerField(new ARField("date", ARDateTime::instance()));

		$schema->registerField(new ARField("keyword", ARText::instance()));
		$schema->registerField(new ARField("referer", ARText::instance()));
	}

	public static function getNewInstance($channel=null, $order=null, $keyword=null, $referer=null)
	{
		$inst = ActiveRecordModel::getNewInstance(__CLASS__);
		$inst->date->set(date('Y-m-d h:i:s', time()));
		if ($channel && $channel instanceof SalesChannel)
		{
			$inst->channelID->set($channel);
		}
		if ($order && $order instanceof CustomerOrder)
		{
			$inst->orderID->set($order);
		}
		if ($keyword)
		{
			$inst->keyword->set($keyword);
		}
		if ($referer)
		{
			$inst->referer->set($referer);
		}
		return $inst;
	}
}
?>