# Basic authentication
## 1. <a name="auth_1"></a>Get user token
***ONLY FIRST TIME** user_token is static*

#### Make an *HTTP POST* request to
> api/get_user_token

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| username       | valid user name (API also provide register future - more information in "Create Account" section)
| password       | MD5 password hash ``MD5(password)`` (in order to prevent sniffing data from HTTP request)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| user_token     | **SAFE STORAGE IS REQUIRED** - unique user identifier, will be used as a part of user token hash

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| 3              | invalid username or password 

### Example
>	POST:<br/>
>	api/get_user_token<br/>
>   username=test&password=098f6bcd4621d373cade4e832627b4f6<br/>
>	RETURN:<br/>
>	{"user_token":"6e56c911aeac6e3bebb6f0341b929e88","is_error":false}<br/>

## 2. <a name="auth_2"></a>Get session token
*session token expires after 24 hours*

#### Make an *HTTP GET* request to
> api/get_session_token

### POST parameters
none

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| session_token  | should be stored as a local variable, will be used as a part of user token hash

### Handling possible exceptions
none

### Example
>	GET:<br/>
>	api/get_session_token<br/>
>	RETURN:<br/>
>	{"session_token":"8370d2bc133cf0d67d7329362a309ad2","is_error":false}<br/>

## 3. <a name="auth_3"></a>Authorization
*Assign session token to user (by user_token)*

#### Make an *HTTP POST* request to
> api/assign

### POST parameters
You must POST the following parameters

