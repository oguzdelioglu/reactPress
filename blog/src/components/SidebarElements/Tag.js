import React from 'react'

export default function Tag({tag}) {
  return (<a className="tag-cloud-link" rel="nofollow" href={process.env.REACT_APP_SEARCH_PREFIX + tag} style={{fontSize: '12pt'}}>{tag}</a>)
}
