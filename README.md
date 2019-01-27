Cloud Storage / Symfony
========================
This repository contains a simple REST API that communicates with the Google Cloud Storage in order to fetch and store files in buckets.

Installation
------------

Clone this repository :

 ``
 git clone https://github.com/aelamel/Symfony_CloudStorage.git
 ``

Install the dependencies with composer

``
cd Symfony_CloudStorage && composer install
``

You may be asked to provide some configuration values (other than Symfony parameters) such as :

* **google_cloud_storage_private_key_location**: path to your service account credentials files.
* **release_notes_bucket_name**: The name of the bucket where you want to store you files/objects.

After that, you can run the application:

``
bin/console server:run
``

If you are a fun of Docker, there is a docker environment already working, all you have to do is to build and start the containers

**Important**
You must have docker and docker-compose installed on you system.

if you haven't them installed, you can check above links to do that.

Docker	[https://runnable.com/docker/install-docker-on-linux]

Docker-compose	[https://docs.docker.com/compose/install/#install-compose]

``
cd docker
``

``
cp .env.dist .env
``

Modify the .env file variables to your needs and the run:

``
docker-compose build && docker-compose up -d
``

After the container has started, the only thing remaining is to install dependencies and run the application

``
docker-compose exec php bash
``

If you face error running the docker-compose commads, run them with sudo.

Once inside the container run below commands : 

``
composer install
``

``
bin/console server:run 0.0.0.0
``


Enjoy!
