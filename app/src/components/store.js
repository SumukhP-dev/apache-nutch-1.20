// store.js
import { createStore } from 'vuex'
const store = createStore({
  state: {
    docs: [],
    numOfCrawledDocuments: 0,
    list: [],
  },
})

export default store
