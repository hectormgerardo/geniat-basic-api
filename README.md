# geniat-basic-api
RESTful API project for my job application at Ingeniat S.A. de C.V.

### WORK IN PROGRESS

## BUGS:
* deleted posts can still be modified.
* Role system is yet to be implemented.


##	Endpoints

1. (POST) CREATE USER
	* ./api/new-user.php

	* request body example:
	`{
		"name": "john",
		"surname": "doe",
		"email": "john@doe.com",
		"pass": "superpassword",
		"role": "1"
	}`
	* known bugs: role is nullified, 4 by default.
2. (POST) LOGIN
	* ./api/login.php
	* request body example:
	`{
		"email": "john@doe.com",
		"pass": "superpassword"
	}`
	* notes: will return json with `jwt` param, this is the token that will be used in auth beared in the following requests. 

3. (POST) NEW POST
	* ./api/new-post.php
	* request body example:
	`{
		"title": "the great title",
		"description": "en un lugar de la mancha, de cuyo nombre no quiero acordarme"
	}`
	* date is default to current date.

4. (DELETE) DELETE POST
	* ./api/delete-post.php
	* specify the id in the params:
		`./api/delete-post.php?id=25&destroy=false`
	* notes: if destroy parameter is not specified it will default to false, which means that the post won't be deleted, but just flagged out.

5. (GET) ALL POST
	- will return all posts and show its author name(s) and identifier.
	* ./api/all-post.php
	* output parameters:
		```json
			[
			    {
			        "title": "the great title",
			        "description": "en un lugar de la mancha, de cuyo nombre no quiero acordarme",
			        "date": "0000-00-00 00:00:00",
			        "id": "5",
			        "name": "john",
			        "surname": "doe"
			    }
			]
		```


6. (PUT) UPDATE POST
	- change post content
	* ./api/update-post.php?title=the big title&description=description&user_id=1&id=25&date=2020-12-12 12:00:00




## TESTING THIS APPLICATION

```bash 
	php -S 127.0.0.1:8080
```

## DEPLOYS

(http://geniat-basic-api.herokuapp.com/api/)


## POSTMAN REQUEST COLLECTION

[postman json](http://geniat-basic-api.herokuapp.com/api/docs/geniat-basic-api.postman_collection.json])