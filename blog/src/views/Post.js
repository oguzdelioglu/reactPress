// import { useSelector } from 'react-redux'
import React, { useState,useEffect } from 'react'
import { fetchPost } from '../services/firebase'
// import { useDispatch } from 'react-redux'
import { Link, useParams } from 'react-router-dom'
import { slugify, getCategory } from '../util'
import { useDispatch, useSelector } from 'react-redux'
import { updateMetadata } from '../stores/global';
import { getImage } from '../services/firebase'


export default function Post() {
  const [contentIndex, setContentIndex ] = useState(0);
  const [imgUrls, setImgUrl] = useState([]);
  const [contents, setContent] = useState([]);
  const [post, setPost] = useState()
  const dispatch = useDispatch()
  const categories = useSelector((state) => state.global.categories)
  const posts = useSelector((state) => state.global.posts)
  const { post_url } = useParams()
  const postCategory = () =>{
    return getCategory(post.category);
  }
  const previusPost = ""
  const nextPost = ""

  // const getCategory =(id)=>{
  //   const category = categories.filter((category) => category.id === id).pop()
  //   return category
  // }

  const getImageUrl = (imgUrl) => {
    const result = imgUrls.filter(img => img.id === imgUrl).shift()
    // console.log("Resim Arama SOnucu",result,imgUrl)
    return result;
  }
  //Get Post Data
  useEffect(() => {
    console.log("Post Link ->",post_url)
    console.log("Posts",posts)
    const isExist = posts.filter(post=> post.link === post_url).shift()
    console.log(isExist)
    if(isExist) {
      console.log("Storedan Çektim")
      setPost(isExist)
    } else {
      console.log("DB DEN Çektim")
      fetchPost(post_url).then(data => {
        console.log("Gelen Data",data)
        setPost(data)
        return data;
      })
    }

  },[post_url, posts]);
    //Get Post Data
  useEffect(() => {
    console.log("IMG LER ",imgUrls)
  },[imgUrls]);


  useEffect(() => {
    console.log("Content Güncellendi",contents)
  },[contents]);


  //Metadata Update After Post data received
  useEffect(()=> {
    if(post && post.title && post.header_image) {
      const meta =  {
        title: post.title,
        description: post.title,
        canonical: window.location.href,
        meta: {
          charset: 'UTF-8',
          name: {
            keywords: post.tags.join(",")
          }
        }
      }
      console.log("New Metadata:",meta)
      dispatch(updateMetadata(meta))
      getImage(post.header_image).then(result =>{ setImgUrl(images => [...images, {id: post.header_image ,image:result}])})
      post.content.map(async function(data) {
        if(data.type === 'text') {
          return setContent(contents => [...contents, { type: data.type, value: data.value }])
        } else if(data.type === 'images') {
          data.value.map(async function(image) {
          return await getImage(image).then(function (result) {
              setContent(contents => [...contents, {type: data.type,value: result}])
            })
          })
        }
      })
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
  
  if (post && post.title && post.header_image && categories) { //&& post.category
    return (
      <>
        <Content></Content>
      </>
    );
  } else {
    return (
    'Loading Post...'
    );
  }

  function Content() {
    return <>
    {  NavBar() }
    <article className="post-listing post type-post status-publish format-standard has-post-thumbnail  category-thumbnail tag-article tag-author tag-post tag-video" id="the-post">
      <div className="post-inner">
        {Title()}
        {PostMeta()}
        <div className="clear" />
        <div className="entry">
          {/* <div style={{textAlign: 'center'}}> {PreviusNextPosts()}</div> */}
          { getImageUrl(post.header_image) !== undefined ? <img width={350} height={350} src={getImageUrl(post.header_image).image} className="attachment-tie-medium size-tie-medium wp-post-image" alt={post.title}/>: ""}
          <div className="clear" />
          {
            contents.map((content,index) => { 
              switch(content.type) {
                case 'text':
                  return <div key={index} dangerouslySetInnerHTML={{ __html: content.value }}></div>
                case 'images':
                  return <img key={index} alt={post.title} src={ content.value }></img>
                default:
                  return null
              }
            })
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


  function PostContent(content) {
    console.log("Gelen Content",content)
    content.map(function(data,index) {
      console.log("Valuesi",data.type)
      if(data.type === 'text') {
        console.log("Textteyim",data.value)
        return <div key={index} dangerouslySetInnerHTML={{ __html: data.value }}></div>
      }
      //if(data.type === 'images') data.value.map((image,imgIndex) => (<img key={imgIndex} alt={post.title} src={ image }></img>))
    })
  }

  function Title() {
    return <h1 className="name post-title entry-title">
      <span itemProp="name">{post.title}</span>
    </h1>
  }

  function PostTags() {
    return <p className="post-tag">Tags
      {post.tags.map((tag,index) => (
        <Link key={index} to={process.env.REACT_APP_SEARCH_PREFIX + tag} rel="nofollow">{tag}</Link>
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
      <Link to={process.env.REACT_APP_POST_PREFIX + previusPost} title="previus post"><img className="alignnone size-medium tie-appear" src="/css/images/previous.gif" alt="previus" width={150} height={55} /></Link>
      <Link to={process.env.REACT_APP_POST_PREFIX + nextPost} title="next post"><img className="alignnone size-full tie-appear" src="/css/images/next.gif" alt="next" width={150} height={55} /></Link>
    </div>
  }

  function PostMeta() {
    return <p className="post-meta">
      <span className="post-cats"><i className="fa fa-folder" />
      {/* <Link to={process.env.REACT_APP_CATEGORY_PREFIX + postCategory().slug} rel="category">{postCategory().name}</Link> */}
      </span>
    </p>
  }
  function NavBar() {
    return <nav id="crumbs"><Link rel="home" to="/">
        <span className="fa fa-home" aria-hidden="true" /> Home</Link>
        <span className="delimiter">/</span>
        {/* <a rel="category" href={process.env.REACT_APP_CATEGORY_PREFIX + postCategory().slug}>{postCategory().name}</a> */}
        <span className="delimiter">/<span className="current">{post.title}</span></span>
      </nav>
  }
}


