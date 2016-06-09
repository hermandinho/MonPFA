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
                var message = payload.msg.msg;
                //console.log("SEND ", payload.msg);
                var html = "<div class='bubble you'>" + message + "</div>";
                $('.chat[data-chat=person0]').append(html);
                $('.active-chat').scrollTop(1E10);
            }
        });

        window.CHAT_MEMBERS.map(function (id) {
            var path = "";
            if(userId < id){
                path = "project/" + projectId + "/private_chat/" + userId + "/" + id;
            }else{
                path = "project/" + projectId + "/private_chat/" + id + "/" + userId;
            }
           session.subscribe(path, function (uri, payload) {
               if(payload.msg.hasOwnProperty("msg")){
                   var message = payload.msg.msg;
                   var chatBox = payload.msg.chatBboxIndex;

                   var html = "<div class='bubble you'>" + message + "</div>";
                   $('.chat[data-subscribed-pattern='+ chatBox +']').append(html);
                   $('.active-chat').scrollTop(1E10);

                   var personId = $(".chat[data-subscribed-pattern='" + chatBox + "']").attr("data-box-id");
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

function sendMessage(message) {
    //var html = "<div class='bubble me'>" + message + "</div>";
    //$('.chat[data-chat=person0]').append(html);
    var html = "<div class='bubble me'>" + message + "</div>";

    if(window.ACTIVE_CHAT_ID == -1){
        window.SOCKET_SESSION.publish(subscribePath, {"msg": message, "isPrivate": false});
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
        window.SOCKET_SESSION.publish(path, {"msg": message, "date": moment().toDate(), "isPrivate": true, "chatBboxIndex": chatBox });

        $('.chat[data-subscribed-pattern='+ chatBox +']').append(html);
        $('.active-chat').scrollTop(1E10);
    }

    console.log(".person[data-chat-person='"+chatBox+"']");
    if(!$(".person[data-chat-person='"+chatBox+"']").hasClass('active')) {
        $(".person[data-id='"+window.ACTIVE_CHAT_ID+"']").addClass("new_message");
    }
    //$(".person[data-id='"+window.ACTIVE_CHAT_ID+"'] .preview").html(message);

    $.post(
        ""+chatMessagePath+"",
        {
            message: message,
            reciever: window.ACTIVE_CHAT_ID
        },
        function (data) {
            if(data.status){
                /*if(window.ACTIVE_CHAT_ID == -1){
                    window.SOCKET_SESSION.publish(subscribePath, {"msg": data.message, "isPrivate": false});
                }else{
                    var path = "";
                    if(userId < window.ACTIVE_CHAT_ID){
                        path = "project/" + projectId + "/private_chat/" + userId + "/" + window.ACTIVE_CHAT_ID;
                    }else{
                        path = "project/" + projectId + "/private_chat/" + window.ACTIVE_CHAT_ID + "/" + userId;
                    }
                    window.SOCKET_SESSION.publish(path, {"msg": data.message, "isPrivate": true, "chatBboxIndex": window.ACTIVE_CHAT_INDEX });
                }*/
            }
        }
    );
    
    resetChatField();
}

$(document).ready(function () {
    //$("html").css("overflow", "hidden");
    /*var socketHandle = setInterval(function () {
        if(window.SOCKET_SESSION == null){
            handleSockets(webSocket);
            console.log("stiil NUUL");
        }else{
            clearInterval(socketHandle);
        }
    }, 2000); */
    setTimeout(function () {
        handleSockets(window.PFA_WEB_SOCKET);
        console.log("DONE !!!");
        console.log(window.SOCKET_SESSION);
    }, 2000);
    console.log(window.SOCKET_SESSION);
    resetChatField();

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
                        $(".chat[data-subscribed-pattern*='"+userName+"']").html("<h5 class='center vertical'>Historique de conversation vide.</h5>");
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
                            html += "<div class='bubble me'>"+item.content+"</div>";
                        }else{
                            html += "<div class='bubble you'>"+item.content+"</div>";
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

    $("#send-message").click(function (e) {
        var message = $.trim($("#message").val());
        if(message.length > 0){
            sendMessage(message);
        }
    });
});

