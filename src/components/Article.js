import React, { useEffect } from 'react'
import { Link } from 'react-router-dom';
import { getCategory } from '../util'
export default function Article({post}) {
  const postCategory = () =>{
    return getCategory(post.category);
  }
  useEffect(()=> {
    // console.log("Post:",post)
    // console.log("categoryInfo",postCategory())
  })
  return (
      <article className="item-list tie_lightbox">
          <h2 className="post-box-title">
            <Link to={process.env.REACT_APP_POST_PREFIX + post.link}>{post.title}</Link>
          </h2>
          <p className="post-meta">
            <span className="post-cats"><i className="fa fa-folder" /><Link to={process.env.REACT_APP_CATEGORY_PREFIX  + postCategory().slug } rel="category">{ postCategory().name}</Link></span>
          </p>
          <div className="post-thumbnail">
            <Link title={post.title} to={process.env.REACT_APP_POST_PREFIX + post.link}>
              <img width={350} height={350} src={post.image} className="attachment-tie-medium size-tie-medium wp-post-image" alt={post.title} /> <span className="fa overlay-icon" />
            </Link>
          </div>
          <div className="entry">
            <p>{post.title}</p>
            <Link className="more-link" to={process.env.REACT_APP_POST_PREFIX + post.link}>Read More »</Link>
          </div>
          <div className="clear" />
        </article>
  )
}
