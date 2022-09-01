import React, { Component } from 'react'
import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";
import router from '../router'
export default class Container extends Component {
  
  render() {
    return (
  <div id="main-content" className="container">
    <div className="content">
      <Router>
        <Routes>
        {
          router.map((route,key) => (
            <Route key={key} path={route.path} element={route.element}></Route>
            )
          )
        }
        </Routes>
      </Router>
      deneme
      {/* <div className="post-listing archive-box">
        
      </div> */}
    </div>
    <div className="clear" />
  </div>
    )
  }
}
