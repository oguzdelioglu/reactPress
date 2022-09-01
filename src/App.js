import { useSelector, useDispatch } from 'react-redux'

//MetaData
import DocumentMeta from 'react-document-meta';

//Template Components
import Container from './components/Container';
import Footer from './components/Footer';
import Header from './components/Header';
import Pagination from './components/Pagination';
import Sidebar from './components/Sidebar';
import { updateMetadata } from './stores/metadata';

//Firebase Database
import db,{getSettings} from './services/firebase';

import React, { Component, useEffect } from 'react'

export default function App() {

const meta = useSelector((state) => state.meta.value)
const dispatch = useDispatch()

function getHeader() {
  getSettings(db).then(result => {
    console.log("Sonuç.",result);
    var settings = result[0];
    console.log("Meta.",settings.meta);
    dispatch(updateMetadata(settings));
  })
}

  useEffect(() => {
      getHeader();
  },[])

  return (
    <div class="root">
    <DocumentMeta {...meta}></DocumentMeta>
    <Header></Header>
    <Sidebar></Sidebar>
    <Container></Container>
    <Pagination></Pagination>
    <Footer></Footer>
  </div>
  )
}