import React, { Component } from 'react'
import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";
import router from '../router'
import Sidebar from './Sidebar';
export default class Container extends Component {
  
  render() {
    return (
  <div id="main-content" className="container">
    <div className="content">
        <Routes>
        {
          router.map((route,key) => (
            <Route key={key} path={route.path} element={route.element}></Route>
            )
          )
        }
        </Routes>
    </div>
    <Sidebar></Sidebar>
    <div className="clear" />
  </div>
    )
  }
}
