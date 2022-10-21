import { configureStore } from '@reduxjs/toolkit'
import globalSlice from "./global";

export default configureStore({
  reducer: {
    global: globalSlice
  },
})