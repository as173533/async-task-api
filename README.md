
# PHP REST API with Asynchronous Task Processing

This project is a simple RESTful API built using Laravel that handles computationally intensive tasks asynchronously. It allows clients to submit tasks, check the status of the tasks, and retrieve the result once the task is completed. The asynchronous processing is handled using Laravel Queues.

## Features

- **Task Submission**: Clients can submit tasks with specific input parameters.
- **Asynchronous Task Handling**: Tasks are processed asynchronously using Laravel Queues.
- **Task Status**: Clients can query the status of their submitted task (pending, processing, completed).
- **Task Result Retrieval**: Clients can retrieve the result of their task once it's completed.

## Requirements

- PHP >= 8.2
- Composer
- MySQL or SQLite for the database
- Laravel 12

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/yourusername/async-task-demo.git
   cd async-task-demo
   ```

2. **Install dependencies**:

   Run the following command to install all required dependencies via Composer:

   ```bash
   composer install
   ```

3. **Set up the environment**:

   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

4. **Generate the application key**:

   ```bash
   php artisan key:generate
   ```

5. **Set up the database**:

   Make sure you have the database set up in your `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

6. **Create the queue table**:

   If you're using a database queue, run the following Artisan command to generate the queue table:

   ```bash
   php artisan queue:table
   php artisan migrate
   ```

7. **Set up queue driver**:

   In your `.env` file, make sure to set the `QUEUE_CONNECTION` to `database` (or Redis if you prefer):

   ```env
   QUEUE_CONNECTION=database
   ```

8. **Start the queue worker**:

   To process jobs in the background, start the queue worker:

   ```bash
   php artisan queue:work
   ```

## API Endpoints

### 1. Submit Task

**POST** `/api/submit-task`

- **Request Body**:

  ```json
  {
    "task_input": "Some input data"
  }
  ```

- **Response**:

  ```json
  {
    "task_id": 1,
    "status": "pending"
  }
  ```

- **Description**: This endpoint accepts the task input and returns a `task_id` along with the status (`pending`). The task is queued for asynchronous processing.

---

### 2. Check Task Status

**GET** `/api/task-status/{task_id}`

- **Response**:

  ```json
  {
    "task_id": 1,
    "status": "completed",
    "result": "Task Completed Successfully"
  }
  ```

- **Description**: This endpoint allows you to check the status of a task using its `task_id`. The possible status values are `pending`, `processing`, and `completed`.

---

### 3. Retrieve Task Result

**GET** `/api/task-result/{task_id}`

- **Response**:

  ```json
  {
    "task_id": 1,
    "result": "Task Completed Successfully"
  }
  ```

- **Description**: Once the task is completed, you can use this endpoint to retrieve the result of the task.

## Running the Application

1. **Start the Laravel development server**:

   ```bash
   php artisan serve
   ```

2. **Access the API**:

   The API will be available at `http://127.0.0.1:8000`.

3. **Submit Tasks**:

   Use **Postman** or **cURL** to submit tasks to the API.

---

## Asynchronous Task Handling

The asynchronous task processing is handled using **Laravel Queues**. Here's a breakdown of the flow:

1. **Task Submission**: When a task is submitted via the `/submit-task` endpoint, a unique `task_id` is generated, and the task is queued for background processing.
2. **Job Processing**: The `ProcessTask` job is dispatched to the queue and processed asynchronously by a queue worker.
3. **Task Status**: The task's status is updated as it progresses through different stages: `pending`, `processing`, and `completed`.
4. **Task Result**: After the job finishes, the result is stored, and the task status is marked as `completed`. Clients can retrieve the result using the `/task-result/{task_id}` endpoint.

## Considerations for Scalability

- The queue system (such as `database` or `redis`) allows multiple workers to process tasks concurrently, which is useful for handling a large number of tasks.
- **Task retrying**: In a production environment, you can configure the queue worker to retry failed tasks with exponential backoff.

## Challenges Faced

- **Queue Configuration**: Setting up the queue system with database or Redis can sometimes be tricky due to different configurations and permissions. Ensure your environment is properly configured.
- **Task Duration**: Long-running tasks (like complex computations) might take some time. It's important to handle task timeouts or failures gracefully.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---

## Acknowledgements

- Laravel documentation and community for helpful resources and troubleshooting.
- [Queue Documentation](https://laravel.com/docs/8.x/queues) for understanding the queue system and background job handling.

---

### How to Run Locally

1. Clone the repo:

   ```bash
   git clone https://github.com/yourusername/async-task-demo.git
   cd async-task-demo
   ```

2. Install Composer dependencies:

   ```bash
   composer install
   ```

3. Set up your `.env` file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations:

   ```bash
   php artisan migrate
   ```

5. Start the queue worker:

   ```bash
   php artisan queue:work
   ```

6. Run the Laravel server:

   ```bash
   php artisan serve
   ```

Now, the API should be running at `http://127.0.0.1:8000`, and you can start interacting with the endpoints.

---
