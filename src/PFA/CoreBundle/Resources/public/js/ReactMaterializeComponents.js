/**
 * Created by Herman on 13/05/2016.
 */

var Button = React.createClass({
    displayName: "DefaultButton",
    getInitialState: function () {
        return({
            text: "Enregistrer",
            icon: null,
            iconSide: "left",
            color: "blue",
            isEnabled: true,
            extraCLass: "",
            id: "",
            type: "button",
            btnType: "btn",
            toolTipConfig: {
                dataPosition: 'bottom',
                dataDelay: 50,
                dataTooltip: ""
            },
            title: null
        });
    },

    handleClick: function (e) {
        if (this.props.onClick){
          return this.props.onClick(e);
        }
        return false;
    },

    render: function () {
        var props = this.props;
        var state = this.state;
        var className = "waves-effect waves-light ";
        var color = props.color ? props.color : state.color;
        var id = props.id ? props.id : null;

        var icon = props.icon ? props.icon : state.icon;
        var btnType = props.btnType ? props.btnType : state.btnType;
        var iconSide = props.iconSide ? props.iconSide : state.iconSide;
        var text = props.text ? props.text : state.text;
        var type = props.type ? props.type : state.type;
        var isEnabled = (props.hasOwnProperty('isEnabled')) ? props.isEnabled : state.isEnabled;
        var enabled = (isEnabled) ? "" : "disabled";

        var Icon = null;
        if(icon !== null){
            Icon = React.createElement(
                "i",
                {
                    className: "material-icons " + iconSide
                },
                icon + " "
            );
        }
        className += " " + color;
        className += " "+btnType;
        var tooltipConfig = props.toolTipConfig || state.toolTipConfig , dataPosition = "", dataDelay = 0, dataTooltip = "";
        if (props.title){
            className += " tooltipped ";
            dataDelay = tooltipConfig.dataDelay;
            dataPosition = tooltipConfig.dataPosition;
            dataTooltip = props.title

        }

        var handleClick = (isEnabled) ? this.handleClick : false;

        return(
            React.createElement(
                "button",
                {
                    className :  className + " " + enabled,
                    type: type,
                    onClick: handleClick,
                    "data-position": dataPosition,
                    "data-delay": dataDelay,
                    "data-tooltip": dataTooltip,
                    id: id
                },
                Icon,
                " " + text
            )
        )
    }
});

var FloatingButton = React.createClass({
   displayName: "FloatingButton",
    getInitialState: function () {
        return({
            icon: "add",
            color: "red",
            actions: [],
            id: "",
            extraClass: "",
            isEnabled: true,
            direction: "vertical",
            style: {
                bottom: '45px',
                right: '24px'
            },
            size: "large",
            FABEvent: ""
        });
    },

    handleClick: function () {
      if(this.props.onCLick){
          return this.props.onClick;
      }
        return false;
    },

    render: function () {
        var props = this.props,
            state = this.state,
            actions = props.actions || state.actions;
        var className = "fixed-action-btn ";
        className += props.direction ? props.direction : state.direction + " ";
        className += " " + props.FABEvent ? props.FABEvent : state.FABEvent;

        var isEnabled = (props.hasOwnProperty('isEnabled')) ? props.isEnabled : state.isEnabled;
        var enabled = (isEnabled) ? "" : "disabled";

        var handleClick = (isEnabled) ? this.handleClick : false;

        var size = props.size ? "btn-"+props.size : "btn",
            color = props.color ? props.color : state.color;

        var builtActions = actions.map(function (action , i) {
            return(
                React.createElement(
                    "li",
                    {
                        key: "action_"+i
                    },
                    React.createElement(
                        FloatingAction,
                        {
                            isEnabled: action.isEnabled || true,
                            icon: action.icon || "warning",
                            extraClass: action.extraClass || "",
                            id: action.id || "",
                            color: action.color || "green",
                            key: "floatingaction_"+i,
                            onClick: function () {
                                if (typeof action.onClick === "function"){
                                    return action.onClick();
                                }
                                return false;
                            }
                        }
                    )
                )
            )
        });


        return(
            React.createElement(
                "div",
                {
                    className: className,
                    style: props.style || state.style
                },
                React.createElement(
                    "a",
                    {
                        className: "btn-floating " + size + " " + color + " " + enabled,
                        onClick: this.props.onClick
                    },
                    React.createElement(
                        "i",
                        {
                            className: "material-icons " + (props.size || state.size)
                        },
                        props.icon || state.icon
                    )
                ),
                React.createElement(
                    "ul",
                    null,
                    builtActions
                )
            )
        )

    }
});

var FloatingAction = React.createClass({
    displayName: "FloatingAction",
    getInitialState: function () {
        return({
            isEnabled: true,
            icon: "",
            color: "red",
            extraClass: "",
            id: ""
        });
    },

    render: function () {
        var props = this.props,
            state = this.state;

        var color = props.color ? props.color : state.color;
        color += (props.extraClass) ? props.extraClass : "";

        return(
            React.createElement(
                "a",
                {
                    className: "btn-floating " + color,
                    onClick: props.onClick
                },
                React.createElement(
                    "i",
                    {
                        className: "material-icons",
                        id: props.id || state.id
                    },
                    props.icon || state.icon
                )
            )
        )
    }
});

/*ReactDOM.render(React.createElement(Button,{ color: "red",btnType: "btn-flat",title:'Hello boss', iconSide: "right", isEnabled: false, icon: "send", text: "GO", onClick: function () {
    console.log("Hello");
} }), document.getElementById("textZone"));

ReactDOM.render(React.createElement(FloatingButton, { FABEvent: "click-to-toggle",
    actions: [{icon: 'add', color: 'blue'},{icon: 'attach_file', color: 'green',onClick: function () {
        console.log("Hello !!! ");
    }  }]
}), document.getElementById("textFloatingZone")); */