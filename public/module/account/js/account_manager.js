(function($) {

    $.joodeeAccountManager = {

        'emailMessage': function(route, accId, email){

            $('.modal-backdrop:visible, .modal:visible').hide();

            $('<div id="modal_sendmail" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>New email message</h3></div><div class="modal-body">Loading, please wait...</div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal({
                remote: route+'?'+(accId==undefined?'':'acc_id='+accId+'&')+(email==undefined?'':'email='+encodeURIComponent(email))
            }).on('hide.bs.modal', function(){

                $('.modal-backdrop:hidden, .modal:hidden').show();
                $('#modal_sendmail').remove();
            });

            return false;
        },
        '_send': function(route){

            if($('#account_sendmail_form').valid()){

                $('#modal_sendmail').hide();

                $('<div id="modal_sendmail_send" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-request-status">Sending request</h3></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar" style="width: 10%;"></div></div></div><div class="modal-footer"><button id="modal_sendmail_edit_message_button" class="btn btn-warning" onclick="$.joodeeAccountManager._sendErrorBack();">Back</button><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal({
                    backdrop:false
                }).on('hide.bs.modal', function(){

                    $('#modal_sendmail').modal('hide');
                    $('#modal_sendmail_send').remove();
                });

                $('#modal_sendmail_send .progress .progress-bar').css('width', '50%');

                $.post(route+'send/', {to:$('#account_sendmail_to').val(), subject:$('#account_sendmail_subject').val(), message:$('#account_sendmail_message').val()}, function(response){

                    var errorOccurred = function(message){

                        $('#modal_sendmail_send .modal-request-status').html(message).addClass('text-danger');
                        $('#modal_sendmail_send .progress .progress-bar').addClass('progress-bar-danger').css('width', '100%');
                        $('#modal_sendmail_edit_message_button').show().css('visibility', 'visible');
                    }

                    if(typeof(response)=='object' && response.success!=undefined && response.success===true){

                        $('#modal_sendmail_send .modal-request-status').html(response.message).addClass('text-success');
                        $('#modal_sendmail_send .progress .progress-bar').addClass('progress-bar-success').css('width', '100%');
                    }
                    else if(typeof(response)=='object' && response.message!=undefined){

                        errorOccurred(response.message);
                    }
                    else{

                        errorOccurred('Unknown error occurred!');
                    }
                });
            }
        },
        '_sendErrorBack': function(){

            $('#modal_sendmail_send').remove();
            $('#modal_sendmail').show();
        },
        'accountInfo': function(accId, route){

            $('<div id="modal_account_info" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Account details #'+accId+'</h3></div><div class="modal-body">Loading, please wait...</div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal({
                'remote': route+'info/?acc_id='+accId
            }).on('hidden.bs.modal', function(){

                $('#modal_account_info').remove();
            });
        },
        'signInAs': function(accId, route, confirmMessage){

            $('<div id="modal_delete_account" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Please confirm</h3></div><div class="modal-body"><p>'+confirmMessage+'</p></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$.joodeeAccountManager._login('+accId+', \''+route+'\')">Confirm</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_delete_account').remove();
            });

            return false;
        },
        '_login': function(accId, route){

            $(window.location).attr('href', route+'login/'+accId+'/');
        },
        'changeRole': function(accId, route, confirmMessage, currentRole){

            $('<div id="modal_change_role" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h5>'+confirmMessage+'</h5></div><div class="modal-body"><p><form class="form-horizontal"><div class="form-group"><label class="col-xs-3 control-label">Select role:</label><div class="col-xs-6"><select id="account_new_role" name="role" class="form-control"></select></div></div></form></p></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button class="btn btn-danger" onclick="$.joodeeAccountManager._change('+accId+', \''+route+'\', jQuery(\'#account_new_role\').val());">Change role!</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_change_role').remove();
            });

            $.each(roleList, function(key, item){

                $('#account_new_role').append($('<option></option>').attr('value', key).attr('selected', key==currentRole?true:false).text(item.name));
            });

            return false;
        },
        '_change': function(accId, route, newRole){

            $('#modal_change_role').modal('hide').remove();

            $('<div id="modal_change_role" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-request-status">Sending request</h3></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar" style="width: 10%;"></div></div></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_change_role').remove();
            });

            $('#modal_change_role .progress .progress-bar').css('width', '50%');

            $.post(route+'role/', {acc_id:accId, new_role:newRole}, function(response){

                var errorOccurred = function(message){

                    $('#modal_change_role .modal-request-status').html(message).addClass('text-danger');
                    $('#modal_change_role .progress .progress-bar').addClass('progress-bar-danger').css('width', '100%');
                }

                if(typeof(response)=='object' && response.success!=undefined && response.success===true){

                    $('#modal_change_role .modal-request-status').html(response.message).addClass('text-success');
                    $('#modal_change_role .progress .progress-bar').addClass('progress-bar-success').css('width', '100%');
                    jQuery('#role_'+accId).attr('rel', newRole).text(roleList[newRole].name);
                }
                else if(typeof(response)=='object' && response.message!=undefined){

                    errorOccurred(response.message);
                }
                else{

                    errorOccurred('Unknown error occurred!');
                }
            });
        },
        'lockAccount': function(accId, route, confirmMessage){

            $('<div id="modal_lock_account" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Please confirm</h3></div><div class="modal-body"><p>'+confirmMessage+'</p></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$.joodeeAccountManager._lock('+accId+', \''+route+'\');">Confirm</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_lock_account').remove();
            });

            return false;
        },
        '_lock': function(accId, route){

            $('#modal_lock_account').modal('hide').remove();

            $('<div id="modal_lock_account" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-request-status">Sending request</h3></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar" style="width: 10%;"></div></div></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_lock_account').remove();
            });

            $('#modal_lock_account .progress .progress-bar').css('width', '50%');

            $.post(route+'lock/', {acc_id:accId}, function(response){

                var errorOccurred = function(message){

                    $('#modal_lock_account .modal-request-status').html(message).addClass('text-danger');
                    $('#modal_lock_account .progress .progress-bar').addClass('progress-bar-danger').css('width', '100%');
                }

                if(typeof(response)=='object' && response.success!=undefined && response.success===true){

                    $('#modal_lock_account .modal-request-status').html(response.message).addClass('text-success');
                    $('#modal_lock_account .progress .progress-bar').addClass('progress-bar-success').css('width', '100%');

                    if(response.locked!=undefined && response.locked=='Yes'){

                        jQuery('#lock_'+accId).removeClass('btn-warning').addClass('btn-default').find('i').removeClass('glyphicon-ban-circle').addClass('glyphicon-lock');
                    }
                    else{

                        jQuery('#lock_'+accId).removeClass('btn-default').addClass('btn-warning').find('i').removeClass('glyphicon-lock').addClass('glyphicon-ban-circle');
                    }
                }
                else if(typeof(response)=='object' && response.message!=undefined){

                    errorOccurred(response.message);
                }
                else{

                    errorOccurred('Unknown error occurred!');
                }
            });
        },
        'deleteAccount': function(accId, route, confirmMessage){

            $('<div id="modal_delete_account" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Please confirm</h3></div><div class="modal-body"><p>'+confirmMessage+'</p></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button class="btn btn-danger" onclick="$.joodeeAccountManager._delete('+accId+', \''+route+'\')">Confirm</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_delete_account').remove();
            });

            return false;
        },
        '_delete':function(accId, route){

            $('#modal_delete_account').modal('hide').remove();

            $('<div id="modal_delete_account" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-request-status">Sending request</h3></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar" style="width: 10%;"></div></div></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button></div></div></div></div>').modal().on('hidden.bs.modal', function(){

                $('#modal_delete_account').remove();
            });

            $('#modal_delete_account .progress .progress-bar').css('width', '50%');

            $.post(route+'delete/', {acc_id:accId}, function(response){

                var errorOccurred = function(message){

                    $('#modal_delete_account .modal-request-status').html(message).addClass('text-danger');
                    $('#modal_delete_account .progress .progress-bar').addClass('progress-bar-danger').css('width', '100%');
                }

                if(typeof(response)=='object' && response.success!=undefined && response.success===true){

                    if(response.message==undefined){

                        response.message = 'Successfully deleted!';
                    }

                    $('#modal_delete_account .modal-request-status').html(response.message).addClass('text-success');
                    $('#modal_delete_account .progress .progress-bar').addClass('progress-bar-success').css('width', '100%');
                    $('#account_'+accId).remove();
                }
                else if(typeof(response)=='object' && response.message!=undefined){

                    errorOccurred(response.message);
                }
                else{

                    errorOccurred('Unknown error occurred!');
                }
            });
        }
    }
}(jQuery));
