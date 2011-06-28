/**
 *	@author Integry Systems
 */

Backend.SalesChannelsManager = Class.create();
Backend.SalesChannelsManager.prototype =
{
	initialize: function(salesChannelsList, container, template, properties)
	{
		Backend.SalesChannelsManager.prototype.properties = properties;
		Backend.SalesChannelsManager.prototype.properties["container"] = container;
		Backend.SalesChannelsManager.prototype.properties["template"] = template;

		if ($("createChannel"))
		{
			Element.observe("createChannel", "click", function(e)
			{
				Event.stop(e);
				Backend.SalesChannelsManager.prototype.showAddForm(container);
			});
			Element.observe("createChannelCancel", "click", function(e)
			{
				Event.stop(e);
				Backend.SalesChannelsManager.prototype.hideAddForm(container);
			});
		}

		ActiveList.prototype.getInstance(container.id, {
			beforeEdit: function(li)
			{
				if (!this.isContainerEmpty(li, 'edit'))
				{
					li.handler.cancelEditForm();
					return;
				}
				li.handler.showEditForm(container);
				return false;
			},
			afterEdit: function(li, response) { li.handler.update(response);},
			beforeDelete: function(li)
			{
				if (confirm(Backend.SalesChannelsManager.prototype.properties.confirmDelete.replace("[_1]", li.handler.data.name)))
				{
					return Backend.SalesChannelsManager.prototype.properties.deleteUrl.replace('_id_', li.handler.data.ID);
				}
			},
			afterDelete: function(li, response)
			{
				try
				{
					response = eval('(' + response + ')');
				}
				catch(e)
				{
					return false;
				}
			}
		 }, []);
		salesChannelsList.each(function(el)
		{
			new Backend.SalesChannelsManager.Channel(container, template, el, false);
		});
		ActiveList.prototype.getInstance(container.id).touch(true);
	},

	showAddForm: function(container)
	{
		var
			formContainer,
			form,
			menu;
		this.cancelOpened(container);
		formContainer = $("salesChannelForm");
		form = formContainer.down("form");
		menu = new ActiveForm.Slide("createMenu");
		menu.show("createChannel", formContainer);
		form.reset();
		// ~  why reset does not reset?
		form.down(".referers").value="";
		form.down(".keywords").value="";
		form.down(".name").value="";
		form.down(".id").value="";
		// ~
		form.onsubmit = function(e)
			{
				Event.stop(e);
				this.actionAdd(form);
				return false;
			}.bindAsEventListener(this);

		formContainer.down('a.cancel').onclick = function(e)
			{
				Event.stop(e);
				this.hideAddForm(container);
			}.bindAsEventListener(this);
	},

	hideAddForm: function(container, theme)
	{
		new ActiveForm.Slide("createMenu").hide("createChannel", $("salesChannelForm"));
	},

	cancelOpened: function(container)
	{
		$H($(container).getElementsByTagName('li')).each(function(li)
		{
			if (li && li[1] && li[1].handler)
			{
				li[1].handler.cancelEditForm();
			}
		});
	},

	actionAdd: function(form)
	{
		if (validateForm(form))
		{
			new LiveCart.AjaxRequest(form, null, this.actionAddOnComplete.bind(this));
		}
	},

	actionAddOnComplete: function(originalRequest)
	{
		Backend.SalesChannelsManager.prototype.hideAddForm();
		new Backend.SalesChannelsManager.Channel(Backend.SalesChannelsManager.prototype.properties.container, Backend.SalesChannelsManager.prototype.properties.template, originalRequest.responseData,true, true);
		ActiveList.prototype.getInstance(Backend.SalesChannelsManager.prototype.properties.container.id).touch(true);
	}
}

Backend.SalesChannelsManager.Channel = Class.create();
Backend.SalesChannelsManager.Channel.prototype =
{
	data: null,
	node: null,
	list: null,

	initialize: function(container, template, data, highlight, isNew)
	{
		this.data = data;
		this.list = ActiveList.prototype.getInstance(container.id);
		this.node = this.list.addRecord(data.ID, template.innerHTML, highlight);
		if (isNew)
		{
			this.node.parentNode.insertBefore(this.node, this.node.parentNode.firstChild);
		}
		this.updateHtml();
		this.node.handler = this;
		Element.show(this.node);
	},

	showEditForm: function(container)
	{
		var
			nodes,
			form;

		Backend.SalesChannelsManager.prototype.hideAddForm(container);
		nodes = this.node.parentNode.getElementsByTagName('li');
		$H(nodes).each(function(li)
		{
			if (li && li[1] && li[1].handler && li != this.node)
			{
				li[1].handler.cancelEditForm();
			}
		});

		form = $($('salesChannelForm').cloneNode(true));
		this.node.down('div.formContainer').appendChild(form);
		form.down("form").reset();

		form.down(".id").value = this.data.ID;
		form.down(".name").value = this.data.name;
		form.down(".referers").value = this.data.referersData && this.data.referersData.length > 0 ? this.data.referersData.join("\n") : "";
		form.down(".keywords").value = this.data.keywordsData && this.data.keywordsData.length > 0 ? this.data.keywordsData.join("\n") : "";
		form.show();

		form.onsubmit = this.save.bindAsEventListener(this);
		form.down('a.cancel').onclick = this.cancelEditForm.bindAsEventListener(this);
		this.list.toggleContainerOn(this.list.getContainer(this.node, 'edit'));
	},

	save: function(e)
	{
		Event.stop(e);
		var form = this.node.down('form');
		if (validateForm(form))
		{
			new LiveCart.AjaxRequest(form, null, this.saveSuccess.bind(this));
		}
	},

	saveSuccess: function(originalRequest)
	{
		this.data = originalRequest.responseData;
		this.updateHtml();
		this.cancelEditForm();
		ActiveList.prototype.highlight(this.node, 'yellow');
	},

	cancelEditForm: function(e)
	{
		if (!this.list.isContainerEmpty(this.node, 'edit'))
		{
			this.list.toggleContainerOff(this.list.getContainer(this.node, 'edit'));
		}

		var formContainer = this.node.down('div.formContainer');
		if (!formContainer.firstChild)
		{
			return;
		}
		formContainer.innerHTML = '';
		if (e)
		{
			Event.stop(e);
		}
	},

	update: function(originalRequest)
	{
		this.data = originalRequest.responseData;
		this.updateHtml();
		this.cancelEditForm();
		Element.show(this.node.down('.checkbox'));
		ActiveList.prototype.highlight(this.node, 'yellow');
	},

	updateHtml: function()
	{
		this.node.down('.name').innerHTML = this.data.name;
	}
}

