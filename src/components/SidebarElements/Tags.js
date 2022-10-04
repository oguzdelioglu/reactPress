import React from 'react'
import { useSelector } from 'react-redux'
import Tag from './Tag'

export default function Tags() {
    const posts = useSelector((state) => state.global.posts)
  return (
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
          { [...posts].map((post) => 
            {
                return post.tags
            }).toString().split(',').map((tag,index)=> <Tag key={index} tag={tag}></Tag>) }
          </div>
        </div>
      </div>
    </div>
  </div>
  )
}
