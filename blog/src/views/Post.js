// import { useSelector } from 'react-redux'
import React, { useState,useEffect } from 'react'
import moment from 'moment'
import { fetchPost, fetchPosts, getPreviousPost } from '../services/firebase'
// import { useDispatch } from 'react-redux'
import { Link, useParams } from 'react-router-dom'
import { getCategory, goTop } from '../util'
import { useDispatch, useSelector } from 'react-redux'
import { updateMetadata, updatePosts } from '../stores/global';
import { LazyLoadImage } from "react-lazy-load-image-component";
import NotFound from './NotFound'

export default function Post() {
  const [post, setPost] = useState()
  const [previousNextPost, setPreviousNextPost] = useState()
  const dispatch = useDispatch()
  const categories = useSelector((state) => state.global.categories)
  const posts = useSelector((state) => state.global.posts)
  const meta = useSelector((state) => state.global.meta)
  const { post_url } = useParams()
  const postCategory = () =>{
    return getCategory(post.categories);
  }

  const getPreviousAndNextPosts = (id) => {
    getPreviousPost(id).then(data=> {
      setPreviousNextPost(data)
      return data;
    })
  }
  const getDate = (unix) => {
    const newDate = moment(unix * 1000).format()
    return newDate;  
  }

  const updateMeta = (data)=> {
    const postData = data;
    const postInfo = {
      title: postData.title,
      description: postData.title,
      canonical: window.location.href,
      meta: {
          charSet: 'utf-8',
          name: {
              keywords: postData.tags.join(","),
              robots: "index, follow"
          },
          property: {
              'og:title': postData.title,
              'og:type': 'article',
              'og:image': postData.header_image,
              // 'og:image:width': '',
              // 'og:image:height': '',
              'twitter:title': postData.title,
              'twitter:description': postData.title,
              'article:published_time': getDate(postData.publish_date.seconds),
              'article:author': 'admin',
              'article:tag': postData.tags.join(",")
          }
      }
    };
    const lastData = {...meta,...postInfo};
    //console.log("Son Veri",lastData)
    dispatch(updateMetadata(lastData));
    return lastData
  }

  //Get Post Data
  useEffect(() => {
    console.log("Post Link ->",post_url)
    console.log("Posts",posts)
    const data = posts.filter(post=> post.link === post_url).shift()
    console.log(data)
    setPreviousNextPost()
    if(data) {
      console.log("Storedan Çektim")
      setPost(data)
      console.log(data)
      updateMeta(data)
      getPreviousAndNextPosts(data)
    } else {
      console.log("DB DEN Çektim")
      fetchPost(post_url).then(data => {
        console.log("Gelen Data",data)
        setPost(data)
        return data;
      }).then((data)=> {
        getPreviousAndNextPosts(data)
        console.log("Home Meta Yüklendi");
        updateMeta(data)
      }).then((data)=> {//Fetch Another Posts
        fetchPosts(true).then((data)=> {
          dispatch(updatePosts(data))
        })
      })
    } // eslint-disable-next-line
  },[post_url]);

  if (post && post.title && post.header_image && categories) { //&& post.categories
    return (
      <>
        <Content></Content>
      </>
    );
  } else if (post === undefined) {
      console.log("404")
     return <NotFound></NotFound>;
  } else {
    return (
    'Loading Post...'
    );
  }

  function Content() {
    const PostContents = post.content.map((content, index) => {
      switch (content.type) {
        case 'text':
          return <div key={index} dangerouslySetInnerHTML={{ __html: content.value }}></div>
        case 'images':
          return content.value.map((image, imageIndex) => (<LazyLoadImage key={imageIndex} alt={post.title} src={image}></LazyLoadImage>))
        default:
          return null
      }
    })
    return <>
    {  NavBar() }
    <article className="post-listing post type-post status-publish format-standard has-post-thumbnail  category-thumbnail tag-article tag-author tag-post tag-video" id="the-post">
      <div className="post-inner">
        {Title()}
        {PostMeta()}
        <div className="clear" />
        <div className="entry">
          <div style={{textAlign: 'center'}}> {PreviusNextPosts()}</div>
          {/* { getImageUrl(post.header_image) !== undefined ? <LazyLoadImage width={350} height={350} src={getImageUrl(post.header_image).image} className="attachment-tie-medium size-tie-medium wp-post-image" alt={post.title}/>: ""} */}
          { post.header_image ? <LazyLoadImage width={350} height={350} src={post.header_image} className="attachment-tie-medium size-tie-medium wp-post-image" alt={post.title}/>: ""}
          <div className="clear" />
          {
            PostContents
          }
          {/* { PostContent(post.content) } */}
        </div>
        {ShareSocialMedia()} 
        <div className="clear" />
      </div>
    </article>
      {PostTags()}
    </>
  }

  function Title() {
    return <h1 className="name post-title entry-title">
      <span itemProp="name">{post.title}</span>
    </h1>
  }

  function PostTags() {
    return <p className="post-tag">Tags
      {post.tags.map((tag,index) => (
        <Link onClick={() => goTop()} key={index} to={process.env.REACT_APP_SEARCH_PREFIX + tag} rel="nofollow">{tag}</Link>
      ))}
    </p>
  }

  function ShareSocialMedia() {
    return <div className="share-post">
      <span className="share-text">Share</span>
      <ul className="flat-social">
        <li><a title="share to twitter" href={'https://twitter.com/intent/tweet?text=' + post.title + '&url=' + window.location.href} className="social-twitter" rel="noopener noreferrer" target="_blank"><i className="fa fa-twitter"></i> <span>Twitter</span></a></li>
        <li><a title="share to facebook" href={'http://www.facebook.com/sharer.php?u=' + window.location.href} className="social-facebook" rel="noopener noreferrer" target="_blank"><i className="fa fa-facebook"></i> <span>Facebook</span></a></li>
        <li><a title="share to pinterest" href={'http://pinterest.com/pin/create/button/?url=' + window.location.href + '&description=' + post.title + '&media=' + post.image} className="social-pinterest" rel="noopener noreferrer" target="_blank"><i className="fa fa-pinterest"></i> <span>Pinterest</span></a></li>
        <li><a title="share to linkedin" href={'http://www.linkedin.com/shareArticle?mini=true&url=' + window.location.href + '&title=' + post.title} className="social-linkedin" rel="noopener noreferrer" target="_blank"><i className="fa fa-linkedin"></i> <span>LinkedIn</span></a></li>
      </ul>
      <div className="clear" />
    </div>
  }

  function PreviusNextPosts() {
    return <div>
      { previousNextPost && previousNextPost.previousPost ? <Link to={process.env.REACT_APP_POST_PREFIX + previousNextPost.previousPost.link} title="previus post"><LazyLoadImage className="alignnone size-medium tie-appear" src="/css/images/previous.gif" alt="previus" width={150} height={55} /></Link>:"" }
      { previousNextPost && previousNextPost.nextPost ? <Link to={process.env.REACT_APP_POST_PREFIX + previousNextPost.nextPost.link} title="next post"><LazyLoadImage className="alignnone size-full tie-appear" src="/css/images/next.gif" alt="next" width={150} height={55} /></Link> :"" }
    </div>
  }

  function PostMeta() {
    return <p className="post-meta">
      <span className="post-cats"><i className="fa fa-folder" />
      <Link to={process.env.REACT_APP_CATEGORY_PREFIX + postCategory().slug} rel="category">{postCategory().name}</Link>
      </span>
    </p>
  }
  function NavBar() {
    return <nav id="crumbs"><Link rel="home" to="/">
        <span className="fa fa-home" aria-hidden="true" /> Home</Link>
        <span className="delimiter">/</span>
        <a rel="category" href={process.env.REACT_APP_CATEGORY_PREFIX + postCategory().slug}>{postCategory().name}</a>
        <span className="delimiter">/<span className="current">{post.title}</span></span>
      </nav>
  }
}


