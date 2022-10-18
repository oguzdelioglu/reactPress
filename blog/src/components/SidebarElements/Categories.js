import React from 'react'
import { useSelector } from 'react-redux'

export default function Categories() {
    const categories = useSelector((state) => state.global.categories)
  return (
    <div className="widget widget_categories">
    <div className="widget-top">
      <h2>Categories</h2>
      <div className="stripe-line" />
    </div>
    <div className="widget-container">
      <ul>
        {
          categories.map((category,index)=> (
            <li key={index} className="cat-item"><a rel="category" href={process.env.REACT_APP_CATEGORY_PREFIX + category.slug}>{category.name}</a></li>
          ))
        }
      
      </ul>
    </div>
  </div>
  )
}
