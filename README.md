<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Log Analyzer

### Project Description

Log Analyzer is a tool designed to process log files by extracting and saving important information. It analyzes log files, processes the data, and generates insightful reports. These reports include the number of requests by consumer, requests by service, and average times by service.

### Project Docs

- [Installation Guide](https://github.com/carloseduardorocha/log-analyzer/wiki/Installation-Guide) - step-by-step to install the project in your development host. <br/>
- [Processing Log Files](https://github.com/carloseduardorocha/log-analyzer/wiki/Processing-Log-Files) - step-by-step guide to processing log files, storing data in the database, and monitoring job progress using Laravel Horizon. <br/>
- [Generate Reports from Log Data](https://github.com/carloseduardorocha/log-analyzer/wiki/Generate-Reports-from-Log-Data) - guide to generating CSV reports from the processed log data, including requests by consumer, service, and average times by service. <br/>

### Useful Resources
- [Postman Documentation](https://documenter.getpostman.com/view/15465603/2sAYJ1mNeY) - access the Postman collection to test the API endpoints and streamline the testing process in your development environment. <br/>

### Technologies Docs

The project was made using the following technologies:<br/>

- [PHP 8.4](https://www.php.net/) - programming language <br/>
- [Laravel 11](https://laravel.com/docs/11.x) - web application PHP framework. <br/>

--- 

## 🚨 **Practical Test Execution Flow** 🚨

To ensure the correct execution of the practical test and successful integration of all components, **follow the steps below** in the exact order. This will guide you through installing the project, processing log files, generating reports, and documenting the entire process:

### 1. **Install the Project**
   - Follow the [Installation Guide](https://github.com/carloseduardorocha/log-analyzer/wiki/Installation-Guide) to install the project in your development environment.
   - Make sure all dependencies are properly set up, including configuring the database.

### 2. **Postman Documentation**
   - Use the [Postman Documentation](https://documenter.getpostman.com/view/15465603/2sAYJ1mNeY) to test the API endpoints.
   - The Postman collection will help you interact with the endpoints easily and streamline your testing process.

### 3. **Process Log Files**
   - Follow the [Processing Log Files](https://github.com/carloseduardorocha/log-analyzer/wiki/Processing-Log-Files) guide to process the log files.
   - This step involves uploading the log files, processing them, and storing the data in the database.
   - You can monitor the progress of the jobs through the Laravel Horizon dashboard.

### 4. **Generate Reports from Log Data**
   - After processing the log files, follow the [Generate Reports from Log Data](https://github.com/carloseduardorocha/log-analyzer/wiki/Generate-Reports-from-Log-Data) guide to generate the reports.
   - You will generate reports for requests by consumer, requests by service, and average times by service.
   - The generated reports will be saved in the `storage/app/public/reports` directory.
