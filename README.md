# Phonebook 

## Task:
Create phonebook in the internet;
* Each registered User can CRUD only his personal contacts;
* Every User can share his contact with other user (and remove sharing);
* Contacts has to have name and PhoneNumber;
* Progam has to have at least one Unit test;
* Program has to have atleast one feature test;
* Application has to be using docker;

Application can be implemented with GUI or API (you can choose both or either of them)

* Additional idea or proposal. 
---
## Set Up

1. `cd` to project directory
2. run `docker-compose up --build command`
3. run `docker ps` and copy PHP container ID
4. `docker exec -it <PHP container ID> bash`
5. run `bash install.sh`   

---
## What I added to app

If you really want to contact with your friend, colleague or etc. and do not know how tos start the conversation. This Phonebook will help you. It has 
integrated whether information at your friend`s city. 

Server has to run CronJob few times a day to update weather information in a database. To run it use
````
app:update-city-weather-temperatures
````

Also User can find his contacts by Name. Bellow you will find endpoint for that

---- 
## Registration and login
###Register

To register new account user has to send `POST` request to:
````
http:127.0.0.1:8000/api/v1/create-account
````

Request body has to be:
```json
{
    "email": "john@doe.com",
    "password": "secret"
}
```
### Login
To login user has to send ``POST`` request to:
```
http:127.0.0.1:8000/api/login_check
```

with JSON body:
```json
{
  "username": "user@user.com",
  "password": "labas"
}
```

and he will get back token which has to be added in every header. Token will look like this:

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MjU2NDE1MzEsImV4cCI6MTYyNTY0NTEzMSwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6InVzZXJAdXNlci5jb20ifQ.o-M7C8qB7RxUUvBUxYSAP-0mx7IKsWjAk8ky6dnlTeZTz3L58RYkUV6w4YbRSFt_K_-kLFRbjxxLgGIzrCjh8WbOB-GOBaaEOMAFG6-VeyhoCJOet_5oaN18cTKMUW1mcWDbFz_3UEFlU7310y-JIctTRS8gZK2B1TpWdWnLhUsvKqUMzKkyaO3QC0_wuBqM93tD4N_Jzme7at3iHYhuHRwG8kP3hUwZ_hqfyyO2nFJrYyCt-Ykn5RL-Eg6bs2jh5PGjOu-JHwY1OR-uzYbHwtc30Xwlk7POgc_4mPJPAw_vvElfWcJmX3LkURN6EVnpe-0nhmXKrKcP4oKffXCccA"
}
```

## CRUD through phonebook contacts

### Add new contact

User has to send `POST` request to:
```
http://127.0.0.1:8000/api/v1/phonebook
```

with Json body:
```json
{
    "name": "Bill",
    "lastName": "Gates",
    "phoneNumber": "+3706223323",
    "city": "Vilnius",
    "adress": "Verkiu 1"
}
```
### Get all contacts

User has to send `GET` request to:

```
http://127.0.0.1:8000/api/v1/phonebook
```

and he will get JSON response with his contacts similar to:
````json
"Your contacts": [
        {
            "Contact information": {
                "id": 59,
                "name": "Daumantas",
                "phoneNumber": "Maciulis",
                "sharedWith": [
                    {
                        "id": 2,
                        "email": "user@user.com"
                    }
                ],
                "lastName": "+3706223323",
                "city": "Vilnius",
                "adress": "Verkiu 1"
            },
            "Weather": {
                "Minimum temp": "18.8",
                "Maximum temp": "25.6"
            }
        }
    ],
    "Shared contacts": []
}
````

### Get one contact

### Get all contacts

User has to send `GET` request to:

```
http://127.0.0.1:8000/api/v1/phonebook/{contact_id}
```

and he will get response similar to:
````json
{
    "id": 59,
    "name": "Daumantas",
    "phoneNumber": "Maciulis",
    "sharedWith": [
        {
            "id": 2,
            "email": "user@user.com"
        }
    ],
    "lastName": "+3706223323",
    "city": "Vilnius",
    "adress": "Verkiu 1"
}
````

### Update contact

User has to send `PUT` request to:
```
http://127.0.0.1:8000/api/v1/phonebook/{contact_id}
```

wtih JSON body: 
````json
{
    "name": "Bill",
    "lastName": "Gates",
    "phoneNumber": "+3706223323",
    "city": "Vilnius",
    "adress": "Verkiu 1"
}
````

### Delete contact

To delete contact User has to send `DELETE` request to:
````
http://127.0.0.1:8000/api/v1/phonebook/{contact_id}
````

### Find contact by name

To find contact by name user has to send `GET` request to:
```
http://127.0.0.1:8000/api/v1/find
```
with JSON body:
```json
{
    "name": "John"
}
```

## Share contacts to other users

### Add shared contact

User has to send `POST` request to 
```
http://127.0.0.1:8000/api/v1/share
```

with Json body
```json
    "contactId": "19",
    "shareWith": "user@user.com"
}
```
where contactId is the ID of contact which he would like to share
where shareWith is the email address of user to share with.

### Remove shared contact

User has to send `DELETE` request to
```
http://127.0.0.1:8000/api/v1/share
```

with Json body
```json
    "contactId": "19",
    "shareWith": "user@user.com"
}
```
where contactId is the ID of contact which he would like to share
where shareWith is the email address of user to share with.