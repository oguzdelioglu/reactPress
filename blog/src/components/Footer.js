import React, { Component } from 'react'
import LatestPosts from './FooterElements/LatestPosts'
import PopularPosts from './FooterElements/PopularPosts'
import RandomPosts from './FooterElements/RandomPosts'

export default class Footer extends Component {
  render() {
    return (
      <div>
    <div>
  <div className="e3lan e3lan-bottom">
    site_ads_responsive
  </div>
  <footer id="theme-footer">
    <div id="footer-widget-area" className="footer-3c">
      <div id="footer-first" className="footer-widgets-box">
       <PopularPosts maxPost={5}></PopularPosts>
      </div>
      <div id="footer-second" className="footer-widgets-box">
      <RandomPosts maxPost={5}></RandomPosts>
      </div>
      <div id="footer-third" className="footer-widgets-box">
      <LatestPosts maxPost={5}></LatestPosts>
      </div>{/* #third .widget-area */}
    </div>{/* #footer-widget-area */}
    <div className="clear" />
  </footer>{/* .Footer /*/}
  <div className="clear" />
  <div className="footer-bottom">
    <div className="container">
      <div className="alignright">
        Powered by <a href="http://wordpress.org">WordPress</a> | Designed by <a href="https://oguzdelioglu.com/">Oğuz DELİOĞLU</a> </div>
      <div className="alignleft">
        © Copyright 2020, All Rights Reserved </div>
      <div className="clear" />
    </div>{/* .Container */}
  </div>{/* .Footer bottom */}
</div>

      </div>
    )
  }
}
