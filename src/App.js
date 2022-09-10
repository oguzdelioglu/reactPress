import { useSelector, useDispatch } from 'react-redux'

import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";

//MetaData
import DocumentMeta from 'react-document-meta';

//Template Components
import Container from './components/Container';
import Footer from './components/Footer';
import Header from './components/Header';
import Pagination from './components/Pagination';
import Sidebar from './components/Sidebar';
import { updateMetadata } from './stores/global';

//Firebase Database
import { getSettings } from './services/firebase';

import React, { useEffect } from 'react'

export default function App() {
  const meta = useSelector((state) => state.global.meta)
  const dispatch = useDispatch()

  useEffect(() => {
    //First load metadata settings
    
    // getSettings().then((settings) => {
    //   console.log(settings);
    //   dispatch(updateMetadata(settings));
    //   return settings;
    // });

  }, []) // eslint-disable-line react-hooks/exhaustive-deps

  return (
    <div className="root">
    <Router>
      <DocumentMeta {...meta}></DocumentMeta>
      <Header></Header>
      <Container></Container>
      <Pagination></Pagination>
      <Footer></Footer>
    </Router>
  </div>
  )
}