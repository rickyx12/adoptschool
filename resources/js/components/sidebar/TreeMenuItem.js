import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Link } from "react-router-dom";

export default class TreeMenuItem extends Component {

    constructor(props) {
        super(props);
    }

    render() {

        return (
            <li className="nav-item">

               <Link exact to={this.props.href} className="nav-link">
                <i className="far fa-circle nav-icon"></i>
                {this.props.name}
               </Link>
            </li>
        );    
    }
}
