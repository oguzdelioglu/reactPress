// const { addPost } = require('../firebase/index.js');
// import { addPost } from '../firebase/index.js'
// module.exports = require("../firebase.js");
// const parse = require('./firebase');
// const {addPost} = require('./firebase');
const { initializeApp } = require("firebase/app");
const { getFirestore, addDoc, collection,Timestamp, getDocs,query,orderBy,limit, startAfter, where } = require('firebase/firestore');
const express = require('express');
const bodyParser = require('body-parser');
const _ = require('lodash');


//Firestore
const firebaseApp = initializeApp({
  apiKey: "AIzaSyCJ7DLBntXHYdsX2EkLFX19ogvwe7lcq9g",
  authDomain: "edelsteineinformationen.firebaseapp.com",
  projectId: "edelsteineinformationen",
  storageBucket: "edelsteineinformationen.appspot.com",
  messagingSenderId: "784437932102",
  appId: "1:784437932102:web:7945a6d4a8f403186e5a47",
  measurementId: "G-E08C944VG0"
});
const db = getFirestore(firebaseApp);

// const functions = require('firebase-functions');
// const admin = require('firebase-admin')
// const db = admin.firestore();

const app = express();
const port = process.env.PORT || 5000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.get('/api', (req, res) => {
  res.send({ express: 'Powered by Oğuz DELİOĞLU' });
});

app.post('/api/post/add', async (req, res) => {
  let payload = req.body;
  let keys = Object.keys(payload);
  let obj = {};
  let i = 0;
  try {
    _.forEach(payload, async data => {
      obj[keys[i]] = data;
      i++;
    })


    //Decide hit if not exist
    if(obj.hit == null) {
      obj.hit = 0
    }
    //Add Timestamp if null 
    if(obj.date == null || obj.date === '') {
      obj.date = Timestamp.now()
    }

    console.log(obj)
    const result = await addPost(obj)
   //await db.collection('users').doc().set(obj);
   if(result && result.id) {
    res.status(200).send('Post Added:' + result.id);
   } else {
    res.status(402).send('Post Not Added:' + result);
   }
  } catch(err) { res.send(JSON.stringify(err))}

  // console.log(req.body);
  // const data = req.body;
  // if(data && data.title && data.content && data.category && data.date && data.hit && data.image && data.link && data.published && data.tags) {
  //   res.send(`I received your POST request. This is what you sent me:  ${JSON.stringify(data)}`,);
  // } else {
  //   res.send(`Your Post Data is not compatible:  ${JSON.stringify(data)}`,);
  // }
});

app.listen(port, () => console.log(`Listening on port ${port}`));

//Backend
const addPost = async (data) => {
  //console.log("Ekleme Başladı:",data)
  const result = await addDoc(collection(db, "posts"), data);
  // const result = await db.collection('posts').doc('one').set(data);
  // const result =  await db.collection('posts').doc().set(data);
  //console.log("Result:",result);
  return result;
}


//https://firebase.google.com/docs/firestore/manage-data/add-data#web-version-9_3  For Firestore Commands