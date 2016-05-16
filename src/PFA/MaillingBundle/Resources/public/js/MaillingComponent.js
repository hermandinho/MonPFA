/**
 * Created by Herman on 10/05/2016.
 */



var MaillingComponent = (function () {

    var FolderRow = React.createClass({
        displayName: "FolderRow",
        displayClass: "FolderRow",
        getInitialState: function () {
            return ({

            })
        },

        render: function () {
            var props = this.props;
            var unread = "";
            if(parseInt(props.unReadMails) > 0){
                unread = React.createElement(
                    "span",
                    {
                        className: "new badge"
                    },
                    parseInt(props.unReadMails)
                )
            }
            return(
                React.createElement(
                    "li",
                    {
                        className: "collection-item",
                        onClick: props.handleFolderRowClick.bind(null, props.folder)
                    },
                    props.folder.name,
                    unread
                )
            )
        }
    });

    var FolderList = React.createClass({
        displayName: 'FolderList',
        displayClass: "MaillingComponent",
        getInitialState: function () {
            return {
                data: [],
                selectedFolder: ""
            };
        },
        
        render: function () {
            var data = this.props.data || this.state.data,
                folders = this.props.folders;
            var $this = this;
            /*var folders = folders.map(function (item, i) {
                return item.folder;
            });*/

            var buildFolders = folders.map(function (item, i) {
                var unreadMails = data.filter(function (elt,j) {
                    return item.name == elt.folder.name && elt.is_read == false;
                }).length;

                return (
                    React.createElement(
                        FolderRow,
                        {
                            folder: item,
                            key: "folder_" + i,
                            unReadMails: unreadMails,
                            handleFolderRowClick: $this.props.handleFolderRowClick
                        }
                    )
                )
            });
            return(
                React.createElement(
                    "div",
                    {
                        className: 'col s3',
                        id: "mail_folders"
                    },
                    React.createElement(
                        "ul",
                        {
                            className: "collection with-header"
                        },
                        React.createElement(
                            "li",
                            {
                                className: "collection-header"
                            },
                            React.createElement(
                                "h4",{},"First Names"
                            )
                        ),
                        buildFolders
                    )
                )
            )
        }
    });

    var EmailsList = React.createClass({
        displayName: "EmailsList",
        getInitialState: function () {
            return({

            });
        },

        render: function () {
            var emails = this.props.data;
            var displayMails = emails.map(function (email, i) {
                var className = "collection-item avatar ";
                className += email.is_read ? " read " : " unread ";

                return React.createElement(
                    "li",
                    {
                        className: className,
                        key: "mailList_" + i
                    },
                    React.createElement(
                        "i",
                        {
                            className: "material-icons circle green"
                        },

                        "folder"
                    ),
                    React.createElement(
                        "span",
                        {
                            title: "MAIL TITLE GOES HERE :)"
                        }
                    ),
                    React.createElement(
                        "p",
                        {
                            className: " truncate "
                        },
                        email.subject
                    ),
                    React.createElement(
                        "p",
                        {
                            className: " truncate "
                        },
                        email.body
                    )
                )
            });

            return(
                React.createElement(
                    "div",
                    {
                        className: "col s3",
                        id: "mail_filders_content"
                    },
                    React.createElement(
                        "ul",
                        {
                            className: "collection"
                        },
                        displayMails
                    )
                )
            )
        }
    });

    var MaillingComponent = React.createClass({
        displayName: "MaillingComponent",
        displayClass: "MaillingComponent",
        getInitialState: function () {
            return({
                emails: [],
                mailBoxData: [],
                selectedFolder: null,
                selectedFolderContent: []
            })
        },
        componentDidMount: function () {
          this.setState({ mailBoxData: this.props.data });
        },

        handleFolderRowClick: function (folder) {
            var selectedFolderContent = this.state.mailBoxData.mailbox.emails.filter(function (item) {
                return item.folder.id == folder.id;
            });

          this.setState({selectedFolder: folder, selectedFolderContent: selectedFolderContent});
        },

        render: function () {
            var props = this.props;
            var state = this.state;
            var data = props.data;
            var emailList = data.hasOwnProperty('mailbox') ? data.mailbox : state.emails;
            //console.log("*** ", data);
            return(
                React.createElement(
                    "div",
                    {
                        className: 'row'
                    },
                    React.createElement(
                        FolderList,
                        {
                            data: emailList.emails,
                            folders: data.folders,
                            handleFolderRowClick: this.handleFolderRowClick
                        }
                    ),
                    React.createElement(
                        EmailsList,
                        {
                            data: this.state.selectedFolderContent
                        }
                    )
                )
            )
        }
    });
    return MaillingComponent;
})();

$(document).ready(function () {
    $.ajax({
        type: "GET",
        cache: false,
        url: MAILLING_HOME_ROUTE,
        dataType: "json",
        success: function (data) {
            console.info( "**** MAILLING DATA RETURNED *****");
            var source = (data);
            //console.log(source);
            ReactDOM.render(React.createElement(MaillingComponent, {data: source}), document.getElementById("mail_Layout"));
        },
        error: function (e, err) {
            console.log(err);
        }
    });
});