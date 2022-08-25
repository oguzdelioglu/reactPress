import React, { Component } from 'react';

class Pagination extends Component {
    render() {
        return (
            <div>
                <div className="pagination">
                    <a href="currenturl?page=1" className="page">First</a>
                    <span rel="prev" id="tie-prev-page"><a href="current?page=$prevpage">«</a></span>
                    <span className="current">Current</span>
                    <a href="currenturl?page=$x" className="page" title="başlık">2</a>
                    <span id="tie-next-page"><a rel="next" href="currenturl?page=$nextpage"> » </a></span>
                    <a href="&quot;.$current_url.&quot;?page=$totalpages"> Last </a>
                </div>
            </div>
        );
    }
}

export default Pagination;