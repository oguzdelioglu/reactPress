import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
import Pagination from '../components/Pagination';
import { updatePosts,clearPosts } from '../stores/global';
import { useParams } from 'react-router-dom';
import { getCategoryBySlug } from '../util';
import { updateMetadata } from '../stores/global';

export default function Category() {
  const [firstLoad,setFirstLoad] = useState(true)
  const [lastPage,setLastPage] = useState(false)
  const [loading,setLoading] = useState(false)
  const posts = useSelector((state) => state.global.posts)
  const categories = useSelector((state) => state.global.categories)
  const dispatch = useDispatch()
  const { category_slug } = useParams()

  const updateMeta = ()=> {
    const postInfo = {
      title: category_slug,
      description: category_slug,
      canonical: window.location.href,
      meta: {
          charSet: 'utf-8',
          name: {
              keywords: category_slug,
              robots: "index, follow"
          },
      }
    };
    dispatch(updateMetadata(postInfo));
    return postInfo
  }

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
      fetchPosts(firstLoad,category_id).then((data)=> {
        console.log("All Posts Received:",data)
        if(data.size === 0){
          console.log("Son Sayfa")
          setLastPage(true)
        } else {
          dispatch(updatePosts(data))
          updateMeta()
        }
        setFirstLoad(false)
        setLoading(false)
      })
    }
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
