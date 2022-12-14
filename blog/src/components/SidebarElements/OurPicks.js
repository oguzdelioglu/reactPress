import React from 'react'
import { useSelector } from 'react-redux'
import PickWidget from './PickWidget'

export default function OurPicks() {
    const post_url = window.location.pathname.split('/')[2] //Fetch All Our Picks exclude Current Post
    console.log("Post Url",post_url);
    const posts = useSelector((state) => state.global.posts)
  return (
    <div className="e3lan-widget-content">
        <div className="widget-top">
            <h2>Our Picks</h2>
            <div className="stripe-line" /></div>
            { [...posts].filter(post => post.link !== post_url).sort(() => Math.random() - 0.5).slice(0, 2).map((post,index) => <PickWidget key={index} post={post}></PickWidget>)}
    </div>
  )
}
