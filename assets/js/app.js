import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter as Router} from 'react-router-dom';
import '../css/app.css';
import Home from './components/Home';
import { createMuiTheme, makeStyles, ThemeProvider } from '@material-ui/core/styles';
import { blue } from '@material-ui/core/colors';


const theme = createMuiTheme({
    palette: {
        primary: blue,
    },
});
ReactDOM.render(<ThemeProvider theme={theme}>
    <Router>
        <Home/>
        <Router/>
    </Router>
</ThemeProvider>, document.getElementById('root'));
