import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import { updatePosts } from '../stores/global';
export default function Home() {
  // const postPerPage = useSelector((state) => state.global.postPerPage)
  const posts = useSelector((state) => state.global.posts)
  const dispatch = useDispatch()

  const lastVisible = posts && posts.docs ? posts.docs[posts.docs.length - 1] : 0

  useEffect(()=> {
    fetchPosts(lastVisible).then((data)=> {
      console.log("All Posts Received:",data)
      dispatch(updatePosts(data))
    })
  },[]);
 
  return (
    <div class="post-listing archive-box">
      { posts.map((post) => <Article key={post.id} post={post}></Article>) }
    </div>
  )
}
