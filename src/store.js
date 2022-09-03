import { configureStore } from '@reduxjs/toolkit'
import metadataSlice from "./stores/metadata";
import paginationSlice from './stores/pagination';
import postSlice from './stores/post';

export default configureStore({
  reducer: {
    meta: metadataSlice,
    pagination: paginationSlice,
    post: postSlice
  },
})