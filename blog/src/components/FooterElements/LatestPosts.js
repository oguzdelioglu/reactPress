import React from 'react'
import { useSelector } from 'react-redux'
import FooterArticle from './FooterArticle'

export default function LatestPosts({maxPost}) {
    const posts = useSelector((state) => state.global.posts)
  return (
    <div id="posts-list-widget-4" className="footer-widget posts-list">
    <div className="footer-widget-top">
      <h3>Latest Posts </h3>
    </div>
    <div className="footer-widget-container">
    <ul>
        { [...posts].sort(function (a, b) {  return b.date - a.date;  }).slice(0, maxPost).map((post) => <FooterArticle key={post.id} post={post}></FooterArticle>) }
    </ul>
    <div className="clear"></div>
    </div>
  </div>
  )
}
