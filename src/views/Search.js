import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import { fetchPosts, searchKeyword } from '../services/firebase'
import Article from '../components/Article';
import Pagination from '../components/Pagination';
import { updatePosts,clearPosts } from '../stores/global';
import { useParams } from 'react-router-dom';
import { getCategoryBySlug } from '../util';
export default function Search() {
  const [firstLoad,setFirstLoad] = useState(true)
  const [lastPage,setlastPage] = useState(false)
  const [loading,setLoading] = useState(false)
  const posts = useSelector((state) => state.global.posts)
  const dispatch = useDispatch()
  const { keyword } = useParams()

  useEffect(()=> {
    dispatch(clearPosts())
  },[keyword]);

  useEffect(()=> {
    setLoading(true)
    searchKeyword(keyword).then((data)=> {
      console.log("Search Posts Received:",data)
      if(data.size === 0){
        console.log("Son Sayfa")
        setlastPage(true)
      } else {
        dispatch(updatePosts(data))
      }
      setFirstLoad(false)
      setLoading(false)
    })
  },[keyword]);

  return (
    <>
      <div className="post-listing archive-box">
        { posts.map((post) => <Article key={post.id} post={post}></Article>) }
      </div>
    </>

  )
}
