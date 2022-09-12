import React from 'react'
import { useDispatch, useSelector } from 'react-redux';
import { Link } from 'react-router-dom';
import { updatelastVisible } from '../stores/global';

export default function Pagination() {
    const dispatch = useDispatch()
    const posts = useSelector((state) => state.global.posts)
    const postPerPage = useSelector((state) => state.global.postPerPage)
    const pageNumbers = [];
    const getPostTrigger = (visibleLength) => {
        dispatch(updatelastVisible(visibleLength))
    }

    for (let i = 1; i <= Math.ceil(process.env.REACT_APP_PAGINATION_MAX_POST / postPerPage); i++) {
        pageNumbers.push(i);
    }

  return (
    <div className="pagination">
            {/* <a href="currenturl?page=1" className="page">First</a>
            <span rel="prev" id="tie-prev-page"><a href="current?page=$prevpage">«</a></span>
            <span className="current">Current</span>
            <a href="currenturl?page=$x" className="page" title="başlık">2</a>
            <span id="tie-next-page"><a rel="next" href="currenturl?page=$nextpage"> » </a></span>
            <a href="&quot;.$current_url.&quot;?page=$totalpages"> Last </a> */}
            {
                pageNumbers.map((pageNumber) => {
                   return <Link key={pageNumber} onClick={() => getPostTrigger((pageNumber-1)*postPerPage)} to="#"  className="page">{pageNumber}</Link>
                })
            }
    </div>
  )
}
