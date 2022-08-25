import React, { Component } from 'react'

export default class Header extends Component {
  render() {
    return (
        <header id="theme-header" classname="theme-header">
          <div className="header-content">
            {/* eslint-disable-next-line */}
            <a title="Menu" id="slide-out-open" className="slide-out-open" href="#"><span /></a>
            <div className="search-block">
              <form method="get" id="searchform-header" action="search">
                <button aria-label="search-button" className="search-button" type="submit" placeholder="Search"><i className="fa fa-search" /></button>
                <input className="search-live" type="text" id="s-header" name="q" title="Search" placeholder="Search" minLength={3} maxLength={20} required onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.placeholder = 'Search';}" />
              </form>
            </div>
            <div className="logo">
              <h1> <a rel="home" title href="/">
                  {/* eslint-disable-next-line */}
                  <img src="/css/images/logo.png" width="175" height="44" /><strong />
                </a>
              </h1>
            </div>
            <div className="clear" />
          </div>
          <nav id="main-nav" className="fixed-enabled">
            <div className="container">
              <div className="main-menu">
                <ul id="menu-ana-menu" className="menu">
                  <li id="menu-item-1" className="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a rel="home" href="/">Home</a></li>
                  <li id="menu-item-' . $index . '" className="menu-item menu-item-type-post_type menu-item-object-page menu-item-' . $index . '"><a rel="category" href="/category/"><i className="fa fa-folder" /></a></li>
                </ul>
              </div>
            </div>
          </nav>
        </header>

    )
  }
}
