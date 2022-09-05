import { createSlice } from '@reduxjs/toolkit'

export const postsSlice = createSlice({
  name: 'pagination',
  initialState: {
    posts : [],
    postPerPage: 10,
  },
  reducers: {
    updatePosts: (state, action) => {
      state.posts = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePosts } = postsSlice.actions

export default postsSlice.reducer