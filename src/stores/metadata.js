import { createSlice } from '@reduxjs/toolkit'

export const metadataSlice = createSlice({
  name: 'metadata',
  initialState: {
    meta : {
        title: '',
        description: '',
        canonical: '',
        meta: {
          charset: '',
          name: {
            keywords: ''
          }
        }
    }
  },
  reducers: {
    updateMetadata: (state, action) => {
      state.value = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updateMetadata } = metadataSlice.actions

export default metadataSlice.reducer