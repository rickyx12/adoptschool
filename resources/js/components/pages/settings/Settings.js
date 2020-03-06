import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Settings extends Component {

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
                                    <h5 className="m-0">{this.props.header}</h5>
                                  </div>
                                  <div className="card-body">
                                    <h6 className="card-title">Special title treatment</h6>

                                    <p className="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" className="btn btn-primary">Go somewhere</a>
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
