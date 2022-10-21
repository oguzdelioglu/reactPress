import { useSelector } from 'react-redux'
import { BrowserRouter as Router } from "react-router-dom";

//MetaData
import DocumentMeta from 'react-document-meta';

//Template Components
import Container from './components/Container';
import Footer from './components/Footer';
import Header from './components/Header';

//Firebase Database
import React, { useEffect } from 'react'

export default function App() {
  const meta = useSelector((state) => state.global.meta)
  useEffect(() => {
  }, []) // eslint-disable-line react-hooks/exhaustive-deps

  return (
    <div className="root">
    <Router>
      <DocumentMeta {...meta}></DocumentMeta>
      <Header></Header>
      <Container></Container>
      <Footer></Footer>
    </Router>
  </div>
  )
}