/**
 * Created by El-PC on 05/06/2016.
 */
function resetChatField() {
    $("#message").val("");
    $("#send-message").prop("disabled", true);
}

window.SOCKET_SESSION = null;

function handleSockets(socket) {

    socket.on("socket/connect", function (session) {
        window.SOCKET_SESSION = session;
        //session is an Autobahn JS WAMP session.
        session.call("rpctest/subscribe_func", {"term1": 2, "term2": 5}).then(
            function(result)
            {
                console.log("RPC Valid!", result);
            },
            function(error, desc)
            {
                console.log("RPC Error", error, desc);
            }
        );

        var path = "project/" + projectId + "/chat";
        session.subscribe(path, function(uri, payload){
            //console.log("Received message", payload.msg);
            if (payload.type == "message"){
                //var data = $.parseJSON(payload.msg.msg);
                var message = parseMessage( payload.msg.msg);
                //console.log("SEND ", payload.msg);
                var html = "<div class='row'> <div class='col m1 s1'>";
                html += " <img src='/MonPFA/web/images/profile/"+payload.msg.senderImage+"' alt='' width='40' class='pull-left tooltipped' />";
                html += "<small>" + payload.msg.senderName + "</small>";
                html += "</div><div class='col m10 s10'><div class='bubble you'>" + message + "</div></div></div>";

                if($('.chat[data-chat=person0]').find(".chat-history-empty").length > 0) {
                    $('.chat[data-chat=person0]').find(".chat-history-empty").remove();
                }
                $(".preview[data-last-message=group]").html(message);
                $(".person[data-id='-1']").find(".time").html(moment().format("MMMM Do YYYY", payload.msg.date) + "<br>" + moment().format("h:mm" ,payload.msg.date));
                $('.chat[data-chat=person0]').append(html);
                $('.active-chat').scrollTop(1E10);

                if(window.ACTIVE_CHAT_ID != -1){
                    $(".person[data-id='-1']").addClass("new_message");
                }
            }
        });

        window.CHAT_MEMBERS.map(function (id) {
            var path = "";
            if(userId < id){
                path = "project/" + projectId + "/private_chat/" + userId + "/" + id;
            }else{
                path = "project/" + projectId + "/private_chat/" + id + "/" + userId;
            }
            //console.log(path);
           session.subscribe(path, function (uri, payload) {
               //console.log(payload.msg);
               if(payload.msg.hasOwnProperty("msg")){
                   var message = parseMessage( payload.msg.msg);
                   var chatBox = payload.msg.chatBboxIndex;
                   var html = "<div class='row'> <div class='col m1 s1'>";

                   if($('.chat[data-subscribed-pattern='+ chatBox +']').find(".chat-history-empty").length > 0) {
                       $('.chat[data-subscribed-pattern='+ chatBox +']').find(".chat-history-empty").remove();
                   }

                   html += " <img src='/MonPFA/web/images/profile/"+payload.msg.senderImage+"' alt='' width='40' class='pull-left tooltipped' />";
                   html += "<small>" + payload.msg.senderName + "</small>";
                   html += "</div><div class='col m10 s10'><div class='bubble you'>" + message + "</div></div></div>";
                   $('.chat[data-subscribed-pattern='+ chatBox +']').append(html);
                   $('.active-chat').scrollTop(1E10);

                   var personId = $(".chat[data-subscribed-pattern='" + chatBox + "']").attr("data-box-id");
                   $(".person[data-id='"+personId+"']").find(".time").html(moment().format("MMMM Do YYYY", payload.msg.date) + "<br>" + moment().format("h:mm" ,payload.msg.date));
                   //alert(personId+ "" +window.ACTIVE_CHAT_ID+""+chatBox);
                   if(window.ACTIVE_CHAT_ID != personId){
                       $(".person[data-id='"+personId+"']").addClass("new_message");
                   }

                   $(".preview[data-last-message='" + chatBox + "']").html(message);
               }
           });
        });

        console.log("Successfully Connected to Chat Room!");
    });
}

