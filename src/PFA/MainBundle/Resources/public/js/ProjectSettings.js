/**
 * Created by El-PC on 04/06/2016.
 */
$(document).ready(function () {
    // Initialise Materialize Tabs
    $('ul.tabs').tabs();

    // Initialise Materialize Selects
    $('select').material_select();

    $(".project-setting-form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector('#btn-save-project-settings'));
        laddaInstance.start();

        $.ajax({
            url: saveSettingPath,
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                console.log(data);
                if(data.status){
                    laddaInstance.stop();
                    $(".status-message").html("Paramètres du Projet Enregistrés avec success !!!");
                    $(".settings-update-status").removeClass("hide");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                    //$("#addProjectModal").modal("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    });

    $(".project-setting-add-member-form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector('.add-project-member-btn'));
        laddaInstance.start();

        $.ajax({
            url: saveSettingPath,
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if(data.status){
                    laddaInstance.stop();
                    $(".status-message").html("Un Membre ajouter avec success !!!");
                    $(".status-message").removeClass("red").addClass("teal");
                    $(".settings-update-status").removeClass("hide");
                    $("input[name='form[member]']").val("");
                    setTimeout(function () {
                        //window.location.reload();
                    }, 1000);
                }else{
                    laddaInstance.stop();
                    $(".status-message").html(data.msg);
                    $(".status-message").removeClass("teal").addClass("red");
                    $(".settings-update-status").removeClass("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    });
});