import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Category extends Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
              <div class="content-wrapper">
                  <div className="content">
                      <div className="container-fluid">
                          <div className="row">
                              <div className="col-lg-12 pt-3">
                                <div className="card">
                                  <div className="card-header">
                                    <h5 className="m-0">Category</h5>
                                  </div>
                                  <div className="card-body">
                                    Category Section
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>                            
            </div>
        );    
    }
}
