import React, {PureComponent} from 'react';

import {HashRouter, Route} from 'react-router-dom';
import Home from './components/Home';
import Invoice from './components/Invoice';

class Router extends PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <HashRouter>
                <Route exact path="/" component={Home}/>
            </HashRouter>
        );
    }
}

export default Router;
