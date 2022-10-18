const { initializeApp } = require("firebase/app");
const { getFirestore, doc, addDoc , setDoc, collection,Timestamp, getDocs,query,orderBy,limit, startAfter, where } = require('firebase/firestore');
const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const _ = require('lodash');
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
const port = process.env.PORT || 5000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.get('/api', (req, res) => {
  res.send({ author: 'Powered by Oğuz DELİOĞLU' });
});
app.post('/api', async (req, res) => {
  if(req.body && req.body.TYPE && req.body.data) {
    let postType = req.body.TYPE;
    let payload = req.body.data;
    let keys = Object.keys(payload);
    let obj = {};
    let i = 0;
    try 
    {
      _.forEach(payload, async data => {
        obj[keys[i]] = data;
        i++;
      })
      switch (postType) {
        case 'ADD_POST':
          const fixObj = await fixPost(obj)
          console.log(fixObj)
          if(!checkPost(fixObj)){
            res.status(402).send({status:"The data is not enough.",result: fixObj})
          } else {
            const result = await addPost(fixObj)
            if(result && result.id) {
              res.status(200).send({status:"Post Added",result: result.id})
            } else {
              res.status(402).send({status:"Post Not Added",result: result})
            }
          }
          break;
        default:
          console.log(`Sorry, we are out of ${postType}.`);
      }
      
     
    } catch(err) { res.end(JSON.stringify(err))}
  } else {
    res.status(200).send({status:"Info",result: "Welcome to API"})
  }
});
app.listen(port, () => console.log(`Server Listening on port ${port}`));

//Backend
const addPost = async (data) => {
  const postCollection = collection(db,"posts");
  const Snapshot = await getDocs(postCollection);
  const List = Snapshot.docs.map(doc => doc.data());
  const post = List.filter(p=> p.link === data.link).shift()
  if(!post) {
    return await addDoc(postCollection, data)
  } else {
    return "This Post Already Exist"
  }
}

const fixPost = async (obj) => {
  //Decide hit if not exist
  if(obj.hit == null) {
    obj.hit = 0
  }
  //Add Timestamp if null 
  if(obj.date == null || obj.date === '') {
    obj.date = Timestamp.now()
  }
  return obj;
}

const checkPost = (obj) => {
  const keyList = ["title","content","category","date","hit","image","link","published","tags"];
  const isOK = keyList.map(function(key) { return checkKey(obj,key) ? true : false }).find(result => result === false)
  return isOK === undefined ? true : false;
}

const checkKey = (obj, keyName) => {
  let keyExist = Object.keys(obj).some(key => key === keyName);
  return keyExist;
};

//https://firebase.google.com/docs/firestore/manage-data/add-data#web-version-9_3  For Firestore Commands