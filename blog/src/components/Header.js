import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux';
import { Link, useNavigate } from 'react-router-dom';
import { fetchCategories } from '../services/firebase'
import { updateCategories } from '../stores/global'

export default function Header() {
  const categories = useSelector((state) => state.global.categories)
  const dispatch = useDispatch()
  const navigate = useNavigate()
  const handleSubmit = (event) => {
      console.log(event.target.q.value)
      navigate(process.env.REACT_APP_SEARCH_PREFIX + event.target.q.value)
      event.preventDefault()
  };
  useEffect(() => {
    fetchCategories().then(data=> {
      dispatch(updateCategories(data))
    })
  },[])

  return (
    <header id="theme-header" className="theme-header">
          <div className="header-content">
            {/* eslint-disable-next-line */}
            <a title="Menu" id="slide-out-open" className="slide-out-open" href="#"><span /></a>
            <div className="search-block">
              <form onSubmit={handleSubmit} id="searchform-header">
                <button aria-label="search-button" className="search-button" type="submit" placeholder="Search"><i className="fa fa-search" /></button>
                <input className="search-live" type="text" id="s-header" name="q" title="Search" placeholder="Search" minLength={3} maxLength={20} required onFocus={onFocusEvent.bind(this)} onBlur={onBlurEvent.bind(this)} />
              </form>
            </div>
            <div className="logo">
              <h1> <a rel="home" href="/">
                  {/* eslint-disable-next-line */}
                  <img src="/css/images/logo.png" alt="logo" width="175" height="44" /><strong />
                </a>
              </h1>
            </div>
            <div className="clear" />
          </div>
          <nav id="main-nav" className="fixed-enabled">
            <div className="container">
              <div className="main-menu">
                <ul id="menu-ana-menu" className="menu">
                  <li id="menu-item-1" className="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><Link rel="home" to="/">Home</Link></li>
                  {
                    [...categories].slice(0, 5).map((category,index) => 
                      <li key={index + 2} id={'menu-item-' + (index + 2)} className={'menu-item menu-item-type-post_type menu-item-object-page menu-item-' + index}><a style={{textTransform: 'capitalize'}} rel="category" href={'/category/' + category.slug}><i className="fa fa-folder" />{category.name}</a></li>
                    )
                  }
                </ul>
              </div>
            </div>
          </nav>
        </header>
  )

  function onFocusEvent(e) {
    return e.target.placeholder === 'Search' ? e.target.placeholder = '' : null;
  }

  function onBlurEvent(e) {
   return e.target.value === '' ? e.target.placeholder = 'Search': null;
  }
}
