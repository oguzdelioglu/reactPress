// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// import { getDatabase } from "firebase/database";
// import { getAnalytics } from "firebase/analytics";
// eslint-disable-next-line
import { getFirestore, collection, getDocs } from 'firebase/firestore/lite';
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
// eslint-disable-next-line
// const analytics = getAnalytics(app);
const db = getFirestore(app);

// Get a list of Settings from your database
// async function getSettings(db) {
//     const settingsCol = collection(db, 'settings');
//     const settingSnapshot = await getDocs(settingsCol);
//     const settingList = settingSnapshot.docs.map(doc => doc.data());
//     return settingList;
// }

export default db;
export var getSettings = async (db)=> {
    console.log("DB>>",db)
    const settingsCol = collection(db, 'settings');
    const settingSnapshot = await getDocs(settingsCol);
    const settingList = settingSnapshot.docs.map(doc => doc.data());
    return settingList;
}