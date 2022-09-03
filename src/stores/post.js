import { createSlice } from '@reduxjs/toolkit'

export const postSlice = createSlice({
  name: 'post',
  initialState: {
    post : {},
  },
  reducers: {
    updatePost: (state, action) => {
      state.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePaginationPosts } = postSlice.actions

export default postSlice.reducer