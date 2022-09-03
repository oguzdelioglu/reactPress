// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// import { getDatabase } from "firebase/database";
// import { getAnalytics } from "firebase/analytics";
// eslint-disable-next-line
import { getFirestore, collection, getDocs } from 'firebase/firestore/lite';
import { updatePaginationPosts } from "../stores/pagination";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
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
  const settingsCol = collection(db, 'settings');
  const settingSnapshot = await getDocs(settingsCol);
  const settingList = settingSnapshot.docs.map(doc => doc.data());
  return settingList[0];
}

export const fetchPost = async () => {

  const postCol = collection(db, 'posts');
  const postSnapshot = await getDocs(postCol);
  const postList = postSnapshot.docs.map(doc => doc.data());
  return postList;
  // const postList = await collection(db,'posts').where('post_link', '==', 'denemekonusu').get();
  // postList.forEach(doc => {
  //   console.log(doc.id, '=>', doc.data());
  // });

  // const query = collection(db,'posts')
  // const postSnapshot = await getDocs(query);
  // const postList = postSnapshot.docs.map(doc => doc.data());
  // .where('post_link', '==', 'denemekonusu')

  // ..
 //this.setState({postList})
}

export const fetchPosts = async (posts,postPerPage,dispatch) => {
  // State.
  // const { posts, postPerPage} = state

  // Last Visible.
  const lastVisible = posts && posts.docs[posts.docs.length - 1]
  console.log("lastVisible:",lastVisible)
  // Query.
  const query = collection(db,'posts')
    .orderBy('post_date')
    .startAfter(lastVisible)
    .limit(postPerPage)

  // Posts.
  const postList = await query.get()

  console.log("Sonuç",postList)

  // ..
  return postList //this.setState({postList})
  //return dispatch(updatePaginationPosts(postList)) //this.setState({postList})
}