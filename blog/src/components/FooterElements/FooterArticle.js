import React from 'react'
import { Link } from 'react-router-dom'
import { goTop, shortText } from '../../util'
import { LazyLoadImage } from "react-lazy-load-image-component";

export default function FooterArticle({post}) {
  return (
    <li>
        <div className="post-thumbnail">
        <Link onClick={()=> goTop()} to={process.env.REACT_APP_POST_PREFIX + post.link} title={post.title} rel="bookmark"><LazyLoadImage width="350" height="350" src={post.header_image} className="attachment-tie-small size-tie-small wp-post-image" alt={post.title} /><span className="fa overlay-icon"></span></Link>
        </div>
        <h4><Link onClick={()=> goTop()} to={process.env.REACT_APP_POST_PREFIX + post.link}>{shortText(post.title)}</Link></h4>
    </li> 
  )
}
