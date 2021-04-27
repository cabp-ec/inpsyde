(function ($) {
  'use strict';

  $(function () {
    const ajax_action = ajax_object.ajax_action;
    const ajax_trigger = ajax_object.ajax_trigger;
    const modal = $(`#${ajax_object.modal_id}`);
    const template_loading = Hogan.compile(ajax_object.template_loading);
    const template_content = Hogan.compile(ajax_object.template_content);
    const template_error = Hogan.compile(ajax_object.template_error);

    modal.dialog({
      modal: true,
      autoOpen: false,
      title: 'Resource Detail',
      draggable: true,
      resizable: true
    });

    $(ajax_trigger).click(function (event) {
      event.preventDefault();

      const item_id = Number($(this).attr('data-item'));
      const data = {
        action: ajax_action,
        item_id
      };

      modal.html(template_loading.render({}));
      modal.dialog( 'option', 'position', { my: 'center top', at: 'center top', of: window } );
      modal.dialog('open');

      $.post(ajax_object.ajax_url, data, (response_body) => {
        const response = JSON.parse(response_body);
        const status = response.status;
        const context = response.data;
        let content;

        if (200 === status) {
          content = template_content.render({ items: context });
        }
        else {
          content = template_error.render(context);
        }

        modal.html(content);
      });
    });
  });

})(jQuery);
