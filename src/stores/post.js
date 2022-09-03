import { createSlice } from '@reduxjs/toolkit'

export const postSlice = createSlice({
  name: 'post',
  initialState: {
    post : {
      pin_title: "Deneme 35"
    },
  },
  reducers: {
    updatePost: (state, action) => {
      console.log("Gelen Veri:",action.payload)
      state.post.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updatePost } = postSlice.actions

export default postSlice.reducer