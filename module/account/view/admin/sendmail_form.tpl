<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3>New email message</h3>
</div>
<div class="modal-body">
  <form id="account_sendmail_form" action="">
      <div class="form-group clearfix">
          <label for="account_sendmail_to" class="control-label support-placeholder">To</label>
          <div>
              <input id="account_sendmail_to" type="text" name="to" value="{if $email}{$email|escape}{else}{if $toAccount.email|default:''!=''}{$toAccount.first_name|escape} {$toAccount.last_name|escape} &lt;{$toAccount.email|escape}&gt;{/if}{/if}" class="form-control" placeholder="To" title="To" />
          </div>
      </div>
      <div class="form-group clearfix">
          <label for="account_sendmail_subject" class="control-label support-placeholder">Subject</label>
          <div>
              <input id="account_sendmail_subject" type="text" name="subject" class="form-control" placeholder="Subject" title="Subject" />
          </div>
      </div>
      <div class="form-group clearfix">
          <label for="account_sendmail_message" class="control-label support-placeholder">Message</label>
          <div>
              <textarea id="account_sendmail_message" type="text" name="message" class="form-control" placeholder="Message" title="Message" style="resize:none;height: 160px;">{include file="./mail_body_message.tpl"}</textarea>
          </div>
      </div>
  </form>
</div>
<div class="modal-footer">
  <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
  <button id="account_manager_send_message_button" class="btn btn-info" onclick="$.joodeeAccountManager._send('/admin/sendmail/');">Send Message</button>
</div>
<script type="text/javascript">
jQuery(function(){
    jQuery('#account_manager_send_message_button').show().css('visibility', 'visible');

    jQuery('#account_sendmail_form').validate({
        rules: {
            to: {
                required:true
            },
            subject: {
                required:true
            },
            message: {
                required:true
            }
        },
        messages:{
            to: {
                required:"{AccountIntl::$manager_sendmail_to_required}"
            },
            subject: {
                required:"{AccountIntl::$manager_sendmail_subject_required}"
            },
            message: {
                required:"{AccountIntl::$manager_sendmail_message_required}"
            }
        },
        errorPlacement: function(error, element) {
          jQuery(element).closest('.form-group').find('.error-block').remove();
          jQuery(element).closest('.form-group').find('div:first').append(jQuery(error).addClass('help-block'));
        },
        highlight: function(element, errorClass, validClass) {
          jQuery(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          jQuery(element).closest('.form-group').removeClass('has-error').find('.error-block').remove();
        },
        submitHandler: function(form){

        },
        errorElement: 'span',
        errorClass: 'error-block'
    });

    if(!jQuery.support.placeholder){

        jQuery('#account_sendmail_form .support-placeholder').show();
    }
});
</script>
