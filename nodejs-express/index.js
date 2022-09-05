const microgenV3 = require("microgen-v3-sdk")
const express = require('express')
const app = express()
const port = 3000

const client = new microgenV3.MicrogenClient({
  apiKey: "91b22a79-4800-44f0-8d6c-61b8f7627c23",
  url: "https://api.stagingv3.microgen.id"
})

app.get('/', (req, res) => {
  res.send('Hello World!')
})

app.get("/products", async (req, res) => {
  const response = await client.service('products').find()
  
  if(response.error) {
    return res.status(response.status).send(response.error)
  }

  res.status(response.status).send(response.data)
})

app.post("/products", async (req, res) => {
  const response = await client.service("products").create(req.body)
  
  if(response.error) {
    return res.status(response.status).send(response.error)
  }

  res.status(response.status).send(response.data)
})

app.patch("/products/:id", async (req, res) => {
  const id = req.params.id
  const body = {}

  const response = await client.service("products").updateById(id, body)
  
  if(response.error) {
    return res.status(response.status).send(response.error)
  }

  res.status(response.status).send(response.data)
})
  
app.delete("/products/:id", async (req, res) => {
  const id = req.params.id
  const body = {}

  const response = await client.service("products").updateById(id, body)
  
  if(response.error) {
    return res.status(response.status).send(response.error)
  }

  res.status(response.status).send(response.data)
})

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})