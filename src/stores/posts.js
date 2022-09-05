import { createSlice } from '@reduxjs/toolkit'

export const paginationSlice = createSlice({
  name: 'pagination',
  initialState: {
    posts : {},
    postPerPage: 10,
  },
  reducers: {
    updatePosts: (state, action) => {
      state.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePosts } = paginationSlice.actions

export default paginationSlice.reducer