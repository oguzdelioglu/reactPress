import { createSlice } from '@reduxjs/toolkit'

export const paginationSlice = createSlice({
  name: 'pagination',
  initialState: {
    posts : {},
    postPerPage: 10,
  },
  reducers: {
    updatePaginationPosts: (state, action) => {
      state.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePaginationPosts } = paginationSlice.actions

export default paginationSlice.reducer