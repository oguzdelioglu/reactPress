import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import { updatePosts } from '../stores/posts';
export default function Home() {
  const postPerPage = useSelector((state) => state.posts.postPerPage)
  const posts = useSelector((state) => state.posts.posts)
  const dispatch = useDispatch()

  const lastVisible = posts && posts.docs ? posts.docs[posts.docs.length - 1] : 0

  useEffect(()=> {
    fetchPosts(lastVisible,postPerPage).then((data)=> {
      console.log("All Posts Received:",data)
      dispatch(updatePosts(data))
    })
  },[]);

  return (
    <div>
      { posts.map((post) => (<Article key={post.id} post={post}></Article>)) }
     Burası Home
    </div>
  )
}