/*function appendNewMessage(data) {
    var html = "";
    data = $.parseJSON(data);
    console.log(data);
    if(data.sender.id == userId){
        html = "<div class='row'>"+
                    "<div class='col m12 chat-message-row'>"+
                        "<p class='triangle-right right'>" + data.content + "</p>"+

                        "<span class='message-time-right right'>" + moment(data.date).fromNow() + "</span>"+
                    "</div>"+
                "</div>";
    } else{
        html = "<div class='row'>"+
                    "<div class='col m12 chat-message-row'>"+
                        "<i class='material-icons circle left chat-message-icon'>folder</i>"+
                        "<span class='chat-user-name'>"+data.sender.nom+"</span>"+
                        "<p class='triangle-right left'>" + data.content + "</p>"+

                        "<span class='message-time-right right'>" + moment(data.date).fromNow() + "</span>"+
                    "</div>"+
                "</div>";
    }

    $(".chat-messages-box").append(html);
} */

function parseMessage(message) {
    var finalMessage = message;
    finalMessage = finalMessage.replace(":T", smilies.THUG_LIFE + " ")
                                .replace(";)", smilies.FACE_WINK + " ")
                                .replace("(Y)", smilies.GOOD + " ")
                                .replace(":P", smilies.LANGUE + " ")
                                .replace(":M", smilies.ME + " ")
                                .replace(":O", smilies.OUPS + " ")
                                .replace(":D", smilies.LAUGH + " ")
    ;

    return finalMessage;
}

function sendMessage(message) {

    var html = "<div class='row'><div class='col m12 s12'><div class='bubble me'>" + parseMessage(message) + "</div></div></div>";

    if(window.ACTIVE_CHAT_ID == -1){
        if($('.chat[data-chat=person0]').find(".chat-history-empty").length > 0) {
            $('.chat[data-chat=person0]').find(".chat-history-empty").remove();
        }
        $(".preview[data-last-message=group]").html( parseMessage(message));
        $(".person[data-id='-1']").find(".time").html(moment().format("MMMM Do YYYY", moment().toDate()) + "<br>" + moment().format("h:mm", moment().toDate()));
        window.SOCKET_SESSION.publish(subscribePath, {"msg": message, "isPrivate": false, senderName: senderCompleteName, senderImage: senderImage, date: moment().toDate()});
        $('.chat[data-chat=person0]').append(html);
        $('.active-chat').scrollTop(1E10);
    }else{
        var path = "",
            chatBox = window.ACTIVE_CHAT_USERNAME;
        if(userId < window.ACTIVE_CHAT_ID){
            path = "project/" + projectId + "/private_chat/" + userId + "/" + window.ACTIVE_CHAT_ID;
            chatBox = userName + "-" + window.ACTIVE_CHAT_USERNAME;
        }else{
            chatBox = window.ACTIVE_CHAT_USERNAME + "-" + userName;
            path = "project/" + projectId + "/private_chat/" + window.ACTIVE_CHAT_ID + "/" + userId;
        }
        window.SOCKET_SESSION.publish(path, {"msg": message, date: moment().toDate(), "isPrivate": true, "chatBboxIndex": chatBox, senderName: senderCompleteName, senderImage: senderImage });

        if($('.chat[data-subscribed-pattern='+ chatBox +']').find(".chat-history-empty").length > 0) {
           $('.chat[data-subscribed-pattern='+ chatBox +']').find(".chat-history-empty").remove();
        }

        $(".person[data-id='" + window.ACTIVE_CHAT_ID + "']").find(".time").html(moment().format("MMMM Do YYYY", moment().toDate()) + "<br>" + moment().format("h:mm", moment().toDate()));
        $('.chat[data-subscribed-pattern='+ chatBox +']').append(html);
        $('.active-chat').scrollTop(1E10);
    }

    if(!$(".person[data-chat-person='"+chatBox+"']").hasClass('active')) {
        $(".person[data-chat-person='"+chatBox+"']").addClass("new_message");
    }
    $(".person[data-chat-person='"+chatBox+"'] .preview").html(message);
    $.post(
        ""+chatMessagePath+"",
        {
            message: message,
            reciever: window.ACTIVE_CHAT_ID
        },
        function (data) {
            if(data.status){
            }
        }
    );
    
    resetChatField();
}

