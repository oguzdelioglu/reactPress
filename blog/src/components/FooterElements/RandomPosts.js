import React from 'react'
import { useSelector } from 'react-redux'
import FooterArticle from './FooterArticle'

export default function RandomPosts({maxPost}) {
    const posts = useSelector((state) => state.global.posts)
  return (
    <div id="posts-list-widget-3" className="footer-widget posts-list">
    <div className="footer-widget-top">
      <h3>Random Posts </h3>
    </div>
    <div className="footer-widget-container">
    <ul>
        { [...posts].sort(() => Math.random() - 0.5).slice(0, maxPost).map((post,index) => <FooterArticle key={index} post={post}></FooterArticle>) }
    </ul>
    <div className="clear"></div>
    </div>
  </div>
  )
}
