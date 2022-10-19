import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom';
import { getCategory, shortText } from '../util'

import { getImage } from '../services/firebase'

export default function Article({post}) {
  const [imgUrl, setImgUrl] = useState([]);
  const postCategory = () =>{
    return getCategory(post.category);
  }
  
  useEffect(()=> {
    getImage(post.header_image).then(result =>{
      setImgUrl(result)
   })
  },[post.header_image])
  
  return (
      <article className="item-list tie_lightbox">
          <h2 className="post-box-title">
            <Link to={process.env.REACT_APP_POST_PREFIX + post.link}>{post.title}</Link>
          </h2>
          <p className="post-meta">
            {/* <span className="post-cats"><i className="fa fa-folder" /><a href={process.env.REACT_APP_CATEGORY_PREFIX  + postCategory().slug } rel="category">{ postCategory().name}</a></span> */}
          </p>
          <div className="post-thumbnail">
            <Link title={post.title} to={process.env.REACT_APP_POST_PREFIX + post.link}>
              <img width={350} height={350} src={imgUrl} className="attachment-tie-medium size-tie-medium wp-post-image" alt={post.title} /> <span className="fa overlay-icon" />
            </Link>
          </div>
          <div className="entry">
            <p>{shortText(post.title)}</p>
            <Link className="more-link" to={process.env.REACT_APP_POST_PREFIX + post.link}>Read More »</Link>
          </div>
          <div className="clear" />
        </article>
  )
}
