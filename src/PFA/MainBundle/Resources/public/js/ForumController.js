/**
 * Created by El-PC on 19/06/2016.
 */

$(document).ready(function () {
    $(".add-subject-form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector('#post-forum-subject'));

        var formData = new FormData(this);
        
        laddaInstance.start();

        $.ajax({
            url: addSubjectPath,
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                //console.log(data);
                if(data.status){
                    laddaInstance.stop();
                    $(".status-message").html("<h4 class='center'>Suject Ajouté avec success.</h4>").removeClass("hide");
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                    //$("#addProjectModal").modal("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    });

    $(".add-subject-answer-form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector('#post-forum-subject-answer'));

        var formData = new FormData(this);

        laddaInstance.start();

        $.ajax({
            url: addSubjectAnswerPath,
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                //console.log(data);
                if(data.status){
                    laddaInstance.stop();
                    $(".status-message").html("<h4 class='center'>Réponse Ajouté avec success.</h4>").removeClass("hide");
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                    //$("#addProjectModal").modal("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    });

    $(".subject-solved").click(function (e) {
        e.preventDefault();
        $(this).prop("disabled", true);
        $(this).html("En cours ...");
        $.post(
            "" + markSolvedPath.replace("III", $(this).data('id') )+"",
            {},
            function (data) {
                if(data.status) {
                    $(this).prop("disabled", false);
                    $(this).html("Marquer comme Résolu");
                    window.location.reload();
                }
            }
        )
    });
});