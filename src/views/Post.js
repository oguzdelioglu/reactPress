// import { useSelector } from 'react-redux'
import React, { useState,useEffect } from 'react'
import { fetchPost } from '../services/firebase'
// import { useDispatch } from 'react-redux'
import { useParams } from 'react-router-dom'

export default function Post() {
  const [post, setPost] = useState({})
  //const post = useSelector((state) => state.post.value)
  // const dispatch = useDispatch();
  const { post_link } = useParams();

  useEffect(() => {
    console.log("Post Link ->",post_link)
    fetchPost(post_link).then(data => {
      console.log(data)
      setPost(data)
      return data;
    })
   
    //dispatch(updatePost(data))
  },[post_link]);

  // useEffect(() => {
  //   console.log("Post Link ->",post_link)
  //   const data = fetchPost(post_link).then(data=> {
  //     //console.log(data);
  //     return data;
  //   })
  //   dispatch(updatePost(data))
  // }, []);



  
  return (
    <div>
      Burası Post
      {post}

      {/* { post ? <>
      <h3>{post.pin_title}</h3><img alt={post.pin_title} src={post.pin_img}>{post.pin_title}</img>
      </>:''} */}
                  
                  
    </div>
  )
}