<?php

/**
 * @author Integry Systems
 */
ClassLoader::import("application.controller.BaseController");
ClassLoader::import("module.sales-channels.application.model.SalesChannel");


class SaleschannelsController extends BaseController
{
	public function index()
	{
		$request = $this->getRequest();
		$theme = $request->get('id');
		//$tfh = ThemeFile::getNewInstance($theme);
		$response = new ActionResponse();
		$response->set('form',$this->buildForm());

		$response->set('salesChannelsList',SalesChannel::getlist());
		$response->set('theme',$theme);
		return $response;
	}

	public function save()
	{
		$request = $this->getRequest();

		$channel = SalesChannel::getInstanceByID($request->get('id'));

		if (!$channel)
		{
			$channel = SalesChannel::getNewInstance();
		}
		$validator = $this->buildValidator();
		if (!$validator->isValid())
		{
			return new JSONResponse(null, "error", $validator->getErrorList());
		}

		$channel->loadRequestData($request);
		$channel->save();
		return new JSONResponse($channel->toArray(), "success");
	}

	public function delete()
	{
		$request = $this->getRequest();
		$channel = SalesChannel::getInstanceByID($request->get('id'));
		$channel->delete();
		return new JSONResponse(null, "success");
	}

	protected function buildValidator()
	{
		$validator = $this->getValidator('salesChannel', $this->request);
		$validator->addCheck('name', new IsNotEmptyCheck($this->translate('_err_enter_name')));

		return $validator;
	}

	protected function buildForm()
	{
		return new Form($this->buildValidator());
	}
}
?>