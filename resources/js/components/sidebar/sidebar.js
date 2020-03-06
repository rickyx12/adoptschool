import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TreeMenu from './Treemenu';
import TreeMenuItem from './TreeMenuItem';


export default class Sidebar extends Component {

    render() {
        return (

            <aside className="main-sidebar sidebar-dark-primary elevation-4">
                  <a href="#" className="brand-link">
                    <span className="brand-text font-weight-light">Template</span>
                  </a>
         
                  <div className="sidebar">
                        <nav className="mt-2">
                        	<ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <TreeMenu
                                    isActive="active" 
                                    icon="fa-cog"
                                    name="Settings"
                                >    
                            
                                    <TreeMenuItem href="/school/public/category" name="Category" />
                                    <TreeMenuItem href="/sub-category" name="Sub Category" />
                                </TreeMenu>
                        	</ul>
                        </nav>
                  </div>
             </aside>

        );    
    }
}
