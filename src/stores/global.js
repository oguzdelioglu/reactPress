import { createSlice } from '@reduxjs/toolkit'

export const globalSlice = createSlice({
  name: 'global',
  initialState: {
    posts: [],
    documentSnapshots : [],
    postPerPage: 5,
    lastVisible: 0,
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
    updatelastVisible: (state, action) => {
      state.lastVisible = action.payload
    },
    updatePosts: (state, action) => {
      //Update Snapshot Data Object & Add Document ID to Object
      const postList = []
      action.payload.forEach((doc) => {
        const dataReplaced = doc.data()
        postList.push(Object.assign(dataReplaced,{"id":doc.id,//DATA DOCUMENT ID
        "date": doc.data().date.toDate().toISOString().substring(0,10)})) //TIMESTAMP REPLACE
      });
      //Update Snapshot Data Object End
      console.log("Gelen Veri",postList)
      state.posts = [...state.posts,...postList];
    },
    updateSnapshots: (state, action) => {
      state.documentSnapshots = action.payload
    },
  },
})

// Action creators are generated for each case reducer function
export const { updateCategories , updateMetadata, updatePosts , updatelastVisible, updateSnapshots } = globalSlice.actions

export default globalSlice.reducer