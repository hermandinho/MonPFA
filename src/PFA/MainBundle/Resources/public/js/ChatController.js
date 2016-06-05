/**
 * Created by El-PC on 05/06/2016.
 */
function resetChatField() {
    $("#message").val("");
    $("#send-message").prop("disabled", true);
}

//window.SOCKET_SESSION = null;

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
            console.log("Received message", payload.msg);
            if (payload.type == "message"){
                //$(".chat-messages-box").append("<div class='row'>NEW MESSAGE ARRIVED</div>");
                appendNewMessage(payload.msg.msg);
            }

        });

        console.log("Successfully Connected to Chat Room!");
    });
}

function appendNewMessage(data) {
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
}

function sendMessage(message) {
    $.post(
        ""+chatMessagePath+"",
        {
            message: message
        },
        function (data) {
            if(data.status){
                //console.log(data);
                window.SOCKET_SESSION.publish(subscribePath, {"msg": data.message});
            }
        }
    );
    
    resetChatField();
}

$(document).ready(function () {
    handleSockets(webSocket);
    resetChatField();

    $("#message").keyup(function (e) {
        var message = $.trim($(this).val());
        if(message.length > 0){
            $("#send-message").prop("disabled", false);

            if(e.keyCode == 13){
                sendMessage(message);
            }
        }else{
            $("#send-message").prop("disabled", true);
        }
    });

    $("#send-message").click(function (e) {
        var message = $.trim($("#message").val());
        if(message.length > 0){
            sendMessage(message);
        }
    });

    GLOBAL_JS.DATE_TO_RENDER_IN_MOMENT.map(function (item) {
        var time = moment(item.date).fromNow();
        $("#"+item.blockId).html(time);
    });
});

