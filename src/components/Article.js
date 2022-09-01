import React from 'react'

export default function Article() {
  return (
      <article className="item-list tie_lightbox">
          <h2 className="post-box-title">
            <a href="/post/postlink">Başlık</a>
          </h2>
          <p className="post-meta">
            <span className="post-cats"><i className="fa fa-folder" /><a href="/category/category_slug" rel="category">category</a></span>
          </p>
          <div className="post-thumbnail">
            <a title="pintitle" href="/post/postlink">
              <img width={350} height={350} src="imglink" className="attachment-tie-medium size-tie-medium wp-post-image" alt="pintitle" /> <span className="fa overlay-icon" />
            </a>
          </div>
          <div className="entry">
            <p>pintitle
            </p>
            <a className="more-link" href="/post/post_link">Read More »</a>
          </div>
          <div className="clear" />
        </article>
  )
}