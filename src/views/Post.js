import { useSelector } from 'react-redux'
import React, { useEffect } from 'react'
import { fetchPost } from '../services/firebase'

export default function Post() {
  useEffect(() => {
    console.log("Post Çalıştım")
    fetchPost().then(data=> {
      console.log(data);
    })
  },[])
  const post = useSelector((state) => state.post)
  return (
    <div>
      Burası Post
        <h3>{ post.pin_title}</h3>
      
    </div>
  )
}