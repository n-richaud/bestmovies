# ReadMe

Symfony version used 3.4(LTS)

## API

### Create user 

Route :`/user`

method :`POST`

post body :

```
{
  "payload": {
    "login": "toto",
    "email": "test@test.com",
    "birthDate": "02/09/1993"
  }
}
```

exemple curl : 

```
curl --request POST \
  --url http://localhost:8000/user \
  --header 'content-type: application/json' \
  --data '{
  "payload": {
    "login": "toto",
    "email": "nicorich2@gmail.com",
    "birthDate": "02/09/1993"
  }
}'
```

### Post vote

Route :`/user/{id_user}/vote/{id_movie}`

method :`POST`

exemple curl : 

```
curl --request POST \
  --url http://localhost:8000/user/1/vote/1 \
  --header 'content-type: application/json'
```

### Delete vote

Route :`/user/{id_user}/vote/{id_movie}`

method :`DELETE`

exemple curl : 

```
curl --request DELETE \
  --url http://localhost:8000/user/1/vote/1 \
  --header 'content-type: application/json'
```

### Get user votes

Route :`/user/{id_user}/votes`

method :`GET`

exemple curl : 

```
curl --request GET \
  --url http://localhost:8000/user/1/votes \
  --header 'content-type: application/json'
```

### Get Best movies

Route :`/movies/best`

method :`GET`

exemple curl : 

```
curl --request GET \
  --url http://localhost:8000/movies/best \
  --header 'content-type: application/json'
```

### Get votes for movie

Route :`/movie/{id_movie}/votes`

method :`GET`

exemple curl : 

```
curl --request GET \
  --url http://localhost:8000/movie/1/votes \
  --header 'content-type: application/json'
```

