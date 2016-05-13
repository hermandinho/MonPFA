/**
 * Created by Herman on 10/05/2016.
 */



var MaaillingComponent = (function () {
    var FolderList = React.createClass({
        displayName: 'FolderList',
        displayClass: "MaaillingComponent",
        getInitialState: function () {
            return {
                folders: []
            };
        },
        
        render: function () {
            
        }

    });
})();

$(document).ready(function () {
    $.ajax({
        type: "GET",
        cache: false,
        url: "/",
        dataType: "json",
        success: function (data) {
            //console.log( data);
            var source = (data);
            //console.log(source);
            ReactDOM.render(React.createElement(MaaillingComponent, {interactions: source}), document.getElementById("timeLine"));
        },
        error: function (e, err) {

        }
    });
});