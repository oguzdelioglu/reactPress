import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import { updatePosts } from '../stores/global';
export default function Home() {
  // const postPerPage = useSelector((state) => state.global.postPerPage)
  const [firstLoad,setFirstLoad] = useState(true)
  const posts = useSelector((state) => state.global.posts)
  const lastVisible = useSelector((state) => state.global.lastVisible)
  const dispatch = useDispatch()

  // const lastVisible = posts && posts.docs ? posts.docs[posts.docs.length - 1] : 0

  useEffect(()=> {
    fetchPosts(firstLoad).then((data)=> {
      console.log("All Posts Received:",data)
      dispatch(updatePosts(data))
      setFirstLoad(false)
    })
    
  },[lastVisible]);
 
  return (
    <div className="post-listing archive-box">
      { posts.map((post) => <Article key={post.id} post={post}></Article>) }
    </div>
  )
}
