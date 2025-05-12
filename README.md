# Document API
## Register
```
POST : http://127.0.0.1:8000/api/register
{
    "name":"",
    "email":"",
    "password":"",
    "password_confirmation":""
}
```
## Login
```
POST : http://127.0.0.1:8000/api/login
{
    "email":"",
    "password":""
}
```
## Category
### Get All
```
GET : http://127.0.0.1:8000/api/category
```
### Create
```
POST : http://127.0.0.1:8000/api/category/create
Authorization Bearer {token}
{
    "name":"",
    "image":""
}
```
### Edit
```
PUT : http://127.0.0.1:8000/api/category/update/{categoryId}
Authorization Bearer {token}
{
    "name":"",
    "image":""
}
```
### Delete
```
DELETE : http://127.0.0.1:8000/api/category/delete/{categoryId}
Authorization Bearer {token}
```
## Review
### Get All
```
GET : http://127.0.0.1:8000/api/review
```
### create
```
POST : http://127.0.0.1:8000/api/review/create
Authorization Bearer {token}
{
    "rating":"",
    "comment":""
}
```
## Menu
### Get All
```
GET : http://127.0.0.1:8000/api/menu
```
### create
```
POST : http://127.0.0.1:8000/api/menu/create
Authorization Bearer {token}
{
    "name":"",
    "image":""
}
```
