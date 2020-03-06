import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Category from './settings/Category';
import { Switch, Route } from "react-router-dom";

export default class Page extends Component {

    constructor(props) {
        super(props);
    }


    render() {

        return (
            <div>
                
                <Switch>
                    <Route path='/school/public/category'>
                        <Category />
                    </Route>
                </Switch>
                
                <div className="content-wrapper">
                    <div className="content">
                        <div className="container-fluid">
                            <div className="row">
                                <div className="col-lg-12 pt-3">
                                   s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );    
    }
}
