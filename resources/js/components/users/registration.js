import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

function PrivateSector(props) {

  return(
      <div className="mt-3 ml-3">
        <ul className="list-unstyled">
          {props.dbSector}
        </ul>
      </div>
    ); 
}


// function PrivateSector(props) {

//   return(
//       <div className="mt-3 ml-3">
//         <ul className="list-unstyled">
//           <li>
//             <input 
//               type="radio"
//               name="subSector" 
//               className="mr-2"
//               value="alumni_assoc"
//               checked={props.value === "alumni_assoc"}
//               onChange={props.onChange}             
//             />
//             <label>Alumni Association</label>
//           </li>
//           <li>
//             <input type="radio" name="subSector" className="mr-2" />
//             <label>Corporate Foundation</label>
//           </li>
//           <li>
//             <input type="radio" name="subSector" className="mr-2" />
//             <label>Private Company</label>
//           </li>
//           <li>
//             <input type="radio" name="subSector" className="mr-2" />
//             <label>Private Individual</label>
//           </li>
//           <li>
//             <input type="radio" name="subSector" className="mr-2" />
//             <label>Private School</label>
//           </li>
//           <li>
//             <input type="radio" name="subSector" className="mr-2" />
//             <label>PTA</label>
//           </li>
//         </ul>
//       </div>
//     ); 
// }


function PublicSector() {

  return(
      <div className="mt-3 ml-3">
        <ul className="list-unstyled">
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Congress</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Government - Owned and Controlled Corporation</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>LGU - Barangay</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>LGU - City</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>LGU - Municipality</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>LGU - Province</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Senate</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>State University</label>
          </li>
        </ul>
      </div>
    );
}

function CSO() {

  return(
      <div className="mt-3 ml-3">
        <ul className="list-unstyled">
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Cooperative</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Faith - Based Organization</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Media Association</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Non - Government Association</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Peoples Organization</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Professional Association</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Trade Unions</label>
          </li>
        </ul>
      </div>
    );
}

function International() {

  return(
      <div className="mt-3 ml-3">
        <ul className="list-unstyled">
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>Foreign Government</label>
          </li>
          <li>
            <input type="radio" name="subSector" className="mr-2" />
            <label>International Non - Government Organization</label>
          </li>
        </ul>
      </div>
    );
}

export default class Registration extends Component {

    constructor(props) {
        super(props);
        this.state = {
          name:'',
          sector:'private',
          dbSector:'',
          subSector:'',
          contactNo:'',
          emailAdd:'',
          password:''
        }

        this.handleName = this.handleName.bind(this);
        this.handleSector = this.handleSector.bind(this);
        this.handleSubSector = this.handleSubSector.bind(this);
        this.handleContactNo = this.handleContactNo.bind(this);
        this.handleEmailAdd = this.handleEmailAdd.bind(this);
        this.handlePassword = this.handlePassword.bind(this);
        this.handleRegister = this.handleRegister.bind(this);
    }

    handleName(e) {

      this.setState({
        name: e.target.value
      });
    }

    handleSector(e) {
    
      this.setState({
        sector: e.target.value
      });
    }

    handleSubSector(e) {

      this.setState({
        subSector: e.target.value
      });
    }

    handleContactNo(e) {

      this.setState({
        contactNo: e.target.value
      });
    }

    handleEmailAdd(e) {

      this.setState({
        emailAdd: e.target.value
      });
    }

    handlePassword(e) {

      this.setState({
        password: e.target.value
      });
    }

    handleRegister(e) {

      e.preventDefault();

      const regForm = {
        name: this.state.name,
        sector: this.state.sector,
        subSector: this.state.subSector,

      };

      axios.post('http://localhost/school/public/register',regForm)
        .then(res => {
          console.log(res);
        });
    }


    componentDidMount() {
      axios.get('http://localhost/school/public/sector')
      .then(res => {
        const dbSector = res.data;
        this.setState({dbSector});
      })
    }

    render() {

      const selectedSector = this.state.sector;
      let subSector;

      if(selectedSector === "private") {        
        // subSector = <PrivateSector value={this.state.subSector} onChange={this.handleSubSector} />;
        subSector = <PrivateSector dbSector={this.state.dbSector.map(dbSector => <li>{dbSector.name}</li>)} />;
      }

      if(selectedSector === "public") {
        subSector = <PublicSector />;
      }

      if(selectedSector === "cso") {
        subSector = <CSO />;
      }

      if(selectedSector === "international") {
        subSector = <International />;
      }

      return (
        <div className="card mt-3 ml-4">
          <div className="card-header bg-info text-white">Registration</div>
          <form>
            <div className="container-fluid mt-3">
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <h6>Name / Company name</h6>
                     <input 
                        type="text" 
                        className="form-control" 
                        placeholder="" 
                        id="name" 
                        autoComplete="off" 
                        onChange={this.handleName}
                      />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <h6>Sector</h6>
                  <span className="mr-5">
                    <input 
                      name="sector" 
                      type="radio"
                      value="private"
                      checked={this.state.sector === "private"}
                      onChange={this.handleSector}  
                    /> Private
                  </span>
                  
                  <span className="mr-5">
                    <input 
                      name="sector" 
                      type="radio"
                      value="public"
                      checked={this.state.sector === "public"}
                      onChange={this.handleSector} 
                    /> Public
                  </span>
                  
                  <span className="mr-5">
                    <input 
                      name="sector" 
                      type="radio"
                      value="cso"
                      checked={this.state.sector === "cso"}
                      onChange={this.handleSector} 
                    /> Civil Society Organization
                  </span>
                  
                  <span>
                    <input 
                      name="sector" 
                      type="radio"
                      value="international"
                      checked={this.state.sector === "international"}
                      onChange={this.handleSector} 
                    /> International
                  </span>                  
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  {subSector}
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <h6>Contact No# (to contact you directly)</h6>
                    <input 
                      type="text" 
                      className="form-control" 
                      autoComplete="off" 
                      onChange={this.handleContactNo}
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <h6>Email Address (served as your username)</h6>
                    <input 
                      type="email" 
                      className="form-control" 
                      autoComplete="off" 
                      onChange={this.handleEmailAdd}
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <h6>Temporary Password (you may change this later.)</h6>
                    <input 
                      type="text" 
                      className="form-control" 
                      autoComplete="off" 
                      value="123456" 
                      onChange={this.handlePassword} 
                      autoComplete="off" 
                      onChange={this.handlePassword}
                    />
                  </div>
                </div>
              </div>
              <div className="row text-right pb-2">
                <div className="col-md">
                  <button className="btn btn-success btn-sm" onClick={this.handleRegister}>Register</button>
                </div>
              </div>              
            </div>
          </form>
        </div>
      );    
    }
}
