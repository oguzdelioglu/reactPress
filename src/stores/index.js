import { configureStore } from '@reduxjs/toolkit'
import globalSlice from "./global";
// import postsSlice from './posts';
// import postSlice from './post';

export default configureStore({
  reducer: {
    global: globalSlice,
    // posts: postsSlice,
    // post: postSlice
  },
})