| **Parameter**   | **Description**
|:----------------|----------------------------------:|
| session_token   | key received in [step 2](#auth_2)
| user_token_hash | MD5 hash ``MD5(user_token+session_token)`` keys received in [step 1](#auth_1) and [step 2](#auth_2)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| status         | success state (if valid will return "succes")

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | invalid data (missing parameter)
| -1             | invalid user token hash
| 1              | session expired (you have to request for new token, most likely your token has expired)
| 2              | session already assigned (meaning you already have a valid token)

### Example
>	POST:<br/>
>	api/assign<br/>
>	session_token=8370d2bc133cf0d67d7329362a309ad2&user_token_hash=08b80beb8ecc63322de8435c538609d9<br/>
>	RETURN:<br/>
>	{"status":"succes","is_error":false}<br/>

---------

# Tasks

| **Type**          | **Description**
|:------------------|----------------------------------:|
| [create](#create) | create new task assign to logged user
| [update](#update) | edit existing task (by id)
| [delete](#delete)	| delete existing task (by id)
| [get](#get)	     	| get all tasks or get more data about specific task (by id)

## 1. <a name="create"></a>Create
#### Make an *HTTP POST* request to
> api/tasks/create

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| message        | Task description. Maximum length is 255 chars
| priority		   | integer value ``("1" for normal, "2" for high)`` priority
| status_id		   | integer value ``("0" for waiting, "1" for in progress, "3" for complete)`` status
| deadline		   | integer value (unix time)
| session_token	 | token value received in [basic authentication - step 2](#auth_2)
| signature		   | ``md5(API_SECRET_KEY+user_token+parms_string)`` [more](#signature)

### PARMS_STRING value 
> 	message=(message)&priority=(priority)&status_id=(status_id)&deadline-(deadline)&session_token=(session_token)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| status         | query result (if valid will return "succes")

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | validation error (invalid parameter). More information about error will be returned in [error_message field](#errors)
| 5 			       | invalid signature

### Example
>	POST:<br/>
>	api/tasks/create<br/>
>   ...<br/>
>	RETURN:<br/>
>	{"status":"succes","is_error":false}<br/>

## 2. <a name="update"></a>Update
#### Make an *HTTP POST* request to
> api/tasks/update

### POST parameters
You must POST the following parameters

| **Parameter**         | **Description**
|:----------------------|----------------------------------:|
| message *(optional)*  | Task description. Maximum length is 255 chars
| status_id	*(optional)*| integer value ``("0" for waiting, "1" for in progress, "3" for complete)`` status
| priority *(optional)* | integer value ``("1" for normal, "2" for high)`` priority
| deadline *(optional)* | integer value (unix time)
| task_id				        | integer value (task id)
| session_token	        | token value received in [basic authentication - step 2](#auth_2)
| signature		          | ``md5(API_SECRET_KEY+user_token+parms_string)`` [more](#signature)

### PARMS_STRING value
> 	[message=(message)&status_id=(status_id)...]&task_id=(task_id)&session_token=(session_token)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| status         | query result (if valid will return "succes")

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | validation error (invalid parameter). More information about error will be returned in [error_message field](#errors)
| 4 			       | task not found
| 5              | invalid signature

### Example
>	POST:<br/>
>	api/tasks/update<br/>
>   ...<br/>
>	RETURN:<br/>
>	{"status":"succes","is_error":false}<br/>

## 3. <a name="delete"></a>Delete
#### Make an *HTTP POST* request to
> api/tasks/delete

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| task_id        | integer value (task id)
| session_token	 | token value received in [basic authentication - step 2](#auth_2)
| signature		   | ``md5(API_SECRET_KEY+user_token+parms_string)`` [more](#signature)

### PARMS_STRING value
> 	task_id=(task_id)&session_token=(session_token)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| status         | query result (if valid will return "succes")

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | validation error (invalid parameter). More information about error will be returned in [error_message field](#errors)
| 4 			       | task not found
| 5              | invalid signature

### Example
>	POST:<br/>
>	api/tasks/delete<br/>
>   ...<br/>
>	RETURN:<br/>
>	{"status":"succes","is_error":false}<br/>

## 4. <a name="get"></a>Get all
#### Make an *HTTP POST* request to
> api/tasks/get

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| session_token	 | token value received in [basic authentication - step 2](#auth_2)
| signature		   | ``md5(API_SECRET_KEY+user_token+parms_string)`` [more](#signature)

### PARMS_STRING value
> 	session_token=(session_token)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| data			     | array of tasks assign to logged user

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | internal error
| 5              | invalid signature

### Example
>	POST:<br/>
>	api/tasks/delete<br/>
>   ...<br/>
>	RETURN:<br/>
>	{"tasks":[{"id":"12","message":"testowy","status_id":"0","priority":"1",updated":"1315673704",
>	"created":"1315673682","deadline":"1315673682"},{"id":"4","message":"testowy 2",
>	"status_id":"1","priority":"0",updated":"1315673604","created":"1315668369","deadline":"1315673682"},
>	{"id":"3","message":"testowy 3","status_id":"0","priority":"1","updated":"1315671630",
>	"created":"1315668324","deadline":"1315673682"}],"is_error":false}<br/>

## 5. Get task by id
#### Make an *HTTP POST* request to
> api/tasks/get

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| task_id        | integer value (task id)
| session_token	 | token value received in [basic authentication - step 2](#auth_2)
| signature		   | ``md5(API_SECRET_KEY+user_token+parms_string)`` [more](#signature)

### PARMS_STRING value
> 	task_id=(task_id)&session_token=(session_token)

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| data           | task

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | internal error
| 4 			       | task not found
| 5              | invalid signature

### Example
>	POST:<br/>
>	api/tasks/delete<br/>
>   ...<br/>
>	RETURN:<br/>
>	{"status":"succes","is_error":false}<br/>

---------

# Create account

#### Make an *HTTP POST* request to
> api/user/create

### POST parameters
You must POST the following parameters

| **Parameter**  | **Description**
|:---------------|----------------------------------:|
| username       | (4 to 200 **alphanumeric** chars)
| password		   | (4 to 25 chars)
| mail			     | valid email address

### Response data
Server will return the following data

| **Index**      | **Description**
|:---------------|----------------------------------:|
| status         | query result (if valid will return "succes")
| user_token     | in order to reduce numbers of queries, you can skip [step 1](#auth_1) in basic authentication  

### Handling possible exceptions
| **Code**       | **Description**
|:---------------|----------------------------------:|
| -1             | invalid parms
| 100 			     | invalid username
| 101 			     | invalid password
| 102 			     | invalid mail

### Example
>	POST:<br/>
>	api/user/create<br/>
>   username=test&pasword=test&mail=test@domain.com<br/>
>	RETURN:<br/>
>	{"status":"succes","user_token":"4f0747e538410","is_error":false}<br/>

---------

# <a name="signature"></a>Signature
signature is a way to protect data from being modyfied

## signature creation scheme is as follows:
1.	**sequence order is important**
2.	app should have API_SECRET_KEY as constant variable
3.	user_token should be stored in database
4.	parms_string md5 of all data sent (of course with session_token)

schema<br/>
``md5(API_SECRET_KEY+user_token+parms_string)``

ex. for following POST content<br/>
``session_token=8370d2bc133cf0d67d7329362a309ad2&message=test``

signature should looks like this<br/>
``md5(API_SECRET_KEY+user_token+"session_token=8370d2bc133cf0d67d7329362a309ad2&message=test")``

So the entire POST data should look like this<br/>
``session_token=8370d2bc133cf0d67d7329362a309ad2&message=test&signature=[signature]``

---------

# <a name="errors"></a>Errors 
schema<br/>
``{"is_error":true,"error_code":[code],"error_message":[message]}``
