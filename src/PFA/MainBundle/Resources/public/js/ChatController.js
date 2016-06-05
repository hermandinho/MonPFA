/**
 * Created by El-PC on 05/06/2016.
 */
function resetChatField() {
    $("#message").val("");
    $("#send-message").prop("disabled", true);
}

function handleSockets(socket) {
    socket.on("socket/connect", function (session) {
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
            console.log(payload.subscribed);
            /*payload.subscribed.map(function (subscriber) {
             console.log(subscriber);
             }); */
        });

        console.log("Successfully Connected to Chat Room!");
    });
}

function sendMessage(message, socket) {
    $.post(
        ""+chatMessagePath+"",
        {
            message: message
        },
        function (data) {
            if(data.status){
                console.log(data)
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
                sendMessage(message, webSocket);
            }
        }else{
            $("#send-message").prop("disabled", true);
        }
    });

    $("#send-message").click(function (e) {
        var message = $.trim($("#message").val());
        if(message.length > 0){
            sendMessage(message,webSocket);
        }
    });
});

