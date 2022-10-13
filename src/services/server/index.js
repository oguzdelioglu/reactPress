const { addPost } = require('../firebase.js');
// import { addPost } from '../firebase.js'
// module.exports = require("../firebase.js");
// const parse = require('./firebase');
// const {addPost} = require('./firebase');

const express = require('express');
const bodyParser = require('body-parser');
const _ = require('lodash');

// const functions = require('firebase-functions');
// const admin = require('firebase-admin')
// const db = admin.firestore();

const app = express();
const port = process.env.PORT || 5000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.get('/api/hello', (req, res) => {
  res.send({ express: 'Hello From Express' });
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
  console.log(obj)
    await addPost(obj)
   //await db.collection('users').doc().set(obj);
  } catch(err) { res.send(JSON.stringify(err))}
  res.send('Success');

  // console.log(req.body);
  // const data = req.body;
  // if(data && data.title && data.content && data.category && data.date && data.hit && data.image && data.link && data.published && data.tags) {
  //   res.send(`I received your POST request. This is what you sent me:  ${JSON.stringify(data)}`,);
  // } else {
  //   res.send(`Your Post Data is not compatible:  ${JSON.stringify(data)}`,);
  // }
});

app.listen(port, () => console.log(`Listening on port ${port}`));