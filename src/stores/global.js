import { createSlice } from '@reduxjs/toolkit'

export const globalSlice = createSlice({
  name: 'global',
  initialState: {
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
  },
})

// Action creators are generated for each case reducer function
export const { updateCategories , updateMetadata } = globalSlice.actions

export default globalSlice.reducer