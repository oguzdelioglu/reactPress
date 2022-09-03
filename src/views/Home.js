import { useSelector, useDispatch } from 'react-redux'
import React from 'react'
import { useEffect } from 'react'
import { fetchPosts } from '../services/firebase'
export default function Home() {
  useEffect(()=> {
    // fetchPosts(posts,postPerPage,dispatch)
  },[]);

  return (
    <div>
      Burası Home
    </div>
  )
}
