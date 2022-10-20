import store from '../../stores/index.js';
import { config } from "./config.js";
import { initializeApp } from "firebase/app";
import { getStorage , ref , getDownloadURL  } from "firebase/storage";
import { getFirestore, collection, getDocs,query,orderBy,limit, startAfter, where , doc } from 'firebase/firestore';
import { updateSnapshots } from "../../stores/global.js";

// const store = require('../stores/index.js');
// const { getFirestore, collection, getDocs,query,orderBy,limit, startAfter, where } = require('firebase/firestore');
// const { updateSnapshots } = require("../stores/global.js");
// const { initializeApp } = require('firebase/app');

// Initialize Firebase
const app = initializeApp(config);
const db = getFirestore(app);
const storage = getStorage(app);
const postCollection = collection(db,"blog");
const settingCollection = collection(db,"settings");
const categoryCollection = collection(db, 'categories');

//Frontend
export const getSettings = async () => {
  const Snapshot = await getDocs(settingCollection);
  const List = Snapshot.docs.map(doc => doc.data());
  return List[0];
}


export const getImage = async (url) => {
  // var imageRef = storage().ref(url);
  const storageRef = ref(storage, `${url}`)
  //console.log("storageRef:",storageRef)
  var imageUrl = await getDownloadURL(storageRef);
  // console.log("Image URL:",imageUrl)
  return imageUrl;
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

export const fetchPosts = async (isFirst=false,category_id=null) => {
  const postPerPage = store.getState().global.postPerPage
  const documentSnapshots = store.getState().global.documentSnapshots
  const queryConstraints = []
  // const lastVisible = posts && posts.length>0 ? posts[posts.length - 1]:{date:null};
  const lastVisible = documentSnapshots && documentSnapshots.docs ? documentSnapshots.docs[documentSnapshots.docs.length-1] : {};
  console.log("last", lastVisible)
  console.log("postPerPage",postPerPage)


  if (category_id != null) {
    const categoryDocRef = doc(db, "categories", category_id);
    //const docSnap = await getDoc(categoryDocRef);
    queryConstraints.push(where('categories', 'array-contains', categoryDocRef))
  }
  

  if(isFirst) {
    console.log("First Loaded")
    // Query the first page of docs
    let first = query(postCollection,orderBy("publish_date"),limit(postPerPage), ...queryConstraints)
    const data = await getDocs(first)
    console.log("Fetch Post Data:",data)
    store.dispatch(updateSnapshots(data))
    return data;
  } else {
    console.log("Next Page Loaded")
    const next = query(postCollection,orderBy("publish_date"),startAfter(lastVisible),limit(postPerPage), ...queryConstraints);
    const data = await getDocs(next)
    store.dispatch(updateSnapshots(data))
    return data;
  }
}

export const searchKeyword = async (keyword) => {
    let first = query(postCollection,limit(10), where('tags', "array-contains", keyword))
    const data = await getDocs(first)
    console.log("Search Result:",data)
    store.dispatch(updateSnapshots(data))
    return data;
}