import React from 'react'
import Categories from './SidebarElements/Categories'
import OurPicks from './SidebarElements/OurPicks'
import Tags from './SidebarElements/Tags'

export default function Sidebar() {
  return (
    <aside id="sidebar">
    <div className="theiaStickySidebar">
      <div className="widget">
      </div>
      <OurPicks></OurPicks>
      <Categories></Categories>
      <Tags></Tags>
      
    </div>
  </aside>
  )
}
