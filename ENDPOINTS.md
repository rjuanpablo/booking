# API Endpoints

This document provides details on the API endpoints for the Booking System.

## Table of Contents

- [Student Endpoints](#student-endpoints)
- [Classroom Endpoints](#classroom-endpoints)
- [Lesson Endpoints](#lesson-endpoints)
- [Booking Endpoints](#booking-endpoints)

---

### Student Endpoints

#### 1. Get all students
- **Method**: `GET`
- **URL**: `http://localhost:8000/student`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve all students from the system.

#### 2. Create a new student
- **Method**: `POST`
- **URL**: `http://localhost:8000/student`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "name": "<student_name>"  // Name of the student
  }
  ```
- **Description**: Create a new student with the provided name.

#### 3. Get a specific student
- **Method**: `GET`
- **URL**: `http://localhost:8000/student/{id}`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve the details of a specific student by their ID.

#### 4. Update a student
- **Method**: `PUT`
- **URL**: `http://localhost:8000/student/{id}`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "name": "<updated_student_name>"  // Updated name of the student
  }
  ```
- **Description**: Update the details of a specific student by their ID.

#### 5. Delete a student
- **Method**: `DELETE`
- **URL**: `http://localhost:8000/student/{id}`
- **Description**: Delete a specific student by their ID.

---

### Classroom Endpoints

#### 1. Get all classrooms
- **Method**: `GET`
- **URL**: `http://localhost:8000/classroom`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve all classrooms from the system.

#### 2. Create a new classroom
- **Method**: `POST`
- **URL**: `http://localhost:8000/classroom`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "name": "<classroom_name>",       // Name of the classroom
    "capacity": <integer>             // Capacity of the classroom
  }
  ```
- **Description**: Create a new classroom with the provided name and capacity.

#### 3. Get a specific classroom
- **Method**: `GET`
- **URL**: `http://localhost:8000/classroom/{id}`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve the details of a specific classroom by its ID.

#### 4. Update a classroom
- **Method**: `PUT`
- **URL**: `http://localhost:8000/classroom/{id}`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "name": "<updated_classroom_name>",  // Updated name of the classroom
    "capacity": <integer>                // Updated capacity of the classroom
  }
  ```
- **Description**: Update the details of a specific classroom by its ID.

#### 5. Delete a classroom
- **Method**: `DELETE`
- **URL**: `http://localhost:8000/classroom/{id}`
- **Description**: Delete a specific classroom by its ID.

---

### Lesson Endpoints

#### 1. Get all lessons
- **Method**: `GET`
- **URL**: `http://localhost:8000/lesson`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve all lessons from the system.

#### 2. Create a new lesson
- **Method**: `POST`
- **URL**: `http://localhost:8000/lesson`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "classroom_id": <integer>,        // ID of the classroom
    "start_time": "<HH:MM:SS>",       // Start time of the lesson
    "end_time": "<HH:MM:SS>",         // End time of the lesson
    "date": "<YYYY-MM-DD>"            // Date of the lesson
  }
  ```
- **Description**: Create a new lesson with the provided details.

#### 3. Get a specific lesson
- **Method**: `GET`
- **URL**: `http://localhost:8000/lesson/{id}`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve the details of a specific lesson by its ID.

#### 4. Update a lesson (Currently not working)
- **Method**: `PUT`
- **URL**: `http://localhost:8000/lesson/{id}`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "classroom_id": <integer>,        // Updated ID of the classroom
    "start_time": "<HH:MM:SS>",       // Updated start time of the lesson
    "end_time": "<HH:MM:SS>",         // Updated end time of the lesson
    "date": "<YYYY-MM-DD>"            // Updated date of the lesson
  }
  ```
- **Description**: Update the details of a specific lesson by its ID.

#### 5. Delete a lesson
- **Method**: `DELETE`
- **URL**: `http://localhost:8000/lesson/{id}`
- **Description**: Delete a specific lesson by its ID.

---

### Booking Endpoints

#### 1. Get all bookings
- **Method**: `GET`
- **URL**: `http://localhost:8000/booking`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve all bookings from the system.

#### 2. Create a new booking
- **Method**: `POST`
- **URL**: `http://localhost:8000/booking`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "lesson_id": <integer>,  // ID of the lesson
    "student_id": <integer>  // ID of the student
  }
  ```
- **Description**: Create a new booking for the specified lesson and student.

#### 3. Get a specific booking
- **Method**: `GET`
- **URL**: `http://localhost:8000/booking/{id}`
- **Headers**: 
  - `Accept: application/json`
- **Description**: Retrieve the details of a specific booking by its ID.

#### 4. Update a booking
- **Method**: `PUT`
- **URL**: `http://localhost:8000/booking/{id}`
- **Headers**: 
  - `Content-Type: application/json`
- **Body**:
  ```json
  {
    "lesson_id": <integer>,  // Updated ID of the lesson
    "student_id": <integer>  // Updated ID of the student
  }
  ```
- **Description**: Update the details of a specific booking by its ID.

#### 5. Delete a booking
- **Method**: `DELETE`
- **URL**: `http://localhost:8000/booking/{id}`
- **Description**: Delete a specific booking by its ID.
