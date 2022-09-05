// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// eslint-disable-next-line
// import * as firestore from 'firebase/firestore';
import { getFirestore, collection, getDocs,query,orderBy,limit,startAt,where, startAfter } from 'firebase/firestore';
import { updatePaginationPosts } from "../stores/posts";


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

export const fetchPosts = async (lastVisible,postPerPage) => {
  console.log("lastVisible",lastVisible)
  console.log("postPerPage",postPerPage)
  
  const ref = collection(db,'posts')
  const q = query(ref,orderBy("post_date"),startAfter(lastVisible),limit(postPerPage));
  const querySnapshot = await getDocs(q);
  const postList = []
  querySnapshot.forEach((doc) => {
    postList.push(Object.assign(doc.data(),{"id":doc.id}))
  });
  return postList
}