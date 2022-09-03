import React, { Component } from 'react'

export default class Sidebar extends Component {
  render() {
    return (
        <aside id="sidebar">
          <div className="theiaStickySidebar">
            <div className="widget">
            </div>
            <div className="e3lan-widget-content">
              <div className="widget-top">
                <h2>Our Picks</h2>
                <div className="stripe-line" />
              </div>
              <div className="widget">
                <div className="post-thumbnail">
                  <a rel="bookmark" href="/post/post_link" title="pin_title"><img width="350" height="350" src="imglink" className="attachment-tie-medium size-tie-medium wp-post-image" alt="" /><span className="fa overlay-icon" /></a>
                </div>
                <h3><a rel="bookmark" href="/post/post_link">Postlink</a></h3>
              </div>
            </div>
            <div className="widget widget_categories">
              <div className="widget-top">
                <h2>Categories</h2>
                <div className="stripe-line" />
              </div>
              <div className="widget-container">
                <ul>
                <li className="cat-item"><a rel="category" href="/category/">tag_name (pinCount)</a></li>
                  ?&gt;
                </ul>
              </div>
            </div>
            <div className="widget" id="tabbed-widget">
              <div className="widget-container">
                <div className="widget-top">
                  <ul className="tabs posts-taps">
                    <li className="tabs"><a href="#tags">Tags</a></li>
                  </ul>
                </div>
                <div id="tags" className="tabs-wrap tagcloud">
                  <div className="widget">
                    <h2 className="widget-title">Tags</h2>
                    <div className="widget-tags">
                      <a className="tag-cloud-link" rel="nofollow" href="/search/tag_name" style={{fontSize: '12pt'}}>tag_name</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="widget">
            </div>
          </div>
        </aside>
    )
  }
}
