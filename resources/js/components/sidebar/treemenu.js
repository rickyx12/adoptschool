import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Treemenu extends Component {

    constructor(props) {
        super(props);
    }

    render() {

        return (
    		<li className="nav-item has-treeview menu">
    			<a href="#" className={'nav-link '+ this.props.isActive}>
    				<i className={'nav-icon fas '+ this.props.icon}></i>
    				<p>
    					{this.props.name}
    					<i className="right fas fa-angle-left"></i>
    				</p>
    			</a>
                <ul className="nav nav-treeview">
                    {this.props.children}
                </ul>
            </li>
        );    
    }
}
