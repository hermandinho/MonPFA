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
        laddaInstance.start();
        //console.log($(this).attr("method"), $(this).attr("action"));
        //return;
        $.ajax({
            url: "project/add", 
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                console.log(data);
                if(data.status){
                    laddaInstance.stop();
                    window.location.reload();
                    //$("#addProjectModal").modal("hide");
                }
            },
            error: function (er, err) {
                console.log(er, err)
            }
        })
    })
});