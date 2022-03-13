## Create User
POST /user<br>
*request*
```json
{
  "access_token": "token",
  "first_name": "your_name",
  "last_name": "your_last_name",
  "email": "your@mail.com",
  "application": "your_application"   
}
```
*request (with parent)*
```json
{
  "access_token": "token",
  "first_name": "your_name",
  "last_name": "your_last_name",
  "email": "your@mail.com",
  "application": "your_application",
  "parent_id": 1
}
```
*response OK*
```json
{
  "result":1,
  "userId":1
}
```
*response Not OK*
```json
{
  "result":0,
  "error":"email is invalid"
}
```

## Get User
GET /user/1<br>
*request*
```json
{
  "access_token": "token"
}
```
*response OK*
```json
{
  "result":1,
  "user": {
    "id":1,
    "first_name":"your_name",
    "last_name":"your_last_name",
    "email":"your@mail.com",
    "application":"your_application",
    "parent_id":null,
    "created_at":"2022-03-13 04:08:27",
    "updated_at":null,
    "deleted_at":null,
    "is_deleted":0
  }
}
```
*response Not OK*
```json
{
  "result":0,
  "error":"user not found"
}
```

## Update User
PUT /user/1<br>
*request*
```json
{
  "access_token": "token",
  "first_name":"your_name",
  "last_name":"your_last_name"
}
```
*response OK*
```json
{
  "result":1
}
```
*response Not OK*
```json
{
  "result":0,
  "error":"user not found"
}
```

## Delete User
DELETE /user/1<br>
*request*
```json
{
  "access_token": "token"
}
```
*response OK*
```json
{
  "result":1
}
```
*response Not OK*
```json
{
  "result":0,
  "error":"user not found"
}
```