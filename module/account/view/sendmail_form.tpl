<form id="account_sendmail_form" action="">
    <div class="control-group">
        <label for="account_sendmail_to" class="control-label support-placeholder">To</label>
        <div class="controls clearfix">
            <input id="account_sendmail_to" type="text" name="to" value="{if $email}{$email|escape}{else}{if $toAccount.email|default:''!=''}{$toAccount.first_name|escape} {$toAccount.last_name|escape} &lt;{$toAccount.email|escape}&gt;{/if}{/if}" class="input-block-level" placeholder="To" title="To" />
        </div>
    </div>
    <div class="control-group">
        <label for="account_sendmail_subject" class="control-label support-placeholder">Subject</label>
        <div class="controls clearfix">
            <input id="account_sendmail_subject" type="text" name="subject" class="input-block-level" placeholder="Subject" title="Subject" />
        </div>
    </div>
    <div class="control-group">
        <label for="account_sendmail_message" class="control-label support-placeholder">Message</label>
        <div class="controls clearfix">
            <textarea id="account_sendmail_message" type="text" name="message" class="input-block-level" placeholder="Message" title="Message" style="resize:none;height: 160px;">{include file="./mail_body_message.tpl"}</textarea>
        </div>
    </div>
</form>
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
        submitHandler: function(form){

        }
    });

    if(!jQuery.support.placeholder){

        jQuery('#account_sendmail_form .support-placeholder').show();
    }
});
</script>
