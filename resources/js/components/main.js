import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import RegistrationForm from './users/Registration';
import Sidebar from './sidebar/Sidebar';
import Page from './pages/Page';


if (document.getElementById('root')) {
    ReactDOM.render(
    	<div>
	    	<Sidebar />
	    	<Page />
    	</div>, 
    	document.getElementById('root'));
}

if(document.getElementById('registrationForm')) {
	ReactDOM.render(
		<RegistrationForm />,
		document.getElementById('registrationForm')
	);
}