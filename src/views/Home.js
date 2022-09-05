import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect } from 'react'
import { fetchPosts } from '../services/firebase'
import Article from '../components/Article';
export default function Home() {
  useEffect(()=> {
    // fetchPosts(posts,postPerPage,dispatch)
  },[]);

  return (
    <div>
     <Article></Article> 
     Burası Home
    </div>
  )
}
