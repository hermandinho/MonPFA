/**
 * Created by Herman on 05/07/2016.
 */

$(document).ready(function () {
    $(".folder-select-list li a").click(function(){
        var selText = $(this).text(), $this = $(this);
        $(".folder-select-list li").removeClass("active");
        $(this).parents("li").addClass("active");

        $(this).parents('.btn-group').find('.folder-select').html('<span class="">En cours ...</span>');

        $.post(
            "" + changeFolderPath.replace("XXX", $(this).data('id')) +"",
            {},
            function (data) {
                console.log(data);
                $this.parents('.btn-group').find('.folder-select').html(selText+' <span class="caret"></span>');
                $("#folder_name").html(selText);
            }
        );
    });

    $("#add_attachement").click(function (e) {
        e.preventDefault();
        var html = `<div class="attachement_row">
                        <div class='input-field col s10'>
                            <div class='file-field input-field'>
                                <div class='btn'>
                                    <span>Sélectionner un Fichier</span>
                                    <input type='file' name='mail_answer[attachements][]'>
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


        if($(".attachement_row").length > 0) {
            $("#mail_answer_attachements").attr("name","mail_answer[attachements][]");
        } else {
            $("#mail_answer_attachements").attr("name", "mail_answer[attachements]");
        }
    });

    $("body").on("click", ".remove_attachement", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        if($(".attachement_row").length > 0) {
            $("#mail_answer_attachements").attr("name","mail_answer[attachements][]");
        } else {
            $("#mail_answer_attachements").attr("name", "mail_answer[attachements]");
        }
    });

    $("#mail_answer_attachements").attr('name', "mail_answer[attachements][]");

    $(".answer_mail_form").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#send_mail_btn'));
        var formData = new FormData(this);

        laddaInstance.start();
        $.ajax({
            url: sendAnswer,
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
});