import './App.css';
//MetaData
import DocumentMeta from 'react-document-meta';

//Template Components
import Container from './components/Container';
import Footer from './components/Footer';
import Header from './components/Header';
import Pagination from './components/Pagination';
import Sidebar from './components/Sidebar';

//Firebase Database
import db,{getSettings} from './services/firebase';

import React, { Component } from 'react'

function getHeader() {
  getSettings(db).then(result => {
    console.log("Sonuç.",result);
    var settings = result[0];

    console.log("Meta.",settings.meta);
    // document.title = settings.site_title;
    // document.description = settings.site_description;
    this.setState({
      meta: settings
    })
  })
}

export default class App extends Component {

  constructor(props){
    super();
    this.state={
        meta : {
        title: 'qweqwe',
        description: '',
        canonical: '',
        meta: {
          charset: '',
          name: {
            keywords: ''
          }
        }
      }
    }
    getHeader();
  }

  render() {
    return (
      <div class="root">
      <DocumentMeta {...this.state.meta}></DocumentMeta>
      <Header></Header>
      <Sidebar></Sidebar>
      <Container></Container>
      <Pagination></Pagination>
      <Footer></Footer>
    </div>
    )
  }
}