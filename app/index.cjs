const express = require('express')
const app = express()

app.get('/script', (req, res) => {
  const { seedURL, numOfDocuments } = req.query
  var startTime = new Date().getTime()

  console.log('1: ' + seedURL)
  console.log('2: ' + numOfDocuments)

  if (seedURL != undefined && numOfDocuments != undefined) {
    shell.exec(`cd ../../; ls; sh crawler/bin/startup.sh ${seedURL} ${numOfDocuments};`)
  }
  var endTime = new Date().getTime()

  res.send(endTime - startTime)
})

app.get('/script2', (req, res) => {
  const { seedURL, numOfDocuments } = req.query
  var startTime = new Date().getTime()

  console.log('1: ' + seedURL)
  console.log('2: ' + numOfDocuments)

  if (seedURL != undefined && numOfDocuments != undefined) {
    shell.exec(`cd ../../; ls; sh crawler/bin/startup2.sh ${seedURL} ${numOfDocuments};`)
  }
  var endTime = new Date().getTime()

  res.send(endTime - startTime)
})

const shell = require('shelljs')

const port = process.env.PORT || 3000
app.listen(port, () => {
  console.log(`Server listening on port ${port}`)
})
