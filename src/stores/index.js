import { configureStore } from '@reduxjs/toolkit'
import metadataSlice from "./metadata";
import paginationSlice from './pagination';
// import postSlice from './post';

export default configureStore({
  reducer: {
    meta: metadataSlice,
    pagination: paginationSlice,
    // post: postSlice
  },
})