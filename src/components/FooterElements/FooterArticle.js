import React from 'react'
import { Link } from 'react-router-dom'
import { shortText } from '../../util'

export default function FooterArticle({post}) {
  return (
    <li>
        <div class="post-thumbnail">
        <Link to={process.env.REACT_APP_POST_PREFIX + post.link} title={post.title} rel="bookmark"><img width="350" height="350" src={post.image} class="attachment-tie-small size-tie-small wp-post-image" alt={post.title} /><span class="fa overlay-icon"></span></Link>
        </div>
        <h4><Link to={process.env.REACT_APP_POST_PREFIX + post.link}>{shortText(post.title)}</Link></h4>
    </li> 
  )
}
