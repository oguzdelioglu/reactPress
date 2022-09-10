import { createSlice } from '@reduxjs/toolkit'

export const globalSlice = createSlice({
  name: 'global',
  initialState: {
    posts : [],
    postPerPage: 5,
    categories : [],
    meta : {
        title: 'Testing',
        description: 'Testing Description',
        canonical: '',
        meta: {
          charset: '',
          name: {
            keywords: 'testing,testing2,testing3'
          }
        }
    }
  },
  reducers: {
    updateMetadata: (state, action) => {
      state.meta = action.payload
    },
    updateCategories: (state, action) => {
        state.categories = action.payload
    },
    updatePosts: (state, action) => {
      console.log("Payload:",action.payload)
      state.posts = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updateCategories , updateMetadata, updatePosts } = globalSlice.actions

export default globalSlice.reducer