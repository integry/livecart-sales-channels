<?php

ClassLoader::import('application.model.system.MultilingualObject');

/**
 * @author Integry Systems <http://integry.com>
 */
class SalesChannel extends MultilingualObject // when ActiveRecordModel::loadRequestData(), and model has field with type ARArray then model requires MultilingualObject::setValueArrayByLang() method!
{
	/**
	 * Define Filter schema
	 */
	public static function defineSchema()
	{
		$schema = self::getSchemaInstance(__CLASS__);
		$schema->setName(__CLASS__);

		$schema->registerField(new ARPrimaryKeyField("ID", ARInteger::instance()));

		$schema->registerField(new ARField("name", ARText::instance(255)));
		$schema->registerField(new ARField("keywords", ARArray::instance()));
		$schema->registerField(new ARField("referers", ARArray::instance()));
	}

	public static function getNewInstance()
	{
		return ActiverRecordModel::getNewInstance(__CLASS__);

	}
	public static function findByKeyword($keyword)
	{
		$filter = new ARSelectFilter();
		$filter->setCondition(new LikeCond(new ARFieldHandle(__CLASS__, 'keywords'), '%'.serialize($keyword).'%' ));

		$rs = ActiveRecordModel::getRecordSet(__CLASS__, $filter);
		if($rs->size())
		{
			return $rs->shift(); // what if more than one?
		}
		return null;
	}

	public function loadRequestData($request)
	{
		parent::loadRequestData($request);

		$this->keywords->set($this->_createValueArray($request->get('keywords')));
		$this->referers->set($this->_createValueArray($request->get('referers')));
	}

	private function _createValueArray($str)
	{
		$r = array();
		foreach (explode("\n", $str) as $value)
		{
			$r[] = (string)trim($value);
		}
		return count($r) ? $r : null;
	}

	public static function getInstanceByID($id)
	{
		return parent::getInstanceByID(__CLASS__, $id, true);
	}

	public static function findByReferer($referrer)
	{
		$filter = new ARSelectFilter();
		$filter->setCondition(new LikeCond(new ARFieldHandle(__CLASS__, 'referers'), '%'.serialize($referrer).'%'));

		return ActiveRecordModel::getRecordSet(__CLASS__, $filter);
	}


	public static function getList()
	{
		$filter =new ARSelectFilter();
		$filter->setOrder(new ARFieldHandle(__CLASS__, 'ID'), ARSelectFilter::ORDER_DESC);
		return ActiveRecordModel::getRecordSetArray(__CLASS__, $filter, true);
	}

}
?>