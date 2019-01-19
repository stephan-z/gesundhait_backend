# GesundHait Backend

- [Backend] (https://github.com/stephan-z/gesundhait_backend)
- [App] (https://github.com/stephan-z/gesundhait_app)

### Description
GesundHaiT is a private, non-commercial Project, developed by Stephan Ziesenis

The GesundHaiT Project is a Health App that provides tips for your daily Health, based on your everyday behaviour.
Therefore it connects to the Backend to store and retrieve Data from the MySQL-Database. 
The GesundHaiT Backend therefore provides a simple REST-Service.

### GesundHaiT-Backend is developed in PHP using Notepad++
#### GesundHaiT-Backend uses:
- XAMPP for local Apache and MariaDB/MySQL Server
- 'Rest Easy' Firefox Add-on for HTTP Service testing

### Provides the following Rest Services
```
URL                           HTTP Method  Operation
/index.php/users              GET          Returns an JSON-Array of all users
/index.php/users/2            GET          Returns the user with id of 2 as JSON
/index.php/users              POST         Adds a new user and returns the ID
/index.php/users/2            PUT          Updates the user with id of 2 and returns the affected lines
```

### JSON User:
```json
{
	"User":
	{
		"ID": int,
		"u_surname": string,	
		"u_forename": string,
		"u_number": string,
		"u_mail": string,
		"u_username": string,
		"u_password": string,
		"u_active": boolean,
		"u_created": string
	}
}
```

### JSON Users:
```json
{
	"Users":
	[
		{
			"User":
			{
				"ID": int,
				"u_surname": string,	
				"u_forename": string,
				"u_number": string,
				"u_mail": string,
				"u_username": string,
				"u_password": string,
				"u_active": boolean,
				"u_created": string
			}
		},
		{
			"User":
			{
				"ID": int,
				"u_surname": string,	
				"u_forename": string,
				"u_number": string,
				"u_mail": string,
				"u_username": string,
				"u_password": string,
				"u_active": boolean,
				"u_created": string
			}
		}
	]
}
```
