import { configureStore } from '@reduxjs/toolkit'
import metadataSlice from "./stores/metadata";

export default configureStore({
  reducer: {
    meta: metadataSlice,
  },
})