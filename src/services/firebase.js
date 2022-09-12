import store from '../stores'

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// eslint-disable-next-line
// import * as firestore from 'firebase/firestore';
import { getFirestore, collection, getDocs,query,orderBy,limit, startAfter } from 'firebase/firestore';
import { updateSnapshots } from "../stores/global";


const firebaseConfig = {
  apiKey: "AIzaSyCJ7DLBntXHYdsX2EkLFX19ogvwe7lcq9g",
  authDomain: "edelsteineinformationen.firebaseapp.com",
  projectId: "edelsteineinformationen",
  storageBucket: "edelsteineinformationen.appspot.com",
  messagingSenderId: "784437932102",
  appId: "1:784437932102:web:7945a6d4a8f403186e5a47",
  measurementId: "G-E08C944VG0"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

export const getSettings = async () => {
  const Col = collection(db, 'settings');
  const Snapshot = await getDocs(Col);
  const List = Snapshot.docs.map(doc => doc.data());
  return List[0];
}

export const fetchCategories = async () => {
  const Col = collection(db, 'categories');
  const Snapshot = await getDocs(Col);
  const List = Snapshot.docs.map(doc => Object.assign(doc.data(),{"id":doc.id}));
  console.log("Kategoriler:",List)
  return List;
}

export const fetchPost = async (post_url) => {
  const Col = collection(db, 'posts');
  const Snapshot = await getDocs(Col);
  const List = Snapshot.docs.map(doc => doc.data());
  const post = List.filter(p=> p.post_link === post_url).shift()
  return post;
}


export const fetchPosts = async (isFirst=false) => {
  const collectionName = "posts"
  const postPerPage = store.getState().global.postPerPage
  const posts = store.getState().global.posts
  const documentSnapshots = store.getState().global.documentSnapshots
  // const lastVisible = posts && posts.length>0 ? posts[posts.length - 1]:{date:null};
  const lastVisible = documentSnapshots && documentSnapshots.docs ? documentSnapshots.docs[documentSnapshots.docs.length-1] : {};
  if(isFirst) {
    console.log("First Loaded")
    // Query the first page of docs
    const first = query(collection(db, collectionName),orderBy("date"),limit(postPerPage));
    const data = await getDocs(first)
    store.dispatch(updateSnapshots(data))
    // documentSnapshots = await getDocs(first);
  } else {
    console.log("Next Page Loaded")
    // Construct a new query starting at this document,
    // get the next 25 cities.
    const next = query(collection(db,collectionName),orderBy("date"),startAfter(lastVisible),limit(postPerPage));
    // documentSnapshots = await getDocs(next);
    const data = await getDocs(next)
    store.dispatch(updateSnapshots(data))
  }
  
  // Get the last visible document
  // const lastVisible = documentSnapshots.docs[documentSnapshots.docs.length-1];
  console.log("last", lastVisible);
  console.log("postPerPage",postPerPage)

  const postList = []
  documentSnapshots.forEach((doc) => {
    // postList.push(doc.data())
    const dataReplaced = doc.data()
    postList.push(Object.assign(dataReplaced,{"id":doc.id,//DATA DOCUMENT ID
    "date": doc.data().date.toDate().toISOString().substring(0,10)})) //TIMESTAMP REPLACE
  });



  // const ref = collection(db,collectionName)
  // const q = query(ref,orderBy("date"),startAfter(lastVisible.date),limit(postPerPage));
  // const querySnapshot = await getDocs(q);
  // const postList = []
  // querySnapshot.forEach((doc) => {
  //   const dataReplaced = doc.data()
  //   postList.push(Object.assign(dataReplaced,
  //   {"id":doc.id,//DATA DOCUMENT ID
  //   "date": doc.data().date.toDate().toISOString().substring(0,10)})) //TIMESTAMP REPLACE
  //   });
  // return postList
  return postList;
}


// export const fetchPosts = async () => {
  
//   const postPerPage = store.getState().global.postPerPage
//   const posts = store.getState().global.posts
//   const lastVisible = posts && posts.length>0 ? posts[posts.length - 1]:{date:null};
//   console.log("lastVisible",lastVisible)
//   console.log("postPerPage",postPerPage)
  
//   const ref = collection(db,'posts')
//   const q = query(ref,orderBy("date"),startAfter(lastVisible.date),limit(postPerPage));
//   const querySnapshot = await getDocs(q);
//   const postList = []
//   querySnapshot.forEach((doc) => {
//     const dataReplaced = doc.data()
//     postList.push(Object.assign(dataReplaced,
//     {"id":doc.id,//DATA DOCUMENT ID
//     "date": doc.data().date.toDate().toISOString().substring(0,10)})) //TIMESTAMP REPLACE
//     });
//   return postList
// }