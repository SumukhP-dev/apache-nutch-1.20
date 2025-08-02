<script>
import Button from 'primevue/button'
import axios from 'axios'
import store from './store.js'
import { filter, QueryParser, ReferenceResolver } from 'lucene-kit'

export default {
  methods: {
    getData() {
      const response = axios
        .get('http://localhost:8983/solr/nutch/select?indent=true&q.op=OR&q=*%3A*&rows=2147483647')
        .then((response) => {
          let list = []
          // console.log(response.data.response.docs)

          let numOfDocumentsAdded = 1

          response.data.response.docs.forEach((doc) => {
            if (store.state.numOfCrawledDocuments >= numOfDocumentsAdded) {
              list.push({ id: numOfDocumentsAdded, url: doc.url, content: doc.content })
              numOfDocumentsAdded++
            }
          })

          // console.log(list.length)
          // console.log(store.state.numOfCrawledDocuments)

          store.state.list = list
          store.state.docs = list
        })
    },
    async crawlPages(seedURL, numOfDocuments) {
      console.log('1: ' + seedURL)
      console.log('2: ' + numOfDocuments)

      store.state.numOfCrawledDocuments = numOfDocuments
      const response = axios
        .get(`http://localhost:3000/script?seedURL=${seedURL}&numOfDocuments=${numOfDocuments * 2}`)
        .then((response) => {
          console.log('Time take to crawl' + numOfDocuments + ' urls: ' + response.data)
          window.alert('Time take to crawl ' + numOfDocuments + ' urls: ' + response.data + ' ms')
        })
    },
    async crawlPagesToPreviousIndex(seedURL, numOfDocuments) {
      const response = axios
        .get(
          `http://localhost:3000/script2?seedURL=${seedURL}&numOfDocuments=${numOfDocuments * 2}`,
        )
        .then((response) => {
          console.log('Time take to crawl' + numOfDocuments + ' urls: ' + response.data)
          window.alert('Time take to crawl ' + numOfDocuments + ' urls: ' + response.data + ' ms')
        })
      store.state.numOfCrawledDocuments =
        parseInt(store.state.numOfCrawledDocuments) + parseInt(numOfDocuments)
      console.log('3: ', store.state.numOfCrawledDocuments)
    },
  },
}
</script>

<script setup>
import { ref } from 'vue'
import store from './store.js'

let input = ref('')
function filteredList() {
  const $q = (q) => new QueryParser(q)

  let list = []
  // const data2 = [
  //   { id: 1, gender: 'Male', firstName: 'Ambrose', age: 47 },
  //   { id: 2, gender: 'Non-binary', firstName: 'Jarid', age: 15 },
  //   { id: 3, gender: 'Female', firstName: 'Corette', age: 55 },
  //   { id: 4, gender: 'Female', firstName: 'Kaleena', age: 77 },
  //   { id: 5, gender: 'Male', firstName: 'Brennen', age: 84 },
  // ]

  // console.log(data2)

  const data = []
  store.state.list.forEach((doc) => {
    console.log(doc == undefined || doc.content == undefined || doc.url == undefined)
    if (doc != undefined && doc.content != undefined && doc.url != undefined)
      data.push({ content: doc.content[0], url: doc.url[0] })
    console.log({ content: doc.content[0], url: doc.url[0] })
  })
  console.log(data)

  let inputText = input.value

  if (inputText == undefined || inputText.length == 0) {
    inputText = ' '
  }

  console.log(inputText)
  console.log(filter($q(`content:/V/`), data))

  let filteredList = filter($q(`content:/${inputText}/`), data)
  // console.log(`content:${input.value.toLowerCase()}`)
  // console.log(store.state.docs)
  console.log(filteredList)

  filteredList.forEach((doc) => {
    if (doc != undefined) {
      let text = doc.content

      console.log(input.value.toLowerCase())
      console.log(text.toLowerCase())
      let startingIndex = text.indexOf(input.value)
      if (startingIndex != undefined) {
        list.push(doc.url + ' ' + doc.content.substring(startingIndex, startingIndex + 60))
      }
    }
  })

  console.log(list)

  return list
}
</script>

<template>
  <div>
    <p>
      Crawler Setup <br />
      Seed URL:
    </p>
    <input v-model="seedURL" placeholder="" />
    <p>Number of documents:</p>
    <input v-model="numOfDocuments" placeholder="" />
    <br />
    <Button v-on:click="crawlPages(seedURL, numOfDocuments)" label="Submit" />
    <br />
    <Button v-on:click="crawlPagesToPreviousIndex(seedURL, numOfDocuments)" label="Add" />
    <br />
    <Button v-on:click="getData" label="Refresh Data" />
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
  <p>Searchbar Pages: {{ store.state.list.length }}</p>
  <input type="text" v-model="input" placeholder="Search docs..." />
  <div class="item doc" v-for="doc in filteredList()" :key="doc">
    <p>{{ doc }}</p>
  </div>
</template>
