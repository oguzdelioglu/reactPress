import React from 'react'
import { Link } from 'react-router-dom'
import { shortText } from '../../util'

export default function PickWidget({post}) {
  return (
    <div className="widget">
        <div className="post-thumbnail">
            <Link rel="bookmark" to={process.env.REACT_APP_POST_PREFIX + post.link} title={shortText(post.title)}><img width="350" height="350" src={post.image} className="attachment-tie-medium size-tie-medium wp-post-image" alt="" /><span className="fa overlay-icon" /></Link>
        </div>
        <h3><Link rel="bookmark" to={process.env.REACT_APP_POST_PREFIX + post.link}>{shortText(post.title)}</Link></h3>
    </div>
  )
}
