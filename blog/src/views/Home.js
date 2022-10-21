import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import Pagination from '../components/Pagination';
import { updatePosts } from '../stores/global';
import { getSettings } from '../services/firebase';
import { updateMetadata } from '../stores/global';

export default function Home() {
  // const postPerPage = useSelector((state) => state.global.postPerPage)
  const [firstLoad,setFirstLoad] = useState(true)
  const [lastPage,setlastPage] = useState(false)
  const [loading,setLoading] = useState(false)
  const posts = useSelector((state) => state.global.posts)
  const lastVisible = useSelector((state) => state.global.lastVisible)
  const dispatch = useDispatch()

  // const lastVisible = posts && posts.docs ? posts.docs[posts.docs.length - 1] : 0

  useEffect(()=> {
    setLoading(true)
    if(firstLoad) {
      getSettings().then((settings) => {
        dispatch(updateMetadata(settings));
        return settings;
      });
    }
    fetchPosts(firstLoad).then((data)=> {
      if(data.size === 0){
        console.log("Son Sayfa")
        setlastPage(true)
      } else {
        dispatch(updatePosts(data))
      }
      setFirstLoad(false)
      setLoading(false)
    })
  },[lastVisible]);
 
  return (
    <>
      <div className="post-listing archive-box">
        { posts.map((post) => <Article key={post.id} post={post}></Article>) }
      </div>
      <Pagination lastPage={lastPage} loading={loading}></Pagination>
    </>

  )
}
