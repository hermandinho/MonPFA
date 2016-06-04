/**
 * Created by El-PC on 04/06/2016.
 */
function resetProjectMembersList() {
    $.get(
        ""+$("#project-members-list").attr("data-path")+"",
        {},
        function (data) {
            $('#project-members-list').html(data);
        }
    );
}
$(document).ready(function () {
    // Initialise Materialize Tabs
    $('ul.tabs').tabs();

    // Initialise Materialize Selects
    $('select').material_select();


    resetProjectMembersList();

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
                        //window.location.reload();
                    }, 2000);
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
                    }, 2000);

                    resetProjectMembersList();
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

    $("body").on("click",".delete-member",function (e) {
        if(!confirm("Voullez vous vraiment retirer ce membre du Projet ?")){
            e.preventDefault();
            return;
        }

        $.ajax({
            url: $(this).attr("data-path"),
            cache: false,
            processData: false,
            contentType: false,
            type: 'GET',
            success: function (data) {
                if(data.status){
                    console.log($(e).closest("li"), $(e));
                    $(this).closest("li").remove();
                    $(".status-message").html("Un membre rétirer avec success !!!");
                    $(".status-message").removeClass("red").addClass("teal");
                    $(".settings-update-status").removeClass("hide");
                    resetProjectMembersList();
                }
            }
        })
    });
});