/**
Core script to handle the entire theme and core functions
**/
var QuickSidebar = function () {

    // Handles quick sidebar toggler
    var handleQuickSidebarToggler = function () {
        // quick sidebar toggler
        $('.dropdown-quick-sidebar-toggler a, .page-quick-sidebar-toggler, .quick-sidebar-toggler').click(function (e) {
            $('body').toggleClass('page-quick-sidebar-open'); 
        });
    };

    // Handles quick sidebar chats
    var handleQuickSidebarChat = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperChat = wrapper.find('.page-quick-sidebar-chat');

        var initChatSlimScroll = function () {
            var chatUsers = wrapper.find('.page-quick-sidebar-chat-users');
            var chatUsersHeight;

            chatUsersHeight = wrapper.height() - wrapper.find('.nav-tabs').outerHeight(true);

            // chat user list 
            //App.destroySlimScroll(chatUsers);
            chatUsers.attr("data-height", chatUsersHeight);
            //App.initSlimScroll(chatUsers);

            var chatMessages = wrapperChat.find('.page-quick-sidebar-chat-user-messages');
            var chatMessagesHeight = chatUsersHeight - wrapperChat.find('.page-quick-sidebar-chat-user-form').outerHeight(true);
            chatMessagesHeight = chatMessagesHeight - 20 - wrapperChat.find('.page-quick-sidebar-nav').outerHeight(true);

            // user chat messages 
            App.destroySlimScroll(chatMessages);
            chatMessages.attr("data-height", chatMessagesHeight);
            App.initSlimScroll(chatMessages);
        };

        initChatSlimScroll();
        App.addResizeHandler(initChatSlimScroll); // reinitialize on window resize

        // wrapper.find('.page-quick-sidebar-chat-users .media-list > .media').click(function () {
        //     wrapperChat.addClass("page-quick-sidebar-content-item-shown");
        // });

        wrapper.find('.page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list').click(function () {
            wrapperChat.removeClass("page-quick-sidebar-content-item-shown");
        });

        var handleChatMessagePost = function (e) {
            e.preventDefault();

            var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
            var input = wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control');

            var text = input.val();
            if (text.length === 0) {
                return;
            }

            var preparePost = function(dir, time, name, avatar, message) {
                var tpl = '';
                tpl += '<div class="post '+ dir +'">';
                tpl += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + avatar +'.jpg"/>';
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">Bob Nilson</a>&nbsp;';
                tpl += '<span class="datetime">' + time + '</span>';
                tpl += '<span class="body">';
                tpl += message;
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</div>';

                return tpl;
            };

            // handle post
            var time = new Date();
            var message = preparePost('out', (time.getHours() + ':' + time.getMinutes()), "Bob Nilson", 'avatar3', text);
            message = $(message);
            chatContainer.append(message);

            chatContainer.slimScroll({
                scrollTo: '1000000px'
            });

            input.val("");

            // simulate reply
            setTimeout(function(){
                var time = new Date();
                var message = preparePost('in', (time.getHours() + ':' + time.getMinutes()), "Ella Wong", 'avatar2', 'Lorem ipsum doloriam nibh...');
                message = $(message);
                chatContainer.append(message);

                chatContainer.slimScroll({
                    scrollTo: '1000000px'
                });
            }, 3000);
        };

        // wrapperChat.find('#accountbtn').click(handleChatMessagePost);
        // wrapperChat.find('#searchaccount').keypress(function (e) {
        //     if (e.which == 13) {
        //         handleChatMessagePost(e);
        //         return false;
        //     }
        // });
    };

    // Handles Search Account
    var handleQuickSidebarAlerts = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperAlerts = wrapper.find('.page-quick-sidebar-alerts');
        

        var initAlertsSlimScroll = function () {
            var alertList = wrapper.find('.page-quick-sidebar-alerts-list');
            var alertListHeight;

            alertListHeight = wrapper.height() - wrapper.find('.nav-tabs').outerHeight();
            alertListHeight = alertListHeight - 80 -  wrapperAlerts.find('.page-quick-sidebar-search-form').outerHeight() ;

            // alerts list 
            App.destroySlimScroll(alertList);
            alertList.attr("data-height", alertListHeight);
            App.initSlimScroll(alertList);

            // var chatMessages = wrapperAlerts.find('.list-items');
            // var chatMessagesHeight = alertListHeight - wrapperAlerts.find('.page-quick-sidebar-search-form').outerHeight(true);
           // chatMessagesHeight = chatMessagesHeight - wrapperAlerts.find('.page-quick-sidebar-nav').outerHeight(true);

            //user chat messages 
            // App.destroySlimScroll(chatMessages);
            // chatMessages.attr("data-height", chatMessagesHeight);
            // App.initSlimScroll(chatMessages);
        };

        initAlertsSlimScroll();
        App.addResizeHandler(initAlertsSlimScroll); // reinitialize on window resize
        var input = wrapperAlerts.find('.page-quick-sidebar-search-form .form-control');

        var handleSearchingAccount = function (e) {
            if (! e==null) e.preventDefault();
            var accountContainer = wrapperAlerts.find(".page-quick-sidebar-alerts-list .list-items");
            var alertList = wrapperAlerts.find('.page-quick-sidebar-alerts-list');
            

            var text = input.val();
            // if (text.length === 0) {
            //     return;
            // }

            var preparePost = function(message) {
                var options;
                $.ajax({
                    type: "post",
                    //dataType: 'html',
                    url: siteurl+'Accounting/perkiraan/get_SearchAccount',
                   // cache: true,
                    data: {search: message},
                    error: function (xhr, error, thrown) {
                                //var htoastr = new myToastr(xhr['responseText'], "<h2>Error</h2> <hr>")
                                //htoastr.toastrError()
                                console.log('error :',xhr['responseText']);
                            },
                    success: function(response) {
                        //options =  'response';
                        //console.log('sukses: ',response);
                        accountContainer.html(response);
                        dragdrop();
                        //return options;
                    }
                })
            };

            // handle post
            preparePost(text);
            //var message = preparePost(text);
            //message = $(message);
            //console.log(message);
            //accountContainer.append(message);

             alertList.slimScroll({
                 scrollTo: '1000000px'
             });

            //initAlertsSlimScroll();
            //App.addResizeHandler(initAlertsSlimScroll); // reinitialize on window resize

            input.val("");
        };

        handleSearchingAccount();
        wrapperAlerts.find('#accountbtn').click(handleSearchingAccount);
        wrapperAlerts.find('#searchaccount').keypress(function (e) {
            if (e.which == 13) {
                handleSearchingAccount(e);
                return false;
            }
        });

        function dragdrop() {
            var dragitem = wrapperAlerts.find('.list-items li');
            dragitem.disableSelection();
            dragitem.draggable({
                cursor: 'move',
                //helper: 'clone',
                //opacity: 0.7,
                //containment: 'window',
                appendTo: 'body',
               // revert: 'invalid',
                helper: function( event ) {
                    return $( "<div> <a class='label label-info'>"+$(this).find('span').html()+" </a> <span class='fa fa-arrow-right font-red'></span> <a class='label label-success'> "+$(this).find('.desc').html()+" </a> </div>" );
                }
                //start: function(e) {
                //     $(this).data('desc', $(this).find('.desc').text());
                //    // $(this).data('desc', $(this).find('.desc'));
                // }
            });
            // $( ".portlet-body" ).droppable({
            //   drop: function( event, ui ) {
            //     //var $element = $(ui.draggable); //$(event.toElement); // equivalent to $(ui.helper);
            //     //var id = $element.data('value');
            //     var item = $(ui.draggable).data('value');
            //     //var itemdesc = $(ui.draggable).data('desc');
            //     console.log('data : ',item.rekid+' - '+item.accountno);
            //     $( this )
            //       //.addClass( "ui-state-highlight" )
            //       //.find( "p" )
            //         .append('<div class="bold font-green margin-bottom-10"> <span class="label label-sm label-danger">'+item.accountno+'</span>'+item.description+'</div>' );
            //   }
            // });
        }
        
    };

    // Handles Custom Search
    var handleCustomSearch = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperAlerts = $('#quick_sidebar_tab_3');
        

        var initAlertsSlimScroll = function () {
            var alertList = wrapperAlerts.find('.page-quick-sidebar-alerts-list');
            var alertListHeight;

            alertListHeight = wrapper.height() - wrapper.find('.nav-tabs').outerHeight();
            alertListHeight = alertListHeight - 80 -  wrapperAlerts.find('.page-quick-sidebar-search-form').outerHeight() ;

            // alerts list 
            App.destroySlimScroll(alertList);
            alertList.attr("data-height", alertListHeight);
            App.initSlimScroll(alertList);
        };

        initAlertsSlimScroll();
        App.addResizeHandler(initAlertsSlimScroll); // reinitialize on window resize
        

        var handleCustomSearching = function (e) {
            var input = wrapperAlerts.find('#searchcustom');
            if (! e==null) e.preventDefault();
            var accountContainer = wrapperAlerts.find(".page-quick-sidebar-alerts-list .list-custom");
            var alertList = wrapperAlerts.find('.page-quick-sidebar-alerts-list');
            var selectedID = wrapperAlerts.find('select[name=source]').selectpicker('val');
            var arrfunc = ["get_kontrak","get_kontrak","get_kwitansi","get_journal","get_inventory","get_kasbank","get_perkiraanKB",'get_perkiraan'];

            var text = input.val();

            //console.log($('#searchcustom').val());

            // if (text.length === 0) {
            //     return;
            // }

            var preparePost = function(message) {
                
                var options;
                $.ajax({
                    type: "post",
                    url: siteurl+'Dashboard/'+arrfunc[selectedID],
                    data: {search: message},
                    error: function (xhr, error, thrown) {
                                console.log('error :',xhr.responseText);
                            },
                    success: function(response) {
                        accountContainer.html(response);
                        dragdrop();
                    }
                });
            };

            // handle post
            preparePost(text);
            alertList.slimScroll({
             scrollTo: '1000000px'
            });

            input.val("");
        };

        handleCustomSearching();
        
        wrapperAlerts.on('changed.bs.select','#source',function(e, clickedIndex, newValue, oldValue) {
            handleCustomSearching(e);
        });
        wrapperAlerts.find('#searchbtn').click(handleCustomSearching);
        wrapperAlerts.find('#searchcustom').keypress(function (e) {
            if (e.which == 13) {
                handleCustomSearching(e);
                return false;
            }
        });

        function dragdrop() {
            var dragitem = wrapperAlerts.find('.list-custom li');
            dragitem.disableSelection();
            dragitem.draggable({
                cursor: 'move',
                appendTo: 'body',
                helper: function( event ) {
                    return $( "<div> <a class='label label-info'>"+$(this).find('span').html()+" </a> <span class='fa fa-arrow-right font-red'></span> <a class='label label-success'> "+$(this).find('.desc').html()+" </a> </div>" );
                }
            });
        }
        
    };

    // Handles quick sidebar settings
    var handleQuickSidebarSettings = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperAlerts = wrapper.find('.page-quick-sidebar-settings');

        var initSettingsSlimScroll = function () {
            var settingsList = wrapper.find('.page-quick-sidebar-settings-list');
            var settingsListHeight;

            settingsListHeight = wrapper.height() - wrapper.find('.nav-justified > .nav-tabs').outerHeight();

            // alerts list 
            App.destroySlimScroll(settingsList);
            settingsList.attr("data-height", settingsListHeight);
            App.initSlimScroll(settingsList);
        };

        initSettingsSlimScroll();
        App.addResizeHandler(initSettingsSlimScroll); // reinitialize on window resize
    };

    return {

        init: function () {
            //layout handlers
            handleQuickSidebarToggler(); // handles quick sidebar's toggler
            //handleQuickSidebarChat(); // handles quick sidebar's chats
            handleQuickSidebarAlerts(); // handles quick sidebar's alerts
            handleCustomSearch();
            //handleQuickSidebarSettings(); // handles quick sidebar's setting
        }
    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {    
       QuickSidebar.init(); // init metronic core componets
    });
}