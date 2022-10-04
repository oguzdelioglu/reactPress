import store from '../stores'

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// eslint-disable-next-line
// import * as firestore from 'firebase/firestore';
import { getFirestore, collection, getDocs,query,orderBy,limit, startAfter, where } from 'firebase/firestore';
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
const postCollection = collection(db,"posts");
const settingCollection = collection(db,"settings");
const categoryCollection = collection(db, 'categories');

export const getSettings = async () => {
  const Snapshot = await getDocs(settingCollection);
  const List = Snapshot.docs.map(doc => doc.data());
  return List[0];
}

export const fetchCategories = async () => {
  const Snapshot = await getDocs(categoryCollection);
  const List = Snapshot.docs.map(doc => Object.assign(doc.data(),{"id":doc.id}));
  console.log("Kategoriler:",List)
  return List;
}

export const fetchPost = async (post_url) => {
  const Snapshot = await getDocs(postCollection);
  const List = Snapshot.docs.map(doc => doc.data());
  const post = List.filter(p=> p.link === post_url).shift()
  return post;
}


export const fetchPosts = async (isFirst=false,category_slug=null) => {
  const postPerPage = store.getState().global.postPerPage
  const documentSnapshots = store.getState().global.documentSnapshots
  const queryConstraints = []
  // const lastVisible = posts && posts.length>0 ? posts[posts.length - 1]:{date:null};
  const lastVisible = documentSnapshots && documentSnapshots.docs ? documentSnapshots.docs[documentSnapshots.docs.length-1] : {};
  console.log("last", lastVisible)
  console.log("postPerPage",postPerPage)
  
  if (category_slug != null) queryConstraints.push(where('category', '==', category_slug))

  if(isFirst) {
    console.log("First Loaded")
    // Query the first page of docs
    let first = query(postCollection,orderBy("date"),limit(postPerPage), ...queryConstraints)
    // if(category_slug) first = first.where('category','==',category_slug)
    const data = await getDocs(first)
    console.log("Fetch Post Data:",data)
    store.dispatch(updateSnapshots(data))
    // documentSnapshots = await getDocs(first);
    return data;
  } else {
    console.log("Next Page Loaded")
    // Construct a new query starting at this document,
    // get the next 25 cities.
    const next = query(postCollection,orderBy("date"),startAfter(lastVisible),limit(postPerPage), ...queryConstraints);
    // documentSnapshots = await getDocs(next);
    const data = await getDocs(next)
    store.dispatch(updateSnapshots(data))
    return data;
  }
  
  // Get the last visible document
  // const lastVisible = documentSnapshots.docs[documentSnapshots.docs.length-1];


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