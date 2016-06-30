/**
 * Created by El-PC on 18/05/2016.
 */
$(document).ready(function () {

    $('.collapsible').collapsible({
        accordion : true // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    
    setTimeout(function () {
        console.log("Fetching ...");
        var AutocompleteUserList = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "users/list/json"/*{
                url: 'users/list/json',
                filter: function(users) {
                    return users.map(function(item){
                        return { name: item.nom+" "+item.prenom, id: item.id};
                    });
                }
            }*/
        });

        AutocompleteUserList.initialize();

        $('input#mail_receivers').materialtags({
            itemValue: 'id',
            itemText: "name",
            typeaheadjs: {
                name: 'AutocompleteUserList',
                displayKey: 'name',
                //valueKey: 'name',
                source: AutocompleteUserList.ttAdapter()
            }
        });
    }, 2000);

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