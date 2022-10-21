import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect,useState } from 'react'
import Article from '../components/Article';
import { updatePosts,clearPosts } from '../stores/global';
import { useParams } from 'react-router-dom';
import { updateMetadata } from '../stores/global';
import { searchKeyword } from '../services/firebase';

export default function Search() {
  const [lastPage,setLastPage] = useState(false)
  const posts = useSelector((state) => state.global.posts)
  const dispatch = useDispatch()
  const { keyword } = useParams()
  const updateMeta = ()=> {
    const postInfo = {
      title: keyword,
      description: keyword,
      canonical: window.location.href,
      meta: {
          charSet: 'utf-8',
          name: {
              keywords: keyword,
              robots: "noindex, nofollow"
          },
      }
    };
    dispatch(updateMetadata(postInfo));
    return postInfo
  }
 
  useEffect(()=> {
    dispatch(clearPosts())
  },[keyword]);

  useEffect(()=> {
    searchKeyword(keyword).then((data)=> {
      console.log("Search Posts Received:",data)
      if(data.size === 0){
        console.log("Son Sayfa")
        setLastPage(true)
      } else {
        dispatch(updatePosts(data))
        updateMeta()
      }
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
