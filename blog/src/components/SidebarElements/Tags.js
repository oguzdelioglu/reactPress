import React from 'react'
import { useSelector } from 'react-redux'
import Tag from './Tag'

export default function Tags() {
  const posts = useSelector((state) => state.global.posts)
  const tags = [...posts].map((post) => {return post.tags}).toString().split(',')
  const tagsRemovedDuplicate = tags.filter((element, index) => { return tags.indexOf(element) === index;}).filter(element => element !== '')

  return (
    TagWidget()
  )
  
  function TagWidget() {
    const LoopTags = tagsRemovedDuplicate.map(function (tag, tagIndex) { return <Tag key={tagIndex} tag={tag}></Tag> })
    return <div className="widget" id="tabbed-widget">
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
              {LoopTags}
            </div>
          </div>
        </div>
      </div>
    </div>
  }
}
