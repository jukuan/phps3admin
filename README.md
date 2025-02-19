# PhpS3Admin

PhpS3Admin is a small web-based S3 explorer designed for easy and efficient management of any S3 storage. It provides a basic interface to navigate your S3 buckets and objects.

**This project is open source, and contributions are welcome. Feel free to contribute and help improve PhpS3Admin!**

## Features

- Simple and user-friendly interface
- Navigate and manage your S3 buckets and objects
- Open source and customizable

## Installation

You can use PhpS3Admin in Docker or without Docker.

### Using Docker

1. Ensure you have Docker installed on your system.
2. Run the `build.sh` script from the root directory to build and start the Docker containers:
3. Run the build `$ ./build.sh`
4. Access PhpS3Admin in your browser at `http://localhost:8283`.

### Without Docker

1. Clone the repository and navigate to the project directory.
2. Install the required dependencies using Composer:
3. Install vendors `$ composer install`
4. Configure your web server (e.g., Apache, Nginx) to serve the project.

## Configuration

### S3 Credentials

Place your `config.ini` file with S3 credentials in the root directory, or use the `.s3cfg` file from the `s3cmd` CLI command if you already have it. The project is able to autodetect the config file.

#### Example `config.ini` file:
```ini
[Credentials]
access_key = accessKey
secret_key = theVerySecretKey

[Server]
host_base = storage-XX.s3hoster.by
```

### Generating Configuration
You can also generate the configuration using the create_config script:

```bash
$ ./bin/create_config
```

Follow the prompts to enter your S3 credentials and save the configuration file.

## Command Line Mode (CLI)
Besides the web version, you can use the project in CLI mode. For example:

```bash
$ ./bin/cli.php buckets
```

## Contributing
We welcome contributions from the community! Feel free to open issues, submit pull requests, and suggest improvements.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.

If you have any questions or need further assistance, feel free to reach out.
