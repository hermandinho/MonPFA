/**
 * Created by El-PC on 21/05/2016.
 */
$(document).ready(function () {

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,// Creates a dropdown of 15 years to control year
        format: 'yyyy/mm/dd',
        formatSubmit: 'yyyy/mm/dd',
        closeOnSelect: true,
        //min: new Date(),
        onSet: function (ele) {
            if(ele.select){
                this.close();
            }
        }
    });

    $('select').material_select(); // render selects

    $('input.characterCounter, textarea.characterCounter').characterCounter();// initialise characterCounter

    Materialize.updateTextFields();

    $(".addEventForm").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#add_event_btn'));
        laddaInstance.start();

        var formData = new FormData(document.querySelector(".addEventForm"));

        $.ajax({
            url: "agenda",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if(data.status){
                    laddaInstance.stop();
                    $("#addEventModal").modal("hide");
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            }
        })
    });

    $(".editEventForm").submit(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#edit_event_btn'));
        laddaInstance.start();
        $("#edit_event_btn").text("Enregistrement en cours ...");
        var formData = new FormData(document.querySelector(".editEventForm"));

        $.ajax({
            url: "agenda/events/"+ EventId +"/edit",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if(data.status){
                    laddaInstance.stop();
                    $("#editEventModal").modal("hide");
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            }
        })
    });

    $("#remove_event_btn").click(function (e) {
        e.preventDefault();
        var laddaInstance = Ladda.create(document.querySelector( '#remove_event_btn'));
        laddaInstance.start();
        $(this).text("Suppression en cours ...").attr("disabled", true);
        $.post(
            "agenda/events/" + EventId + "/remove",
            {},
            function (data) {
                laddaInstance.stop();
                $("#editEventModal").modal("hide");
                $('#calendar').fullCalendar( 'refetchEvents' );
            }
        )
    });

    var handleCalendarDayClick = function (date, jsEvent, view) {
        //console.log("Clicked on "+ date.format()+ " with VIEW "+ view.name, " And Event : ", jsEvent
        /*$.get(
            "agenda/event/new",
            {},
            function (form) {

            }
        )*/
    };
    
    $('#calendar').fullCalendar({
        height: 'auto',
        lang: 'fr',
        /*events: [
            {
                title: 'XXL',
                start: '2016-05-22'
            }
        ],*/
        events: {
            url: "agenda/get/events",
            type: "GET",
            data:{},
            error: function () {
                console.log("An error occured !!!");
            },
            success: function (datas) {
                //console.log("PFFF ", datas[0])
            }
        },
        /*events: function (start, end, timezone, callback) {
            $.get(
                "agenda/get/events",
                {},
                function (data) {
                    callback(data);
                }
            )
        },*/

        dayClick: function(date, jsEvent, view) {
            handleCalendarDayClick(date, jsEvent, view);
        },
        eventMouseover: function (event, jsEvent, view) {
            /*$(this).attr('data-tooltip', event.title);
            if(!$(this).hasClass("tooltipped")){
                $(this).addClass('tooltipped');
            }
            $(this).attr('data-position', "bottom");
            $(this).attr('data-delay', 50);
            $(this).css({cursor: "pointer"}); */
            //console.log($(this));

            $(this).attr('data-toggle','tooltip');
            $(this).attr('title',event.description);
            $(this).css({cursor: "pointer"});
        },
        eventMouseout: function (event, jsEvent, view) {
            $(this).tooltip("remove");
            $(this).removeClass("tooltipped");
        },
        eventClick: function (event, jsEvent, view) {
            $.get(
                "agenda/events/"+event.id+"/edit",
                {},
                function(data){
                    $(".editModalBody").html(data);
                    $("#editEventModal").modal();
                }
            )

        },
        eventAfterAllRender: function (view) {
            $('.tooltipped').tooltip('remove');
            $('.tooltipped').tooltip({delay: 50});
        },

        /*customButtons: {
            myCustomButton: {
                text: 'ajouter',
                click: function() {
                    $("#addEventModal").modal();
                }
            }
        },*/
        header: {
            left: 'myCustomButton',
            center: 'title',
            right: 'prev,next today,month,agendaWeek,agendaDay'
        }
    });
});