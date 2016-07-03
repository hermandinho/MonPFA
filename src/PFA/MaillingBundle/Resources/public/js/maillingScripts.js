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
                    console.log(user);
                   return { id: user.id, text: "<img alt='IMG' src='/MonPFA/web/images/profile/" + user.image_name + "' width='25' class='circle' /> " + user.nom + " " + user.prenom } ;
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
        placeholder: "Select a state",
        escapeMarkup: function (markup) { return markup; }
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
    });

    $("#add_attachement").click(function (e) {
        e.preventDefault();

        var html = `<div class="attachement_row">
                        <div class='input-field col s10'>
                            <div class='file-field input-field'>
                                <div class='btn'>
                                    <span>File</span>
                                    <input type='file' name='attachement[]'>
                                </div>
                                <div class='file-path-wrapper'>
                                    <input class='file-path validate' type='text'>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s2">
                            <a href="javascript:;" class="btn remove_attachement">
                                <i class="material-icons">delete</i>
                            </a>
                        </div>
                    </div>`;

        $("#attachements").append(html);
    });

    $("body").on("click", ".remove_attachement", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    $(".send_mail_form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#send_mail_btn'));
        var formData = new FormData(this);

        laddaInstance.start();
        $.ajax({
            url: "new_mail",
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
    });

    $("#checkall").click(function (s) {
        var $this = $(this);
        $(".select-email-row").map(function (i,e) {
            $(e).prop("checked", $this.prop("checked"));
            if($this.prop("checked")) {
                $(e).parent().parent().addClass("selected");
            } else {
                $(e).parent().parent().removeClass("selected");
            }

        });
    });

    $(".select-email-row").click(function (e) {
        if($(this).prop("checked")) {
            $(this).parent().parent().addClass("selected");
        } else {
            $(this).parent().parent().removeClass("selected");
        }
    })
});