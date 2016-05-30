/**
 * Created by El-PC on 26/05/2016.
 */
$(document).ready(function () {
   $("#addProjectBtn").click(function (e) {
        $.get(
            "project/add",
            {},
            function (form) {
                //console.log(form);
                $('#add-project-form-container').html(form);
                $("#addProjectModal").modal();
            }
        )
   });

    $("body").on("submit","form[name='project']",function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector('#btn-save-project'));
        //laddaInstance.start();

        //var formData = new FormData(document.querySelector('.addProjectForm'));
        var formData = new FormData();
        formData = $(this).serializeArray();
        console.log(formData);
        //return;

        $.ajax({
            url: "project/add", 
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                //console.log(data);
                if(data.status){
                    laddaInstance.stop();
                    $("#addProjectModal").modal("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    })
});