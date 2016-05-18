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
            if(props.selectedFolder){
                var isSelected = (props.folder.id == props.selectedFolder.id) ? " active " : " not-active ";
                //console.log(props.selectedFolder, props.folder, isSelected);
            }

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
                        className: "collection-item " + isSelected,
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
                data: {
                    mailbox:[]
                },
                selectedFolder: ""
            };
        },
        
        render: function () {
            var data = this.props.data || this.state.data;
            var $this = this;
            /*var folders = data.folders.map(function (item, i) {
                return item.folder;
            });*/
            var buildFolders = data.folders.map(function (item, i) {
                var unreadMails = data.mailbox.filter(function (elt,j) {
                    return item.name == elt.folder.name && elt.is_read == false;
                }).length;

                return (
                    React.createElement(
                        FolderRow,
                        {
                            folder: item,
                            key: "folder_" + i,
                            unReadMails: unreadMails,
                            handleFolderRowClick: $this.props.handleFolderRowClick,
                            selectedFolder: $this.props.selectedFolder
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
                                "h4",
                                {

                                },
                                "First Names",
                                React.createElement(
                                    Button,
                                    {
                                        color: 'blue',
                                        btnType: "btn-floating",
                                        title: "Ajouter un dossier",
                                        icon: "add",
                                        id: "add_folder",
                                        onClick: this.props.handleNewFolderClick
                                    }
                                )
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
            var $this = this;
            var displayMails = emails.map(function (email, i) {
                var className = "collection-item avatar ";
                className += email.is_read ? " read " : " unread ";

                return React.createElement(
                    "li",
                    {
                        className: className,
                        key: "mailList_" + i,
                        onClick: $this.props.handleMailViewClick.bind(null, email)
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
                        id: "mail_folders_content"
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

    var MailViewActions = React.createClass({
        displayNam: "MailViewActions",
        getInitialState: function () {
            return({

            })
        },

        render: function () {
            return(
                React.createElement(
                    "span",
                    null,
                    React.createElement(
                        "span",
                        {},
                        React.createElement(
                            Button,
                            {
                                icon: 'delete',
                                btnType: 'btn-floating',
                                title: "Supprimer",
                                color: 'red',
                                isEnabled: false
                            }
                        )
                    ),
                    React.createElement(
                        "span",
                        {},
                        React.createElement(
                            Button,
                            {
                                icon: 'label',
                                btnType: 'btn-floating',
                                title: "CCC"
                            }
                        )
                    )
                )
            )
        }
    });

    var MailViewer = React.createClass({
        displayName: "MailViewer",
        getInitialState: function () {
            return({

            });
        },

        render: function () {
            var mailContent,
                props = this.props;

            if(props.email == null){
                /*mailContent = React.createElement(
                    "div",
                    {
                        className: " valign-wrapper "
                    },
                    React.createElement(
                        "h3",
                        {
                            className: "valign mail_view_placeholder"
                        },
                        "Aucun mail sélectionner "
                    )
                )*/
                mailContent = React.createElement(
                    Loader, null
                )
            }else {
                mailContent = React.createElement(
                    "div",
                    {
                        className: ""
                    },
                    React.createElement(
                        "div",
                        {
                            className: 'row'
                        },
                        React.createElement(
                            "div",
                            {
                                className: "col s5 _push-s5 left-align"
                            },
                            React.createElement(
                                "div",
                                {
                                    className: "card-panel grey lighten-5 z-depth-1"
                                },
                                React.createElement(
                                    "div",
                                    {
                                        className: "row valign-wrapper "
                                    },
                                    React.createElement(
                                      "div",
                                        {
                                            className: "col s4 m2"
                                        },
                                        React.createElement(
                                            "i", //TODO ADD IMAGE HERE
                                            {
                                                className: "material-icons circle _green"
                                            },
                                            "folder"
                                        )
                                    ),
                                    React.createElement(
                                        "div",
                                        {
                                            className: "col s8 m10"
                                        },
                                        React.createElement(
                                            "p",
                                            {},
                                            props.email.sender.username
                                        ),
                                        React.createElement(
                                            "p",
                                            {},
                                            moment(props.email.sender.date).format("YYYY-MM-DD")
                                        )
                                    )

                                )
                            )
                        ),
                        React.createElement(
                            "div",
                            {
                                className: "col s5 _pull-s7"
                            },
                            React.createElement(
                                "span",
                                {},
                               React.createElement(
                                   "h4",
                                   {},
                                   props.email.subject
                               )
                            )
                        )
                    )

                )
            }

            return(
                React.createElement(
                    "div",
                    {
                        className: "col s6",
                        id: "mail_display"
                    },
                    React.createElement(
                        "div",
                        {
                            className: "z-depth-1 action_bar grey right-align"
                        },
                        React.createElement(
                            MailViewActions,
                            {}
                        )
                    ),
                    React.createElement(
                        "div",
                        {
                            className: "_valign-wrapper z-depth-1"
                        },
                        React.createElement(
                            "div",
                            {
                                className: "valign center-align"
                            },
                            mailContent
                        )
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
                selectedFolderContent: [],
                currentViewMail: null
            })
        },
        componentDidMount: function () {
            var defaultFolder = [];
            this.props.data.folders[0] ? defaultFolder.push(this.props.data.folders[0]) : null;
            var selectedFolderContent = [];
            if(defaultFolder.length > 0){
                selectedFolderContent = this.props.data.mailbox.filter(function (item) {
                    return item.folder.id == defaultFolder[0].id;
                });
            }
            this.setState({ mailBoxData: this.props.data, selectedFolder: defaultFolder[0], selectedFolderContent: selectedFolderContent });
        },

        handleFolderRowClick: function (folder, e) {
            var selectedFolderContent = this.state.mailBoxData.mailbox.filter(function (item) {
                return item.folder.id == folder.id;
            });

          this.setState({selectedFolder: folder, selectedFolderContent: selectedFolderContent});
        },

        handleNewFolderClick: function (e) {
          console.log("Going to create Folder !!! ");
        },

        handleMailViewClick: function (mail, e) {
            this.setState({currentViewMail: mail});
            //console.log("View ", mail.subject);
        },

        render: function () {
            var props = this.props;
            var state = this.state;
            var data = props.data;
            //var emailList = data.hasOwnProperty('mailbox') ? data.mailbox : state.emails;
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
                            data: data,
                            handleFolderRowClick: this.handleFolderRowClick,
                            selectedFolder: this.state.selectedFolder,
                            handleNewFolderClick: this.handleNewFolderClick
                        }
                    ),
                    React.createElement(
                        EmailsList,
                        {
                            data: this.state.selectedFolderContent,
                            handleFolderRowClick: this.handleFolderRowClick,
                            handleMailViewClick: this.handleMailViewClick
                        }
                    ),
                    React.createElement(
                        MailViewer,
                        {
                            email: this.state.currentViewMail
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