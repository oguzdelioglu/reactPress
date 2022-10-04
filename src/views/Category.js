import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import Pagination from '../components/Pagination';
import { updatePosts,clearPosts } from '../stores/global';
import { useParams } from 'react-router-dom';
import { getCategoryBySlug } from '../util';
export default function Category() {
  const [firstLoad,setFirstLoad] = useState(true)
  const [lastPage,setlastPage] = useState(false)
  const [loading,setLoading] = useState(false)
  const posts = useSelector((state) => state.global.posts)
  const categories = useSelector((state) => state.global.categories)
  const lastVisible = useSelector((state) => state.global.lastVisible)
  const dispatch = useDispatch()
  const { category_slug } = useParams()

  // useEffect(()=> {


  // },[firstLoad])

  useEffect(()=> {
    dispatch(clearPosts())
  },[category_slug]);

  useEffect(()=> {
    setLoading(true)
    if(categories.length === 0) {
      console.log("Henüz kategoriler Yüklenmedi")
    } else {
      console.log("Kategoriler Yüklendi.",categories)
      const category_id = getCategoryBySlug(category_slug).id;
      console.log(category_slug)
      console.log(category_id)
      // if(firstLoad) {
      //   console.log("İlk Yüklemede Postları Sildiriyoruz.")
      //   dispatch(clearPosts())
      // }
      fetchPosts(firstLoad,category_id).then((data)=> {
        console.log("All Posts Received:",data)
        if(data.size === 0){
          console.log("Son Sayfa")
          setlastPage(true)
        } else {
          dispatch(updatePosts(data))
        }
        setFirstLoad(false)
        setLoading(false)
      })
    }
    // setTimeout(() => { // simulate a delay

    // }, 3000);
    
  },[categories]);

  return (
    <>
      <div className="post-listing archive-box">
        { posts.map((post) => <Article key={post.id} post={post}></Article>) }
      </div>
      <Pagination lastPage={lastPage} loading={loading}></Pagination>
    </>

  )
}
