# API QA Challenge :rocket:
Welcome to the coding challenge :wave:

Thank you for applying for the QA Engineer position and for participating in our recruiting process. For this position, software development, testing and coaching skills are necessary for best fit with the development team. To evaluate your development and testing skills, we are asking you to complete this coding challenge and prepare to walk through it during our RecDay.

Besides, the challenge should give you an idea about potential upcoming tasks. 

Please push your solution into the repository at least 24 hours before the recruiting day. 

# Task
Imagine this is one of our APIs. 

- Create a test plan.
- Give us some examples of test implementation.
- Push your code into this repository or create your own.
- You can choose your way of implementation.
- We want to be able to execute your implemented tests.
  - Please provide a documentation file on how to run the project. 

If you have any questions or would like to understand certain areas in more depth, feel free to contact me: katrin.jaehn@celebrate.company 
This is not just a figure of speech but a serious offer :-) 

## Technical requirements :computer:
- MacOS ⌘ or Linux :penguin:
- Docker :whale2:
- Terminal :tv:
- Git :octocat:

## Get the API
In your terminal run 
```
git clone https://github.com/kartenmacherei/api-qa-challenge-<your initials>
```

## Start the server 
In your terminal go to the newly created folder 
```
cd api-qa-challenge
``` 
then run
```
make up
```
That will start a docker container with the API running, open your browser and go to http://localhost:8080/
if you see the message "Hello world!" everything is correctly setup.

## Stop the server
Run 
```
make stop
```

## Interfaces :warning:
### User Interface
| Attribute | Type | Description |
| ------- | ------- | ------- |
| id | number | User's ID |
| username | string | User's nickname |
| firstName | string | User's first name |
| lastName | string | User's last name |

### Product Interface
| Attribute | Type | Description |
| ------- | ------- | ------- |
| sku | string | Product's sku or ID |
| name | string | Product's name |
| unitPrice | float | Product's price per unit |
| mainImagePath | string | Product's main image |

### Error Interface
| Attribute | Type | Description |
| ------- | ------- | ------- |
| type | Constant | Error type [(list)](src/Application/Actions/ActionError.php) |
| description | string | Error message |

## The API :arrows_counterclockwise:
All responses use `Content-Type: application/json`

### Users -  Get all users 
This end point retrieves an array containing all users

#### HTTP Request
`GET http://localhost:8080/users`

#### HTTP Response
**Success 200** :heavy_check_mark:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the response |
| data | User[] | An array of Users objects |

Example:
```
GET http://localhost:8080/users
{
  "statusCode": 200,
  "data": [
    {
      "id": 1,
      "username": "bill.gates",
      "firstName": "Bill",
      "lastName": "Gates"
    },
    {
      "id": 2,
      "username": "steve.jobs",
      "firstName": "Steve",
      "lastName": "Jobs"
    }
  ]
}
```
### User -  Get user by id
This end point retrieves a user if found, or an error if not

#### HTTP Request
`GET http://localhost:8080/users/[id]`

| Field | Type | Description |
| --- | --- | --- |
| id | number | User's ID to find |

#### HTTP Response
**Success 200** :heavy_check_mark:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the response |
| data | User | A User object |

Example:
```
GET http://localhost:8080/users/1
{
  "statusCode": 200,
  "data": {
    "id": 1,
    "username": "bill.gates",
    "firstName": "Bill",
    "lastName": "Gates"
  }
}
```

**Error 404** :x:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the error |
| error | object | A "resource not found" error object |

Example:
```
GET http://localhost:8080/users/9999
{
  "statusCode": 404,
  "error": {
    "type": "RESOURCE_NOT_FOUND",
    "description": "The user you requested does not exist."
  }
}
```

### Products -  Get all products
This end point retrieves an array containing all the products

#### HTTP Request
`GET http://localhost:8080/products`

#### HTTP Response
**Success 200** :heavy_check_mark:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the response |
| data | Product[] | An array of Product objects |

Example:
```
GET http://localhost:8080/products
{
  "statusCode": 200,
  "data": [
    {
      "sku": "AOL01GG",
      "name": "product 1",
      "unitPrice": 10,
      "mainImagePath": "path\/to\/product1.jpg"
    },
    {
      "sku": "CEL02HL",
      "name": "product 2",
      "unitPrice": 10.5,
      "mainImagePath": "path\/to\/product2.jpg"
    }
  ]
}
```
### Product -  Get product by sku
This end point retrieves a product if found, or an error if not

#### HTTP Request
`GET http://localhost:8080/products/[sku]`

| Field | Type | Description |
| --- | --- | --- |
| sku | string | Product's SKU to find |

#### HTTP Response
**Success 200** :heavy_check_mark:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the response |
| data | Product | A Product object |

Example:
```
GET http://localhost:8080/products/AOL01GG
{
  "statusCode": 200,
  "data": {
      "sku": "AOL01GG",
      "name": "product 1",
      "unitPrice": 10,
      "mainImagePath": "path\/to\/product1.jpg"
  }
}
```

**Error 404** :x:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the error |
| error | object | A "resource not found" error object |

Example:
```
GET http://localhost:8080/products/FOOBAR
{
  "statusCode": 404,
  "error": {
    "type": "RESOURCE_NOT_FOUND",
    "description": "The product you requested does not exist."
  }
}
```

## Product -  Add a product
This end point saves a new product

#### HTTP Request
```
POST http://localhost:8080/products`
Content-Type: multipart/form-data
```
| Field | Type | Description |
| --- | --- | --- |
| sku | string | Product's SKU |
| name | string | Product's name |
| unitPrice | string | Product's unit price |
| mainImage | File | Product's main image |

#### HTTP Response
**Success 200** :heavy_check_mark:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the response |
| data | Product | The new Product object |

Example:
```
POST http://localhost:8080/products
{
  "statusCode": 200,
  "data": {
      "sku": "AOL02GG",
      "name": "product 1",
      "unitPrice": 10,
      "mainImagePath": "product1.jpg"
  }
}
```

**Error 400** :x:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the error |
| error | object | A "bad request" error object |

Example:
```
POST http://localhost:8080/products
{
  "statusCode": 400,
  "error": {
    "type": "BAD_REQUEST",
    "description": "The form is missing the parameter \"sku\""
  }
}
```

Example:
```
POST http://localhost:8080/products
{
  "statusCode": 400,
  "error": {
    "type": "BAD_REQUEST",
    "description": "WED05HKDL is not a valid sku"
  }
}
```

Example:
```
POST http://localhost:8080/products
{
  "statusCode": 400,
  "error": {
    "type": "BAD_REQUEST",
    "description": "Invalid \"unitPrice\" aaa, is not a float"
  }
}
```

**Error 500** :x:

| Field | Type | Description |
| --- | --- | --- |
| statusCode | number | The status code of the error |
| error | object | A "server error" error object |

Example:
```
POST http://localhost:8080/products
{
  "statusCode": 500,
  "error": {
    "type": "SERVER_ERROR",
    "description": "Image could not be uploaded"
  }
}
```
