// import { useSelector } from 'react-redux'
import React, { useState,useEffect } from 'react'
import { fetchPost } from '../services/firebase'
// import { useDispatch } from 'react-redux'
import { useParams } from 'react-router-dom'
import { slugify } from '../util'
import { useDispatch, useSelector } from 'react-redux'
import { updateMetadata } from '../stores/global';

export default function Post() {
  const [post, setPost] = useState()
  const categories = useSelector((state) => state.global.categories)
  const dispatch = useDispatch()
  const { post_url } = useParams()

  const getCategory =(id)=>{
    const category = categories.filter((category) => category.id === id).pop()
    return category
  }

  //Get Post Data
  useEffect(() => {
    console.log("Post Link ->",post_url)
    fetchPost(post_url).then(data => {
      console.log(data)
      setPost(data)
      return data;
    })
   
    //dispatch(updatePost(data))
  },[post_url]);


  //Metadata Update After Post data received
  useEffect(()=> {
    if(post && post.pin_title) {
      const meta =  {
        title: post.pin_title,
        description: post.pin_title,
        canonical: window.location.href,
        meta: {
          charset: 'UTF-8',
          name: {
            keywords: post.post_tags.join(",")
          }
        }
      }
      console.log("New Metadata:",meta)
      dispatch(updateMetadata(meta))
    }
  },[dispatch, post])


  // useEffect(() => {
  //   console.log("Post Link ->",post_link)
  //   const data = fetchPost(post_link).then(data=> {
  //     //console.log(data);
  //     return data;
  //   })
  //   dispatch(updatePost(data))
  // }, []);



  
  if (post && post.pin_title && post.post_category && categories) {
    return (
      <div>
        <Content></Content>
      </div>
    );
  } else {
    return (
    'Loading Post...'
    );
  }

  function Content() {
    return <div className="content" >
    {  NavBar() }
    <article className="post-listing post type-post status-publish format-standard has-post-thumbnail  category-thumbnail tag-article tag-author tag-post tag-video" id="the-post">
      <div className="post-inner">
        {Title()}
        {PostMeta()}
        <div className="clear" />
        <div className="entry">
          <div style={{textAlign: 'center'}}> {PreviusNextPosts()}</div>
          <div dangerouslySetInnerHTML={{__html: post.pin_content}} ></div>
        </div>
        {ShareSocialMedia()} 
        <div className="clear" />
      </div>
    </article>
      {PostTags()}
    </div>
  }


  function Title() {
    return <h1 className="name post-title entry-title">
      <span itemProp="name">{post.pin_title}</span>
    </h1>
  }

  function PostTags() {
    return <p className="post-tag">Tags
      {post.post_tags.map((tag,index) => (
        <a key={index} rel="nofollow" href={'/search/' + slugify(tag)}>{tag}</a>
      ))}
    </p>
  }

  function ShareSocialMedia() {
    return <div className="share-post">
      <span className="share-text">Share</span>
      <ul className="flat-social">
        <li><a title="share to twitter" href={'https://twitter.com/intent/tweet?text=' + post.pin_title + '&url=' + window.location.href} className="social-twitter" rel="noopener noreferrer" target="_blank"><i className="fa fa-twitter"></i> <span>Twitter</span></a></li>
        <li><a title="share to facebook" href={'http://www.facebook.com/sharer.php?u=' + window.location.href} className="social-facebook" rel="noopener noreferrer" target="_blank"><i className="fa fa-facebook"></i> <span>Facebook</span></a></li>
        <li><a title="share to pinterest" href={'http://pinterest.com/pin/create/button/?url=' + window.location.href + '&description=' + post.pin_title + '&media=' + post.pin_img} className="social-pinterest" rel="noopener noreferrer" target="_blank"><i className="fa fa-pinterest"></i> <span>Pinterest</span></a></li>
        <li><a title="share to linkedin" href={'http://www.linkedin.com/shareArticle?mini=true&url=' + window.location.href + '&title=' + post.pin_title} className="social-linkedin" rel="noopener noreferrer" target="_blank"><i className="fa fa-linkedin"></i> <span>LinkedIn</span></a></li>
      </ul>
      <div className="clear" />
    </div>
  }

  function PreviusNextPosts() {
    return <div>
      <a href="augshy-83-pieces-resin-jewelry-casting-molds-silicone-B08L8L4H1X" title="previus post"><img className="alignnone size-medium tie-appear" src="/css/images/previous.gif" alt="previus" width={150} height={55} /></a>
      <a href="acrylic-earrings-for-women-girls-drop-dangle-leaf-earrings-B07V6XHV2G" title="next post"><img className="alignnone size-full tie-appear" src="/css/images/next.gif" alt="next" width={150} height={55} /></a>
    </div>
  }

  function PostMeta() {
    return <p className="post-meta">
      <span className="post-cats"><i className="fa fa-folder" />
      <a href={'/category/' + getCategory(post.post_category).slug} rel="category">{getCategory(post.post_category).name}</a></span>
    </p>
  }
  function NavBar() {
    return <nav id="crumbs"><a rel="home" href="/">
        <span className="fa fa-home" aria-hidden="true" /> Home</a>
        <span className="delimiter">/</span>
        <a rel="category" href={"/category/" + getCategory(post.post_category).slug}>{getCategory(post.post_category).name}</a>
        <span className="delimiter">/<span className="current">{post.pin_title}</span></span>
      </nav>
  }

  
}