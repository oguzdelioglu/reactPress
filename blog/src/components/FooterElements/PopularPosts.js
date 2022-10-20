import React from 'react'
import { useSelector } from 'react-redux'
import FooterArticle from './FooterArticle'

export default function PopularPosts({maxPost}) {
    const posts = useSelector((state) => state.global.posts)
  return (
    <div id="posts-list-widget-2" className="footer-widget posts-list">
    <div className="footer-widget-top">
      <h3>Popular Posts </h3>
    </div>
    <div className="footer-widget-container">
    <ul>
        {[...posts].sort(function (a, b) {  return b.hit - a.hit;  }).slice(0, maxPost).map((post,index) => <FooterArticle key={index} post={post}></FooterArticle>)}
    </ul>
    <div className="clear"></div>
    </div>
  </div>
  )
}
