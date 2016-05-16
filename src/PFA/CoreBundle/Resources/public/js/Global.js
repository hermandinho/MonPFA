/**
 * Created by El-PC on 06/05/2016.
 */
"use strict";

/*var DefaultButton = React.createClass({
    displayName: "button",
    displayClass: "",

    getInitialState: function () {
        return {
            btnText: "Enregistrer"
        }
    },

    render: function () {
        return (
            React.createElement(
                "button",
                {
                    className: "waves-effect waves-light btn"
                },
                this.props.text ? this.props.text : this.state.btnText
            )
        );
    }
});


var ButtonWithIcon = React.createClass({
    displayName: "buttonWithIcon",
    displayClass: "",

    getInitialState: function () {
        return {
            btnText: "Enregistrer",
            icon: "",
            potition: "left"
        }
    },

    render: function () {
        var className = "material-icons ";
        className += this.props.position ? this.props.position : this.state.position;
        return (
            React.createElement(
                "button",
                {
                    className: "waves-effect waves-light btn"
                },
                React.createElement(
                    "i",
                    {
                        className: className
                    },
                    this.props.icon ? this.props.icon : this.state.icon
                ),
                this.props.text ? this.props.text : this.state.btnText
            )
        );
    }
});

var DefaultFloatingButton = React.createClass({
    displayName: "DefaultFloatingButton",
    displayClass: "",

    getInitialState: function () {
        return {
            btnText: "Enregistrer",
            icon: "add",
            color: "red"
        }
    },

    render: function () {
        var className = "btn-floating btn-large waves-effect waves-light ";
        className += this.props.color ? this.props.color : this.state.color;
        return (
            React.createElement(
                "button",
                {
                    className: className
                },
                React.createElement(
                    "i",
                    {
                        className: "material-icons"
                    },
                    this.props.icon ? this.props.icon : this.state.icon
                ),
                this.props.text ? this.props.text : this.state.btnText
            )
        );
    }
});

var FloatingButtonWithActions = React.createClass({
    displayName: "DefaultFloatingButton",
    displayClass: "",

    getInitialState: function () {
        return {
            btnText: "Enregistrer",
            icon: "add",
            color: "red",
            actions: [],
            style: "bottom: 45px; right: 24px;"
        }
    },

    render: function () {
        var className = "btn-floating btn-large ";
        className += this.props.color ? this.props.color : this.state.color;

        var actions = this.props.actions || this.state.actions || [];
        var buildActions = actions.map(function (action, i) {
            return React.createElement(
                FloatingButtonAction,
                {
                    color: action.color || null,
                    icon: action.icon || null,
                    title: action.title || "",
                    key: "floating_action_" + i
                }
            )
        });

        return (
            React.createElement(
                "div",
                {
                    className: "fixed-action-btn",
                    //style: this.props.style ?  this.props.style : this.state.style
                    style: {}
                },
                React.createElement(
                    "a",
                    {
                        className: className
                    },
                    React.createElement(
                        "i",
                        {
                            className: "large material-icons"
                        },
                        this.props.icon ? this.props.icon : this.state.icon
                    )
                ),
                React.createElement(
                    "ul",
                    null,
                    buildActions
                )
            )
        );
    }
});

var FloatingButtonAction = React.createClass({
    displayName: "FloatingButtonAction",
    getInitialState: function () {
        return({
            color: 'red',
            icon: "format_quote",
            title: ""
        })
    },

    render: function () {
        var className = "btn-floating ";
        className += this.props.color ? this.props.color : this.state.color;

        return(
            React.createElement(
                "a",
                {
                    className: className,
                    title: this.props.title ? this.props.title : this.state.title
                },
                React.createElement(
                    "i",
                    {
                        className: "material-icons "
                    },
                    this.props.icon ? this.props.icon : this.state.icon
                )

            )
        );
    }
});

ReactDOM.render(React.createElement(FloatingButtonWithActions, { actions: [{title: 'XXL', icon: 'add', color: 'blue'}, {title: 'PFFF', icon: 'cloud', color: 'yellow'}] }), document.getElementById("textZone"));*/

