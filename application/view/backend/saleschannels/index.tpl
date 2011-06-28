{includeJs file="library/form/Validator.js"}
{includeJs file="library/form/ActiveForm.js"}
{includeJs file="library/ActiveList.js"}
{includeCss file="library/ActiveList.css"}
{includeJs file="/module/sales-channels/javascript/backend/SalesChannelsManager.js"}
{includeCss file="/module/sales-channels/stylesheet/backend/SalesChannelsManager.css"}
{pageTitle help="content.pages"}{t _sales_channels}{/pageTitle}

{include file="layout/backend/header.tpl"}

<div id="salesChannelContainer">

	<fieldset class="container">
		<ul class="menu" id="createMenu">
			<li class="createChannel">
				<a href="#" id="createChannel" class="pageMenu">{t _new_channel}</a>
			</li>
			<li class="createChannelCancel done" style="display: none">
				<a href="#" id="createChannelCancel" class="pageMenu">{t _cancel}</a>
			</li>
			<li class="viewReports">
				<a href="{link controller=backend.report}" id="viewReports" class="pageMenu">{t _view_reports}</a>
			</li>
		</ul>
	</fieldset>

	<div id="salesChannelForm" class="slideForm addForm" style="display: none;">
		{form handle=$form action="controller=backend.saleschannels action=save"
			method="POST" onsubmit=" return false;"

			autocomplete="off"
		}
			<input type="hidden" name="id" class="id" value="" />
			{* err for="name" *}
			<label for="">{tip _name _hint_name}:</label>
			<fieldset class="error">
				{textfield name="name" class="wide name"}
				<div class="errorText hidden"></div>
			</fieldset>
			{* /err *}
			<label for="">{tip _referers _hint_referers}:</label>
			<div class="textarea">
				<fieldset class="error">
					{textarea name="referers" class="referers"}
					<div class="errorText hidden"></div>
				</fieldset>
			</div>

			<label for="">{tip _keywords _hint_keywords}:</label>
			<div class="textarea">
				<fieldset class="error">
					{textarea name="keywords" class="keywords"}
					<div class="errorText hidden"></div>
				</fieldset>
			</div>

			<fieldset class="controls">
				<span class="progressIndicator" style="display: none;"></span>
				<input type="submit" class="submit" value="{t _save}">
				{t _or}
				<a href="index.tpl#" class="cancel">{t _cancel}</a>
			</fieldset>

		</fieldset>
		{/form}

		<iframe name="fileUpload_{$theme}" id="fileUpload_{$theme}" style="display: none"></iframe>

	</div>
</div>

<ul id="salesChannelsList" class="activeList activeList_add_delete activeList_add_edit">
</ul>


<ul style="display: none;">
	<li id="salesChannelsList_template" style="position: relative;">
		<span class="progressIndicator" style="display: none; "></span>
		<span class="filesData">
			<input type="hidden" class="theme" value="" />
		</span>
		<span class="name"></span>
		<div class="formContainer activeList_editContainer" style="display: none;"></div>
		<div class="clear"></div>
	</li>
</ul>

<script type="text/javascript">
	new Backend.SalesChannelsManager
	(
		{json array=$salesChannelsList},
		$('salesChannelsList'),
		$('salesChannelsList_template'),
		{literal}{{/literal}
			deleteUrl:"{link controller=backend.saleschannels action=delete id=_id_}",
			confirmDelete:"{t _del_conf}"
		{literal}}{/literal}
	);
</script>


</div>

<div class="clear"></div>

{include file="layout/backend/footer.tpl"}



















