

<h1  align="center">Code igniter 4 REST starter</h1>
<p align="center">
	<img src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png"  alt="docker-logo"  width="120px" height="120px"/>
	<img  src="https://friconix.com/png/fi-onsuhx-codeigniter.png"  alt="code-igniter-logo" width="120px"  height="120px"/>
</p>

<center><strong>This build is based on the </strong> <a  href="https://hub.docker.com/_/php/"> official</a> <strong>PHP docker image</strong></center>

<p align="center">
	<a href="https://github.com/TANIAX/Code-Igniter-4-REST-Starter">Submit an issue</a>
</p>


## 🙌 Requirements

To use this, you'll need:

-   Docker / WSL2 (if you want to use it with Docker, this is the only requirement).
-   PHP v8.1.13
-   Node.js v18
-   Angular CLI v14
-   Composer
-   Oracle Instant Client


## ⚗️ Features

**Docker**

-   Apache 2
-   Nginx
-   Oracle
-   PHP-FPM

**Backend**

-   RESTful API
-   Swagger
-   Active Directory Integration 
-   JWT 
-   DTO 
-   XDebug 3.0
	
	
## 🚀Compilation 
Copy, rename, and edit these files to correspond with your needs:
	- **./.docker-compose .yml** to **./docker-compose .yml**
	- **./.docker/php/.Dockerfile** to **./.docker/php/Dockerfile**
	- **./back-php/env** to  **./back-php/.env**
	
  ### docker

    cd ./ Code-Igniter-4-REST-Starter && docker-compose up
**Debug**



To activate **vscode** debug mode, you need the project in the 

then you need to install the **php debug extension** then in the launch.json file, place these lines in the configurations

```
{
"name": "Listen on Docker for Xdebug",
"type": "php",
"request": "launch",
"port": 9003,
"pathMappings":
{
"/var/www/html": "${workspaceFolder}"
}
}
```

http://localhost:81/docs
  ### without docker
-  cd ./ Code-Igniter-4-REST-Starter/back-php 
- composer install
- php spark serve

# 🏁 Getting started

 - **Introduction**

	 - Before you begin, it's essential to thoroughly review all the CodeIgniter documentation to get started with this template. 				Take a brief overview of what is used and what's not in our template to focus your attention on key points.
	  - In the getting started guide, we will provide an overview of every key point to help you quickly get started with a new project.
   

 - **Database configuration**

	- This project is set up to run with an Oracle database. I've chosen not to use an ORM, but you are welcome to use one if you prefer. CodeIgniter is Doctrine compatible. For testing purposes, we are configuring the project to work with SQLite for enhanced portability.

	-   **SQLite**
	    
	    -   Run the following commands:
	        -   `php spark migrate`
	        -   `php spark db:seed TodoSeeder`
	    -   The database file should be created in the `writable/database` directory.
	-   **Oracle**
	    
	    -   Place your `tnsadmin.admin` and `sqlnet.ora` files into an `admin` folder (`./.docker/oracle/admin`).

	For both scenarios, remember to edit the `.env` file located in the `back-php` directory.


 -  **Routes**

		-   To create a new route, add it to the `$routes` object in the `App/Config/Routes.php` file. The entry typically follows this format: `$routes->get('mycontroller', 'MyControllerController::index');`
		-   For more detailed operations, I suggest referring to the CodeIgniter 4 documentation.
   

 - **Controllers**

	**ApiController**
	-   Before anything else, I strongly recommend examining the `ApiController.php` file. Inside, you'll find two methods, **error** and **success**, which will help you handle various response scenarios in your API.
	-   This controller also has a `$config` and `$mapper` variable, which will be useful in an `automapping` scenario you may need in the future.
	-   Pay close attention to what happens in the `constructor` of this parent controller. This is where you'll need to return in the future for registering your mapping configuration between `stdClass` objects and `DTO` objects. In this example, we also have a custom mapper called `LowerCaseMapper`, but you can create any mapper you need.

	**New Controller**

	 - Create a new controller in the `App\Controller\API\V1` directory.
	 - Your controller should **inherit** from `ApiController` and use the `ResponseTrait` for proper functionality.
	 - If you need to **perform database operations**, you will require a **repository**. This concept doesn't exist in standard CodeIgniter logic, but I personally believe that working with custom code will offer us more possibilities than using CodeIgniter models (which are not used in this template).
	 - To **instantiate the repository**, create a protected or private variable in your new controller. In the constructor of your controller, initialize it like this: `$this->myRepoRepository = service('repository', 'MyRepo')`.
	 - Create a method and implement your own logic.
 
- **Repositories**

	**Base repository**
	 - This class called serves as a base class for all repositories. It implements an interface called `IRepository` and defines several methods that are common to all repositories, such as `getAll`, `getById`, `insert`, `update`, `delete`, and `deleteRange`. These methods are abstract, which means that they are not implemented in this class, but must be implemented in the derived classes.
	-   The class also defines several constants that are used to specify the type of result to return from the repository methods. These constants are `RESULT_AS_OBJECT`, `RESULT_AS_ARRAY`, and `RESULT_AS_CUSTOM`. They are intended to be used in your child repository when you are trying to obtain results using the `getResultAs` method.
	    
	-   ❗❗❗❗ The `getResultAs` method offers the possibility to transform SQL results into a specific class. To implement such a feature in a 1:1 format for a database driver other than SQLite or Oracle, you need to extend the CodeIgniter framework. To do this, you can refer to how the class `App\Libraries\CodeIgniterExtension\Database\SQLite\CustomResult.php` has been created and attempt to implement a similar solution if you are using a different database driver.	

	**New Repository**
	- Create a new repository in the `App\Repositories` directory.
	 - Your repository should **inherit** from `BaseRepository` and implements the `IRepository` interface.
	 - You basicly do what ever you need to in this class, the main purpose of this is to place the sql request, how ever you want to execute it (code igniter standart or vanilla php) the important thing is to use the `getResultAs` method with the correct arguments and return back the result to your controller.

├───Config
│   ├───Boot
│   └───Mapper
├───Controllers
│   └───API
│       └───V1
├───Database
│   ├───Migrations
│   └───Seeds
├───DTO
│   ├───Request
│   │   ├───Auth
│   │   └───Todo
│   └───Response
│       ├───Auth
│       └───Todo
├───Entities
├───Filters
├───Helpers
├───Interfaces
├───Language
│   └───en
├───Libraries
│   ├───AD
│   ├───CodeIgniterExtension
│   │   └───Database
│   │       └───SQLite3
│   └───HTTP
├───Models
├───Repositories
├───Swagger
├───ThirdParty
└───Views
    ├───errors
    │   ├───cli
    │   └───html
    └───swagger