$(document).ready(function () {
    //$("html").css("overflow", "hidden");
    handleSockets(window.PFA_WEB_SOCKET);
    resetChatField();

    $(".smille").click(function (e) {
        $("#message").val($("#message").val() + " " + $(this).attr("data-code") + " ").focus();
    });

    $('.chat[data-chat=person0]').addClass('active-chat');
    $('.person[data-chat=person0]').addClass('active');
    $('.active-chat').scrollTop(1E10);

    $('.left .person').mousedown(function(){
        window.ACTIVE_CHAT_ID = $(this).attr("data-id");
        window.ACTIVE_CHAT_INDEX = $(this).attr("data-chat-index");
        window.ACTIVE_CHAT_USERNAME = $(this).attr("data-username");
        $(this).removeClass("new_message");
        var chatHistoryFetched = $(this).attr('data-fetched');
        if(chatHistoryFetched == 0){
            $(".chat[data-subscribed-pattern*='"+userName+"']").html("<h5 class='center vertical'>Chargement des conversations en cours ...</h5>");
            $.get(
                ""+privateChatPath.replace("XXX",window.ACTIVE_CHAT_ID) + "",
                {},
                function (data) {
                    $(this).attr("data-fetched", 1);
                    $(".chat[data-subscribed-pattern*='"+userName+"']").attr("data-fetched", 1);
                    var html = "";

                    if(data.length == 0){
                        $(".chat[data-subscribed-pattern*='"+userName+"']").html("<h5 class='center vertical chat-history-empty'>Historique de conversation vide.</h5>");
                        return;
                    }

                    var dates = [];
                    data.map(function(item){
                        var date = moment(item.date).format("D MMM Y");
                        if(dates.indexOf(date) == -1){
                            dates.push(date);
                            html += "<div class='conversation-start'><span>" + date +  "</span></div>";
                        }

                        if(item.sender.id == userId){
                            html += "<div class='row'><div class='col m12 s12'><div class='bubble me'>"+item.content+"</div></div></div>";
                        }else{
                            html += "<div class='row'> <div class='col m1 s1'>";
                            html += " <img src='/MonPFA/web/images/profile/"+item.sender.image_name+"' alt='' width='40' class='pull-left tooltipped' />";
                            html += "<small>" + item.sender.nom + "</small>";
                            html += "</div><div class='col m10 s10'><div class='bubble you'>"+item.content+"</div></div></div>";
                        }
                    });
                    $(".chat[data-subscribed-pattern*='"+userName+"']").html(html);
                    $('.active-chat').scrollTop(1E10);
                }
            );
        }
        $(this).attr('data-fetched', 1);


        if ($(this).hasClass('.active')) {
            $('.active-chat').scrollTop(1E10);
            return false;
        } else {
            var findChat = $(this).attr('data-chat');
            var personName = $(this).find('.name').text();
            $('.right .top .name').html(personName);
            $('.chat').removeClass('active-chat');
            $('.left .person').removeClass('active');
            $(this).addClass('active');
            $('.chat[data-chat = '+findChat+']').addClass('active-chat');
            $('.active-chat').scrollTop(1E10);
        }
    });



    $("#message").keyup(function (e) {
        var message = $.trim($(this).val());
        if(message.length > 0){
            //$("#send-message").prop("disabled", false);
            if(e.keyCode == 13){
                sendMessage(message);
            }
        }else{
            //$("#send-message").prop("disabled", true);
        }
    });

    $("#send-message-btn").click(function (e) {
        var message = $.trim($("#message").val());
        if(message.length > 0){
            sendMessage(message);
        }
    });
});

