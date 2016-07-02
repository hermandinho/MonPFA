/**
 * Created by El-PC on 18/05/2016.
 */
$(document).ready(function () {

    $('.collapsible').collapsible({
        accordion : true // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    $('select').material_select(); // render selects

    $(".select-wrapper").find(".caret").remove();
    $(".select-wrapper").find(".select-dropdown").hide();

    $("#recievers").select2({
        ajax: {
            url: "users/list/json",
            dataType: 'json',
            delay: 25,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                var results = data.map(function (user) {
                   return { id: user.id, text: user.nom + " " + user.prenom } ;
                });
                //console.log(results);
                return {
                    //results: data.items,
                    results: results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        tags: true,
        placeholder: "Select a state"
    });

    Materialize.updateTextFields();

    $(".create_mail_folder_Form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#create_mail_folder'));
        var formData = new FormData(this);

        laddaInstance.start();
        $.ajax({
            url: "create_folder",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if(!data.status){
                    $("#create-folder-modal-zone").prepend("<div id='create-folder-error' class=' red card'> " + data.msg + " </div>");
                    setTimeout(function () {
                        $("#create-folder-error").fadeOut(1000).remove();
                    }, 2000);
                } else {
                    $("#create-folder-modal-zone").prepend("<div id='create-folder-error' class=' teal card'> " + data.msg + " </div>");
                    setTimeout(function () {
                        $("#create-folder-error").fadeOut(1000).remove();
                        $('#modal1').closeModal();
                        window.location.reload();
                    }, 2000);
                }

                laddaInstance.stop();
            }
        })
    })
});