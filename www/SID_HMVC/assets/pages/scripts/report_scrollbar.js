/**
Core script to handle the entire theme and core functions
**/
var Reportbar = function () {


    // Handles quick sidebar chats
    // $('body').toggleClass('page-quick-sidebar-open'); 
    var handleReportbar = function () {
        var wrapper = $('.report-wrapper');
        var wrapperChat = wrapper.find('.report-body');

        var initReportScroll = function () {
            var chatUsers = wrapper.find('.report-body-wrapper');
            var chatUsersHeight;

            chatUsersHeight = wrapper.height();// - wrapper.find('.nav-tabs').outerHeight(true);
           // console.log('tinggi',chatUsersHeight);

            // chat user list 
            chatUsers.attr("data-height", chatUsersHeight);

            var chatMessages = wrapperChat.find('.report-body-content');
            var chatMessagesHeight = chatUsersHeight - wrapperChat.find('.report-body-search').outerHeight(true);
            chatMessagesHeight = chatMessagesHeight;
           // console.log(chatMessagesHeight);

            // user chat messages 
            App.destroySlimScroll(chatMessages);
            chatMessages.attr("data-height", chatMessagesHeight);
            App.initSlimScroll(chatMessages);
        };

        initReportScroll();
        App.addResizeHandler(initReportScroll); // reinitialize on window resize       
    };

    return {

        init: function () {
            //layout handlers
            handleReportbar(); // handles quick sidebar's toggler
        }
    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {    
       Reportbar.init(); // init metronic core componets
    });
}    