import { createSlice } from '@reduxjs/toolkit'

export const postSlice = createSlice({
  name: 'post',
  initialState: {
    post: {},
  },
  reducers: {
    updatePost: (state, action) => {
      state.post.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePost } = postSlice.actions

export default postSlice.reducer