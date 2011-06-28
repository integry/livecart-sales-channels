<h1>{t _sales_channels}</h1>

<div class="chartMenu" id="menu_saleschannels">
	<div class="typeSelector">
		<a href="#" id="count">{t _sales_channels_count}</a> | <a id="total" href="#">{t _sales_channels_total}</a>
	</div>

	{include file="backend/report/intervalSelect.tpl"}

	<div class="clear"></div>
</div>

{include file="backend/report/chart.tpl" activeMenu=$type width="100%"}